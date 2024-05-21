<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Sales;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{

    public function createOrder(StoreOrderRequest $request){

        try {
            $order = new Sales();
            $order->fill($request->validated());
            $order->save();
            return response()->json($order, 201); 
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getClientOrders(Request $request, string $client_id)
    {
        $orders = Sales::where('client_id', $client_id)->get();
        return response()->json($orders);
    }

    public function getSupplierOrders(Request $request, $supplier_id)
    {
        $order = Sales::where('supplier_id', $supplier_id)->first();
        return response()->json($order);
    }

    public function getSingleOrder($orderId){
        $order = Sales::find($orderId);
        return response()->json($order);
    }

    public function updateOrder(Request $request, $orderId)
    {
        $request->validate([
            'supplier_id' => 'required',
            'customer_id' => 'required',
            'post_id' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'total_amount' => 'required'
        ]);

        try {
            $sale = Sales::findOrFail($orderId);
            $sale->update($request->all());
            return $this->successResponse($sale, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }


    public function deleteOrder(Request $request, $orderId)
    {
        try {
            $order = Sales::findOrFail($orderId);
            $order->delete();
            return $this->successResponse(null, Response::HTTP_NO_CONTENT);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
