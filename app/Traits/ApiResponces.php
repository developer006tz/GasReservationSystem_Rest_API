<?php

namespace App\Traits;

trait ApiResponces
{

    /**
     * @param mixed $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data, $status = 200, $message = null)
    {
        $response = ['data' => $data];
        if ($message !== null) {
            $response['message'] = $message;
        }
        return response()->json($response, $status);
    }


    /**
     * @param string $message
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, $status,$data=null)
    {
        return response()->json(['error' => $message, 'status' => $status,'data'=>$data ], $status);
    }

}
