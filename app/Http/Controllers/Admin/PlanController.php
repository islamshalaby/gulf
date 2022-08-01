<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\Plan;

class PlanController extends AdminController{
        // type get 
        public function AddGet(){
            return view('admin.plan_form');
        }
    
        // type post
        public function AddPost(Request $request){
            $plan = new Plan();
            $plan->ads_count = $request->ads_count;
            $plan->price = $request->price;
            
            $plan->save();
            return redirect('admin-panel/plans/show'); 
        }
    
    
            // get all ads
            public function show(Request $request){
                $data['plans'] = Plan::orderBy('id' , 'desc')->get();
                return view('admin.plans' , ['data' => $data]);
            }
        
            // get edit page
            public function EditGet(Request $request){
                $data['plan'] = Plan::find($request->id);
                // dd($data['product']);
                return view('admin.plan_edit' , ['data' => $data]);
            }
        
            // post edit ad
            public function EditPost(Request $request){
                $plan = Plan::find($request->id);
              
                $plan->ads_count = $request->ads_count;
                $plan->price = $request->price;
                
                $plan->save();
                return redirect('admin-panel/plans/show');
            }
        

        
            public function delete(Request $request){
                $plan = Plan::find($request->id);
                if($plan){
                    $plan->delete();
                }
                return redirect('admin-panel/plans/show');
            }
}