<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;


class Analytics extends Controller
{
  public function index()
  {
    return URL::asset("files/X3BYjItXk6KMCXKyQkbLaHkpBwZB5RrOUgpjGXBy.doc");
    $listing_count = Listing::count();
    $listing_price = Listing::sum('price');
    $contracts_count = Contract::count();
    $contracts_price = Contract::sum('commission');
    return view('content.dashboard.dashboards-analytics', compact(
      'listing_count',
      'listing_price',
      'contracts_count',
      'contracts_price',
    ));
  }
}
