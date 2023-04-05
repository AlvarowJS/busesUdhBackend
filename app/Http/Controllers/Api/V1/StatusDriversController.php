<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Driver;

class StatusDriversController extends Controller
{
    public function updateStatus(Request $request)
    {
        $driverId = Auth::user()->id;
        $driverName = Auth::user()->name;
        // Haz lo que necesites con el ID del driver

        return response()->json([
            'driver_id' => $driverId,
            'driver_name'=> $driverName
        ]);
    }
}
