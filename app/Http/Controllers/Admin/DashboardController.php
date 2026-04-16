<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingLead;
use App\Models\PageView;
use App\Models\Photo;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $sevenDaysAgo  = now()->subDays(7)->toDateString();
        $thirtyDaysAgo = now()->subDays(30)->toDateString();

        $viewsToday    = PageView::whereDate('created_at', $today)
            ->distinct('session_id')->count('session_id');
        $views7Days    = PageView::whereDate('created_at', '>=', $sevenDaysAgo)
            ->distinct('session_id')->count('session_id');
        $views30Days   = PageView::whereDate('created_at', '>=', $thirtyDaysAgo)
            ->distinct('session_id')->count('session_id');
        $uniqueIpsToday = PageView::whereDate('created_at', $today)
            ->distinct('ip_address')->count('ip_address');

        $totalLeads    = BookingLead::count();
        $newLeads      = BookingLead::where('status', 'new')->count();
        $recentLeads   = BookingLead::latest()->take(5)->get();
        $recentViews   = PageView::latest()->take(10)->get(['ip_address', 'page', 'created_at']);
        $photosCount   = Photo::count();

        return view('admin.dashboard', compact(
            'viewsToday', 'views7Days', 'views30Days', 'uniqueIpsToday',
            'totalLeads', 'newLeads', 'recentLeads', 'recentViews', 'photosCount'
        ));
    }

    public function visitors()
    {
        $views = PageView::latest()->paginate(40);

        $totalViews = PageView::count();
        $uniqueIps  = PageView::distinct('ip_address')->count('ip_address');
        $today      = PageView::whereDate('created_at', now()->toDateString())->count();
        $thisWeek   = PageView::whereDate('created_at', '>=', now()->subDays(7)->toDateString())->count();

        // Device breakdown: unique IP per device type (same IP = 1 device)
        $uniqueVisitors = PageView::select('ip_address', DB::raw('MAX(user_agent) as user_agent'))
            ->groupBy('ip_address')
            ->get();

        $mobile = 0; $tablet = 0; $desktop = 0;
        foreach ($uniqueVisitors as $visitor) {
            $ua = strtolower($visitor->user_agent ?? '');
            if (str_contains($ua, 'ipad') || (str_contains($ua, 'android') && !str_contains($ua, 'mobile')) || str_contains($ua, 'tablet')) {
                $tablet++;
            } elseif (str_contains($ua, 'mobile') || str_contains($ua, 'iphone') || str_contains($ua, 'ipod') || str_contains($ua, 'blackberry') || str_contains($ua, 'windows phone')) {
                $mobile++;
            } else {
                $desktop++;
            }
        }

        $topPages = PageView::select('page', DB::raw('count(*) as visits'))
            ->groupBy('page')
            ->orderByDesc('visits')
            ->take(8)
            ->get();

        $topIps = PageView::select('ip_address', DB::raw('count(*) as visits'))
            ->groupBy('ip_address')
            ->orderByDesc('visits')
            ->take(8)
            ->get();

        return view('admin.visitors', compact(
            'views', 'totalViews', 'uniqueIps', 'today', 'thisWeek',
            'mobile', 'tablet', 'desktop', 'topPages', 'topIps'
        ));
    }
}
