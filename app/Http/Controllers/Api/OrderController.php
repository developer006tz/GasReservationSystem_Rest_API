<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{


    public function getSupplierOrders(Request $request, $supplier_id)
    {
        $supplier = User::find($supplier_id);
        $orders = $supplier->orders()->with("SupplierOrders");
        return response()->json($orders, 200);
    }
}
