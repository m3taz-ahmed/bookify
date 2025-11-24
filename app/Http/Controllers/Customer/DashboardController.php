<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Service;

class DashboardController extends Controller
{
    /**
     * Display the customer dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('customer.dashboard');
    }
}