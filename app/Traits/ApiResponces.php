<?php

namespace App\Traits;

trait ApiResponces
{


    public function successResponse($data, $status = 200, $message = null): \Illuminate\Http\JsonResponse
    {

        return response()->json($data, $status);
    }


    public function errorResponse($message, $status,$data=null): \Illuminate\Http\JsonResponse
    {
        return response()->json(['error' => $message, 'status' => $status,'data'=>$data ], $status);
    }

}
