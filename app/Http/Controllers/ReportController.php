<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function profitLoss()
    {
        return view('umkm.reports.profit_loss');
    }

    public function returnsCancellations()
    {
        return view('umkm.reports.returns_cancellations');
    }

    public function cashflow()
    {
        return view('umkm.reports.cashflow');
    }

    public function roas()
    {
        return view('umkm.reports.roas');
    }
} 