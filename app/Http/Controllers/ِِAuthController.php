<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

use App\Models\Customer;
class ِِAuthController extends Controller
{
    /**
     * 
     */
   function register(RegisterRequest $request) 
   { 
    $data = $request->validated();
     $user = User::create([ 'name' => $data['name'],
      'email' => $data['email'],
       'password' => Hash::make($data['password']),
        'type' => 'customer' ]);

      $user->customer()->create([
    'name' => $data['name'],
    'gender' => $data['gender'] ?? null,
    'DOB' => $data['DOB'] ?? null,
    'phone' => $data['phone'],
    'avatar' => $data['avatar'] ?? null,
    'lang' => $data['lang'] ?? 'ar',
]);
    
     $token = $user->createToken('api token');
         return apiSuccess("تم إنشاء الحساب",
          [ 'user' => $user, 
          'token' => $token->plainTextToken, ]);
           } 
           
 function login(LoginRequest $request) {
     $data = $request->validated();
     $user = User::where('email', $data['email'])->first();

      if (!$user || !Hash::check($data['password'], $user->password))
     {
        
      return apiFail("معلومات الدخول غير صحيحة", 422);

       } 

    $token = $user->createToken('api token');
    
    return apiSuccess("أهلا بك",
     [ 'user' => $user, 
     'token' => $token->plainTextToken ]); 
     } 
     
    function logout(Request $request) {  $user = Auth::user();
     $user = auth()->user(); $user = $request->user();
      $user->currentAccessToken()->delete();
       return apiSuccess("تم تسجيل الخروج"); }
}
