<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function search(Request $request)
    {

        $data = $request->input('search');
        $search = new SearchService($data);
        $resp = $search->search();
        Log::info($resp);
        return response()->json($resp);
    }
}
