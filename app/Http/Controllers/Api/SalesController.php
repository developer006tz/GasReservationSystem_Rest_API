<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ApiResponces;

class SalesController extends Controller
{
    use ApiResponces;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $sales = Sales::all();
            return $this->successResponse($sales, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
            $sale = Sales::create($request->all());
            return $this->successResponse($sale, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($saleId)
    {
        try {
            $sale = Sales::findOrFail($saleId);
            return $this->successResponse($sale, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $saleId)
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
            $sale = Sales::findOrFail($saleId);
            $sale->update($request->all());
            return $this->successResponse($sale, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sales $sale)
    {
        try {
            $sale->delete();
            return $this->successResponse(null, Response::HTTP_NO_CONTENT);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
