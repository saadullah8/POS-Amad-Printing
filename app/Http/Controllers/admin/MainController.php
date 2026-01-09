<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;

class MainController extends Controller
{

    public function index()
    {
        // Today stats
        $todaySale = Order::whereDate('created_at', today())->sum('total');
        $todayOrders = Order::whereDate('created_at', today())->count();

        // Monthly stats
        $monthSale = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        // Active services
        $activeServices = Service::where('status', 1)->count();

        // Recent orders (last 5)
        $recentOrders = Order::orderBy('id', 'desc')->limit(5)->get();

        $data = [
            'heading'        => 'Dashboard',
            'title'          => 'Dashboard',
            'active'         => 'dashboard',
            'todaySale'      => $todaySale,
            'todayOrders'    => $todayOrders,
            'monthSale'      => $monthSale,
            'activeServices' => $activeServices,
            'recentOrders'   => $recentOrders,
        ];

        return view('admin.dashboard.index', $data);
    }

    //
}
