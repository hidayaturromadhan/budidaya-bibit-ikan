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
     * Check shipping cost (menggunakan data tarif dummy yang stabil & cepat untuk demo)
     */
    public function checkCost(Request $request)
    {
        $request->validate([
            'destination' => 'required|string',
            'weight' => 'required|numeric',
            'courier' => 'required|string',
        ]);

        $courier = strtolower($request->courier);
        $weightKg = max(1, (int) ceil($request->weight / 1000));

        // Data dummy tarif pengiriman yang realistis per kurir
        $dummyRates = [
            'jne' => [
                [
                    'service' => 'JNE REG',
                    'description' => 'Layanan Reguler',
                    'cost' => [
                        [
                            'value' => 18000 * $weightKg,
                            'etd' => '2-3',
                            'note' => ''
                        ]
                    ]
                ],
                [
                    'service' => 'JNE YES',
                    'description' => 'Yakin Esok Sampai',
                    'cost' => [
                        [
                            'value' => 32000 * $weightKg,
                            'etd' => '1',
                            'note' => ''
                        ]
                    ]
                ],
                [
                    'service' => 'JNE OKE',
                    'description' => 'Ongkos Kirim Ekonomis',
                    'cost' => [
                        [
                            'value' => 14000 * $weightKg,
                            'etd' => '3-5',
                            'note' => ''
                        ]
                    ]
                ],
            ],
            'tiki' => [
                [
                    'service' => 'TIKI REG',
                    'description' => 'Regular Service',
                    'cost' => [
                        [
                            'value' => 17000 * $weightKg,
                            'etd' => '2-3',
                            'note' => ''
                        ]
                    ]
                ],
                [
                    'service' => 'TIKI ONS',
                    'description' => 'Over Night Services',
                    'cost' => [
                        [
                            'value' => 30000 * $weightKg,
                            'etd' => '1',
                            'note' => ''
                        ]
                    ]
                ],
                [
                    'service' => 'TIKI ECO',
                    'description' => 'Economy Service',
                    'cost' => [
                        [
                            'value' => 12000 * $weightKg,
                            'etd' => '4-6',
                            'note' => ''
                        ]
                    ]
                ],
            ],
            'pos' => [
                [
                    'service' => 'POS Reguler',
                    'description' => 'Pos Reguler Nusantara',
                    'cost' => [
                        [
                            'value' => 15000 * $weightKg,
                            'etd' => '2-4',
                            'note' => ''
                        ]
                    ]
                ],
                [
                    'service' => 'POS Nextday',
                    'description' => 'Pos Express Next Day',
                    'cost' => [
                        [
                            'value' => 28000 * $weightKg,
                            'etd' => '1',
                            'note' => ''
                        ]
                    ]
                ],
            ],
            'khusus' => [
                [
                    'service' => 'Kurir Khusus Bibit (Beroksigen)',
                    'description' => 'Khusus Benih/Bibit Ikan Beroksigen & Garansi Hidup',
                    'cost' => [
                        [
                            'value' => 25000 * $weightKg,
                            'etd' => '1-2',
                            'note' => ''
                        ]
                    ]
                ]
            ],
        ];

        if (isset($dummyRates[$courier])) {
            return response()->json($dummyRates[$courier]);
        }

        // Fallback jika kurir lain
        return response()->json([
            [
                'service' => strtoupper($courier) . ' Reguler',
                'description' => 'Layanan Standar Pengiriman',
                'cost' => [
                    [
                        'value' => 20000 * $weightKg,
                        'etd' => '2-3',
                        'note' => ''
                    ]
                ]
            ]
        ]);
    }
}
