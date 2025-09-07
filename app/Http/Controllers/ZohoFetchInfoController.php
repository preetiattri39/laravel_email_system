<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ZohoFetchInfoController extends Controller
{
    public function __invoke(Request $request)
    {
        // Run the artisan command to fetch org/department IDs
        Artisan::call('zoho:fetch-info');
        return redirect()->back()->with('success', 'Zoho Desk Org/Department IDs fetched. Check your .env file.');
    }
}
