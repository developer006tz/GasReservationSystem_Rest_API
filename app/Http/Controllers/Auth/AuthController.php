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
        $this->middleware('auth:sanctum', ['except' => ['login','register','sendSms']]);
    }

    public function register(Request $request){
        $request->validate([
            'name'=>['required','string','min:3'],
            'phone'=>['required','unique:users,phone','min:9'],
            'password'=>['required','min:4'],
            'email'=>['required','email','unique:users,email'],
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


    public function sendSms(Request $request){
        $message = $request->message;
        $phone = $request->recipients;
        $publicKey = $request->publicKey;

          $privateKey = 'LudovickFrancisKonyo19991977';
          if($publicKey != $privateKey){
           return $this->errorResponse('invalid secret key',Response::HTTP_UNAUTHORIZED);
          }
       
          $api_key = 'KUYELA';
          $secret_key = 'Kuyela1996@';
          $postData = array(
            'from' => 'HUKUEVENTS',
            'to' => $phone,
            'text' => utf8_encode($message),
            'reference' => 'HUKUEVENTS'
          );      
          $curl = curl_init();
          curl_setopt_array(
            $curl,
            array(
              CURLOPT_URL => 'https://messaging-service.co.tz/api/sms/v1/text/single',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => json_encode($postData),
              CURLOPT_HTTPHEADER => array(
                'Authorization:Basic ' . base64_encode("$api_key:$secret_key"),
                'Content-Type: application/json',
                'Accept: application/json'
              ),
            )
          );
          $responses = curl_exec($curl);
          curl_close($curl);
          $response = json_decode($responses, true);
          return response()->json('success', 200);
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

    public function logout(Request $request)
{
    $user = auth()->user();
    $user->currentAccessToken()->delete();

    return $this->successResponse(null,Response::HTTP_OK);
}

    public function updateProfile(Request $request,$userId){
        $validated = $request->validate([
            'name' => ['required'],
            'phone' => ['required', 'unique:users,phone'],
            'password' => ['nullable'],
            'email' => ['required', 'unique:users,email'],
        ]);

        $user = User::find($userId);
        if(!empty($validated['password'])){
            $validated['password'] = Hash::make($validated['password']);
        }
        $user->fill($validated);
        $user->save();

        return $this->successResponse($user,Response::HTTP_OK);
    }

    public function getAllUsers(){
        return $this->successResponse(User::all()->toArray(),Response::HTTP_OK);
    }
}
