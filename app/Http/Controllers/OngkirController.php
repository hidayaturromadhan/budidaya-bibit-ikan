<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OngkirController extends Controller
{
    /**
     * Get all provinces from RajaOngkir
     */
    public function getProvinces()
    {
        try {
            $provincesData = file_get_contents(storage_path('app/binderbyte_provinces.json'));
            $data = json_decode($provincesData, true);

            if ($data) {
                $provinces = array_map(function($p) {
                    return [
                        'province_id' => $p['id'],
                        'province' => $p['name']
                    ];
                }, $data);
                
                return response()->json($provinces);
            }
        } catch (\Exception $e) {
            \Log::error('BinderByte getProvinces Error: ' . $e->getMessage());
        }

        return response()->json([
            ['province_id' => '65', 'province' => 'Error: Gagal memuat data provinsi dari lokal']
        ]);
    }

    public function getCities($province_id)
    {
        try {
            $citiesData = file_get_contents(storage_path('app/binderbyte_cities.json'));
            $allCities = json_decode($citiesData, true);

            if (isset($allCities[$province_id])) {
                $cities = array_map(function($c) {
                    return [
                        'city_id' => $c['id'],
                        'type' => '',
                        'city_name' => $c['name']
                    ];
                }, $allCities[$province_id]);
                
                return response()->json($cities);
            }
        } catch (\Exception $e) {
            \Log::error('BinderByte getCities Error: ' . $e->getMessage());
        }

        return response()->json([]);
    }

    /**
     * Check shipping cost
     */
    public function checkCost(Request $request)
    {
        $request->validate([
            'destination' => 'required|string',
            'weight' => 'required|numeric',
            'courier' => 'required|string',
        ]);

        try {
            // Add 'c_' prefix for cities as required by BinderByte cost endpoint
            $origin = 'c_' . config('services.binderbyte.origin_city_id', '31.74'); // Default South Jakarta
            $destination = 'c_' . $request->destination;

            $response = Http::withoutVerifying()->timeout(10)->asForm()->post('https://api.binderbyte.com/v1/cost', [
                'api_key' => config('services.binderbyte.key'),
                'origin' => $origin,
                'destination' => $destination,
                'weight' => ceil($request->weight / 1000), // BinderByte uses kg
                'courier' => $request->courier
            ]);

            if ($response->successful() && isset($response['data']['results'][0]['costs'])) {
                $costs = $response['data']['results'][0]['costs'];
                
                $mappedCosts = array_map(function($c) {
                    // Extract days from string like "1-2 hari"
                    $etd = trim(str_replace('hari', '', strtolower($c['estimated'])));
                    return [
                        'service' => $c['service'],
                        'description' => $c['type'],
                        'cost' => [
                            [
                                'value' => (int)$c['price'],
                                'etd' => $etd,
                                'note' => ''
                            ]
                        ]
                    ];
                }, $costs);

                return response()->json($mappedCosts);
            }
        } catch (\Exception $e) {
            \Log::error('BinderByte checkCost Error: ' . $e->getMessage());
        }

        return response()->json([]);
    }
}
