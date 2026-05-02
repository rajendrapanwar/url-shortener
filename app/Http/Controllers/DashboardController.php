<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ShortUrl;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            return $this->superAdminDashboard();
        } elseif ($user->isAdmin()) {
            return $this->adminDashboard();
        } else {
            return $this->memberDashboard();
        }
    }

    private function superAdminDashboard()
    {
        $companies = Company::withCount('users')
            ->withCount('shortUrls')
            ->take(2)
            ->get();

        $totalCompanies = Company::count();

        $recentUrls = ShortUrl::with('company')
            ->latest()
            ->take(2)
            ->get();

        $totalUrls = ShortUrl::count();

        return view('dashboard.super-admin', compact(
            'companies',
            'totalCompanies',
            'recentUrls',
            'totalUrls'
        ));
    }

    private function adminDashboard()
    {
        $user = auth()->user();
        
        $totalUrls = ShortUrl::where('company_id', $user->company_id)->count();
        $totalMembers = \App\Models\User::where('company_id', $user->company_id)->count();
        
        $recentUrls = ShortUrl::where('company_id', $user->company_id)
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact('totalUrls', 'totalMembers', 'recentUrls'));
    }

    private function memberDashboard()
    {
        $user = auth()->user();
        
        $totalUrls = ShortUrl::where('user_id', $user->id)->count();
        
        $recentUrls = ShortUrl::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.member', compact('totalUrls', 'recentUrls'));
    }
}