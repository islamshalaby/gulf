<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Helpers\APIHelpers;
use App\Http\Controllers\Controller;
use App\User;
use App\Visitor;
use App\Setting;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login' , 'register' , 'invalid', 'resetforgettenpasswordByEmail', 'checkVerficationCode']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $credentials = request(['email', 'password']);


        if (! $token = auth()->attempt($credentials)) {
            $response  = APIHelpers::createApiResponse(true , 401 , 'Invalid email or password' , 'يرجي التاكد من البريد الإلكترونى او كلمة المرور' , null , $request->lang);
            return response()->json($response, 401);
        }

        if(!$request->unique_id || !$request->type){
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة' , null , $request->lang);
            return response()->json($response , 406);
        }

        $user = auth()->user();
        if($request->fcm_token) {
            $user->fcm_token = $request->fcm_token;
        }
        
        $user->save();

        $visitor = Visitor::where('unique_id' , $request->unique_id)->first();
        if($visitor){
            $visitor->user_id = $user->id;
            if($request->fcm_token) {
                $visitor->fcm_token = $request->fcm_token;
            }
            
            $visitor->save();
        }else{
            $visitor = new Visitor();
            $visitor->unique_id = $request->unique_id;
            if($request->fcm_token) {
                $visitor->fcm_token = $request->fcm_token;
            }
            $visitor->type = $request->type;
            $visitor->user_id = $user->id;
            $visitor->save();
        }
        
        $token = auth()->login($user);
        $user->token = $this->respondWithToken($token);

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $user , $request->lang);
        return response()->json($response , 200);

    }

    public function invalid(Request $request){
        
        $response = APIHelpers::createApiResponse(true , 401 , 'Invalid Token' , 'تم تسجيل الخروج' , null , $request->lang);
        return response()->json($response , 401);
    }

    /* 
    * create user 
    */
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            "email" => 'required|email',
            "password" => 'required',
            "fcm_token" => 'required',
            "type" => "required", // 1 -> iphone , 2 -> android
            "unique_id" => "required",            
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة' , null , $request->lang);
            return response()->json($response , 406);
        }

        // check if phone number register before
        $prev_user_phone = User::where('phone', $request->phone)->first();
        if($prev_user_phone){
            $response = APIHelpers::createApiResponse(true , 409 , 'Phone Exists Before' , 'رقم الهاتف موجود من قبل' , null , $request->lang);
            return response()->json($response , 409);
        }

        // check if email registered before
        $prev_user_email = User::where('email', $request->email)->first();
        if($prev_user_email){
            $response = APIHelpers::createApiResponse(true , 409 , 'Email Exists Before' , 'البريد الإلكتروني موجود من قبل' , null , $request->lang);
            return response()->json($response , 409);
        }

        $data['name'] = $request->name;
        $data['code'] = $this->generateRandomString(5);
        Mail::send('mail', $data, function($message) use ($request) {
            $message->to($request->email, $request->name)->subject
               ('gulf auth');
            $message->from('gulfsale2020@gmail.com','Gulf Auto');
         });
        //  echo "Basic Email Sent. Check your inbox.";
        $setting = Setting::find(1);
        $free_ads = $setting['free_ads_count'];

        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->free_ads_count = $free_ads;
        $user->fcm_token = $request->fcm_token;
        $user->remember_token = $data['code'];
        $user->save();

        $visitor = Visitor::where('unique_id' , $request->unique_id)->first();
        if($visitor){
            $visitor->user_id = $user->id;
            $visitor->fcm_token = $user->fcm_token;
            $visitor->save();
        }else{
            $visitor = new Visitor();
            $visitor->unique_id = $request->unique_id;
            $visitor->fcm_token = $user->fcm_token;
            $visitor->type = $request->type;
            $visitor->user_id = $user->id;
            $visitor->save();
        }

        $token = auth()->login($user);
        $user->token = $this->respondWithToken($token);

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $user , $request->lang);
        return response()->json($response , 200);
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function verifyAccount(Request $request) {
        $validator = Validator::make($request->all(), [
            'verification_code' => 'required'
        ]);

        if ($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة' , null , $request->lang);
            return response()->json($response , 406);
        }

        $userId = auth()->user()->id;
        $user = User::where('id', $userId)->where('remember_token', $request->verification_code)->first();

        if ($user) {
            $user->active = 1;
            $user->save();
            $response = APIHelpers::createApiResponse(false , 200 , 'Verified Successfully' , 'تم تفعيل الحساب بنجاح' , $user , $request->lang);
            return response()->json($response , 200);
        }

        $response = APIHelpers::createApiResponse(true , 406 , 'Verification Code is not identical' , 'كود التفعيل غير مطابق' , null , $request->lang);
        return response()->json($response , 406);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        $user = auth()->user();
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $user , $request->lang);
        return response()->json($response , 200);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        auth()->logout();
        $response = APIHelpers::createApiResponse(false , 200 , '', '' , [] , $request->lang);
        return response()->json($response , 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        $responsewithtoken = $this->respondWithToken(auth()->refresh());
        $response = APIHelpers::createApiResponse(false , 200 , '', '' , $responsewithtoken , $request->lang);
        return response()->json($response , 200);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 432000
        ];
    }

    public function resetforgettenpasswordByEmail(Request $request){
        $validator = Validator::make($request->all() , [
            'email' => 'required|email'
        ]);

        if($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة' , null , $request->lang);
            return response()->json($response , 406);
        }

        $user = User::where('email', $request->email)->first();
        if(! $user){
            $response = APIHelpers::createApiResponse(true , 403 , 'Email Not Exists Before' , 'بريد إلكترونى غير موجود' , null , $request->lang);
            return response()->json($response , 403);
        }

        $data['code'] = $this->generateRandomString(5);
        $data['name'] = $user->name;
        Mail::send('mail_reset_password', $data, function($message) use ($request, $data) {
            $message->to($request->email, $data['name'])->subject
               ('gulf reset password');
            $message->from('gulfsale2020@gmail.com','Gulf Auto');
         });

        User::where('email' , $user->email)->update(['remember_token' => $data['code']]);
        $newuser = User::where('email' , $user->email)->first();
		
        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $newuser , $request->lang);
        return response()->json($response , 200);
    }

    public function checkVerficationCode(Request $request) {
        $validator = Validator::make($request->all() , [
            'code' => 'required',
            'email' => 'required|email'
        ]);

        if($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 , 'Missing Required Fields' , 'بعض الحقول مفقودة' , null , $request->lang);
            return response()->json($response , 406);
        }

        $user = User::where('email', $request->email)->where('remember_token', $request->code)->first();
        
        $data['verified'] = false;
        if ($user) {
            $data['verified'] = true;
        }

        $response = APIHelpers::createApiResponse(false , 200 , '' , '' , $data , $request->lang);
        return response()->json($response , 200);
    }
}