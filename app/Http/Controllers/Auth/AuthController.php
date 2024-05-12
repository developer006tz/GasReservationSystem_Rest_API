<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use App\Traits\ApiResponces;

class AuthController extends Controller
{
    use ApiResponces;
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login','register']]);
    }

    public function register(Request $request){
        $request->validate([
            'name'=>['required'],
            'phone'=>['required','unique:users,phone'],
            'password'=>['required'],
            'email'=>['required','unique:users,email'],
            'user_type'=>['required','in:supplier,client']
        ]);
        $password = Hash::make(trim($request->password));
        try {
            $user = User::create([
                'name'=>trim($request->name),
                'phone'=>trim($request->phone),
                'email'=>trim($request->email),
                'user_type'=>trim($request->user_type),
                'password'=>$password
            ]);
            $data=[
                'user'=>$user,
                'access_token'=>$user->createToken($user->name.'-AuthToken')->plainTextToken,
                'type'=>'bearer'
            ];
            return $this->successResponse($data,Response::HTTP_CREATED,'User created Successfull');
        }catch (\Throwable $th){
            return $this->errorResponse($th->getMessage(),Response::HTTP_UNPROCESSABLE_ENTITY);
        }

    }

    public function login(Request $request)
    {
        $request->validate([
            'email'=>['required','email'],
            'password'=>['required']
        ]);

        try {
            if(!auth()->attempt($request->only(['email','password'])))
            {
                return $this->errorResponse('invalid email or password',Response::HTTP_UNAUTHORIZED);
            }
            $user = User::whereEmail(trim($request->email))->first();
            if($user->tokens()){
                $user->tokens()->delete();
            }
            $data = [
                'user'=>$user,
                'access_token'=>$user->createToken($user->name.'-AuthToken')->plainTextToken,
                'type'=>'bearer'
            ];
            return  $this->successResponse($data,Response::HTTP_OK);

        }catch (\Throwable $th)
        {
            return $this->errorResponse($th->getMessage(),Response::HTTP_UNAUTHORIZED);
        }
    }

    public function getAuthUser()
    {

        return $this->successResponse(auth()->user(),Response::HTTP_OK);
    }
}
