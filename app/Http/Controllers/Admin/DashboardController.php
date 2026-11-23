<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function chartData()
    {
        // Cache the data for 60 seconds
        $data = Cache::remember('admin_dashboard_stats', 60, function () {
            $totalOrders = Order::count();
            $totalRevenue = Order::whereNotIn('status', ['pending', 'dibatalkan'])->sum('total_amount');
            $activeCustomers = User::where('role', 'customer')->count();

            // Revenue for the last 7 days
            $chartData = [];
            $labels = [];

            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i)->format('Y-m-d');
                $labels[] = Carbon::now()->subDays($i)->format('d M');
                
                $dailyRevenue = Order::whereNotIn('status', ['pending', 'dibatalkan'])
                    ->whereDate('created_at', $date)
                    ->sum('total_amount');
                    
                $chartData[] = $dailyRevenue;
            }

            return [
                'stats' => [
                    'totalOrders' => number_format($totalOrders, 0, ',', '.'),
                    'totalRevenue' => 'Rp ' . number_format($totalRevenue, 0, ',', '.'),
                    'activeCustomers' => number_format($activeCustomers, 0, ',', '.')
                ],
                'chart' => [
                    'labels' => $labels,
                    'data' => $chartData
                ]
            ];
        });

        return response()->json($data);
    }
}
