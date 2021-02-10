<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Rate;
use App\User;

class RateController extends AdminController{

        // get all rates
        public function Getrates(Request $request){
            $data['rates'] = Rate::orderBy('id' , 'desc')->get();
            for($i = 0 ; $i < count($data['rates']); $i++){
                $data['rates'][$i]['user'] = User::select('id' , 'name')->find($data['rates'][$i]['user_id']);
            }
            return view('admin.rates' , ['data' => $data]);
        }

        // active rate
        public function activeRate(Request $request){
            $rate = Rate::find($request->id);
            $rate->admin_approval = 1;
            $rate->save();
            return back();
        }

}