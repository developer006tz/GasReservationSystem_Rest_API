<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGasCategotyRequest;
use App\Models\GasCategory;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ApiResponces;

class GasCategoryController extends Controller
{
    use ApiResponces;
 
    public function getGasCategories()
    {
        try {
            $categories=GasCategory::all()->toArray();
            return $this->successResponse($categories,Response::HTTP_OK);
        }catch (\Throwable $th)
        {
            return $this->errorResponse($th->getMessage(),Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function addGasCategory(StoreGasCategotyRequest $request)
    {
        try {
            $category = GasCategory::create($request->validated());
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

    public function getSingleGasCategory($categoryId){
        try {
            $category = GasCategory::findOrFail($categoryId);
            return $this->successResponse($category,Response::HTTP_OK);
        }
        catch (\Throwable $th){
            return $this->errorResponse($th->getMessage(),Response::HTTP_BAD_REQUEST);
        }
    }
}
