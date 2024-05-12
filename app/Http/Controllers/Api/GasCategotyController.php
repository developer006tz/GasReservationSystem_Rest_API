<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GasCategory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ApiResponces;

class GasCategotyController extends Controller
{
    use ApiResponces;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categories=GasCategory::query()->get()->toArray();
            return $this->successResponse($categories,Response::HTTP_OK);
        }catch (\Throwable $th)
        {
            return $this->errorResponse($th->getMessage(),Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>['required'],
            'image'=>['nullable','file','mimes:jpg,png,webp,jpeg,svg']
        ]);
        try {
            $category = GasCategory::create($request->only(['name']));
            if($request->hasFile('image')){
                $file=$request->file('image');
                $file_name = upload_file($file);
                $category->image=$file_name;
                $category->save();
                $category->refresh();
            }
            return $this->successResponse($category,Response::HTTP_CREATED);
        }catch (\Throwable $th)
        {
            return $this->errorResponse($th->getMessage(),Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$categoryId)
    {
        $request->validate([
            'name'=>['required'],
            'image'=>['nullable','file','mimes:jpg,png,webp,jpeg,svg']
        ]);
        try {
            $category = GasCategory::find($categoryId);
            $category->name = $request->name;
            $category->save();
            if($request->hasFile('image')){
                $file=$request->file('image');
                $file_name = upload_file($file);
                $category->image=$file_name;
                $category->save();
                $category->refresh();
            }
            return $this->successResponse($category,Response::HTTP_CREATED);
        }catch (\Throwable $th)
        {
            return $this->errorResponse($th->getMessage(),Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GasCategory $gasGategory)
    {
        //
    }
}
