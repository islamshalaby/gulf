<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
// use Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Helpers\APIHelpers;
use App\Plan;
use App\User;
use Illuminate\Support\Facades\Http;




class PlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api' , ['except' => [ 'getpricing' , 'excute_pay' , 'pay_sucess' , 'pay_error']]);
    }

    public function getpricing(Request $request){
        $data['plans'] = Plan::select('id' , 'ads_count' , 'price')->orderBy('id', 'desc')->get();
        if ($request->lang == 'en') {
            $data['currency'] = Country::where('id', $request->country)->first()['currency'];
        }else {
            $data['currency'] = Country::where('id', $request->country)->first()['currency_ar'];
        }
        
        $response = APIHelpers::createApiResponse(false , 200 ,  ''  , '', $data , $request->lang );
        return response()->json($response , 200); 
    }

    public function buyplan(Request $request){
        $user = auth()->user();
        if($user->active == 0){
            $response = APIHelpers::createApiResponse(true , 406 ,  'تم حظر حسابك' , 'تم حظر حسابك' , null , $request->lang);
            return response()->json($response , 406);
        }
        
        $validator = Validator::make($request->all() , [
            'plan_id' => 'required',
        ]);

        if($validator->fails()) {
            $response = APIHelpers::createApiResponse(true , 406 ,  'بعض الحقول مفقودة' , 'بعض الحقول مفقودة' , null , $request->lang );
            return response()->json($response , 406);
        }

        $plan = Plan::find($request->plan_id);
        $root_url = $request->root();

        $path='https://apitest.myfatoorah.com/v2/SendPayment';
        $token="bearer rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL";

        $headers = array(
            'Authorization:' .$token,
            'Content-Type:application/json'
        );
        $price = $plan->price;
        $call_back_url = $root_url."/api/ad/excute_pay?user_id=".$user->id."&plan_id=".$request->plan_id;
        // dd($call_back_url);
        $error_url = $root_url."/api/ad/pay/error";
        $fields =array(
            "CustomerName" => $user->name,
            "NotificationOption" => "LNK",
            "InvoiceValue" => $price,
            "CallBackUrl" => $call_back_url,
            "ErrorUrl" => $error_url,
            "Language" => "AR",
            "CustomerEmail" => $user->email
        );  

        $payload =json_encode($fields);
        $curl_session =curl_init();
        curl_setopt($curl_session,CURLOPT_URL, $path);
        curl_setopt($curl_session,CURLOPT_POST, true);
        curl_setopt($curl_session,CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl_session,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl_session,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_session,CURLOPT_IPRESOLVE, CURLOPT_IPRESOLVE);
        curl_setopt($curl_session,CURLOPT_POSTFIELDS, $payload);
        $result=curl_exec($curl_session);
        curl_close($curl_session);
        $result = json_decode($result);
        $data['url'] = $result->Data->InvoiceURL;
        // dd($result);
        // $user->paid_ads_count = $user->paid_ads_count + $plan->ads_count;
        // $user->save();
        $response = APIHelpers::createApiResponse(false , 200 ,  '' , '' , $data , $request->lang );
        return response()->json($response , 200);  

    }

    public function excute_pay(Request $request){
        $plan = Plan::find($request->plan_id);
        $new_ads_count = $plan->ads_count;
        $user = User::find($request->user_id);
        $paid_ads = $user->paid_ads_count;
        $user->paid_ads_count = $paid_ads + $new_ads_count;
        $user->save();
        return redirect('api/ad/pay/success'); 
    }

    public function pay_sucess(){
        return "Please wait ...";
    }

    public function pay_error(){
        return "Please wait ...";
    }

}    