<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $sales = Order::with('items.fishSeedSize.fishSeed')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->whereNotIn('status', ['pending', 'dibatalkan'])
            ->get();

        $totalRevenue = $sales->sum('total_amount');

        $stockMovements = StockMovement::with('fishSeedSize.fishSeed')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.reports.index', compact('sales', 'totalRevenue', 'stockMovements', 'startDate', 'endDate'));
    }
}
