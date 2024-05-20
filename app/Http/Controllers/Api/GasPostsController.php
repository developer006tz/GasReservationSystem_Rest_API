<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGasPostRequest;
use App\Models\Gas;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ApiResponces;

class GasPostsController extends Controller
{
    use ApiResponces;

    public function addGasPost(StoreGasPostRequest $request)
    {
        try {
            $gasPost = Gas::create($request->validated());
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

    public function getGasPosts()
    {
        try {
            $gasPosts = Gas::get();
            return $this->successResponse($gasPosts, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function getSingleGasPost($gasPostId)
    {
        try {
            $gasPost = Gas::findOrFail($gasPostId);
            return $this->successResponse($gasPost, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function getSupplierGasPosts($supplierId){
        try {
            $gasPost = Gas::where('supplier_id', $supplierId)->get();
            return $this->successResponse($gasPost, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function publishGasPost($GasPostId){
        try {
            $gasPost = Gas::findOrFail($GasPostId);
            $gasPost->is_published = true;
            $gasPost->save();
            return $this->successResponse($gasPost, Response::HTTP_OK);
        }
        catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function unPublishGasPost($GasPostId)
    {
        try {
            $gasPost = Gas::findOrFail($GasPostId);
            $gasPost->is_published = false;
            $gasPost->save();
            return $this->successResponse($gasPost, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
