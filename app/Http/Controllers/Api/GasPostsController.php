<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gas;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ApiResponces;

class GasPostsController extends Controller
{
    use ApiResponces;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $gasPosts = Gas::query()->get();
            return $this->successResponse($gasPosts, Response::HTTP_OK);
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
            'gas_category_id' => 'required',
            'title' => 'required',
            'image' => 'nullable|file|mimes:jpg,png,webp,jpeg,svg',
            'location' => 'required',
            'in_stock' => 'required',
            'price' => 'required',
            'supplier_id' => 'required',
            'is_published' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        try {
            $gasPost = Gas::create($request->only(['gas_category_id', 'title', 'location', 'in_stock', 'price', 'supplier_id', 'is_published', 'latitude', 'longitude']));
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $file_name = upload_file($file);
                $gasPost->image = $file_name;
                $gasPost->save();
                $gasPost->refresh();
            }
            return $this->successResponse($gasPost, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($gasPostId)
    {
        try {
            $gasPost = Gas::findOrFail($gasPostId);
            return $this->successResponse($gasPost, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $gasPostId)
    {
        $request->validate([
            'gas_category_id' => 'required',
            'title' => 'required',
            'image' => 'nullable|file|mimes:jpg,png,webp,jpeg,svg',
            'location' => 'required',
            'in_stock' => 'required',
            'price' => 'required',
            'supplier_id' => 'required',
            'is_published' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        try {
            $gasPost = Gas::findOrFail($gasPostId);
            $gasPost->update($request->only(['gas_category_id', 'title', 'location', 'in_stock', 'price', 'supplier_id', 'is_published', 'latitude', 'longitude']));
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $file_name = upload_file($file);
                $gasPost->image = $file_name;
                $gasPost->save();
                $gasPost->refresh();
            }
            return $this->successResponse($gasPost, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gas $gas)
    {
        try {
            $gas->delete();
            return $this->successResponse(null, Response::HTTP_NO_CONTENT);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
