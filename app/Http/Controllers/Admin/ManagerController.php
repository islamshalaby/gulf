<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\Admin;
use App\Permission;
use App\AdminPermission;
use Illuminate\Support\Facades\Auth;


class ManagerController extends AdminController{
    
    // get add manager page
    public function AddGet(){
        $data['permissions'] = Permission::get();
        return view('admin.manager_form' , ['data' => $data]);
    }

   // post add manager
   public function AddPost(Request $request){
        $check_manager_mail = Admin::where('email' , $request->email)->first();
        if($check_manager_mail){
            return redirect('admin-panel/managers/add')->with('status', 'Email Exists Before');
        }

        if(empty($request->permission)){
            return redirect('admin-panel/managers/add')->with('status', 'You must add at least one permission');
        }

        $manager = new Admin();
        $manager->name = $request->name;
        $manager->email = $request->email;
        $manager->password = Hash::make($request->password);
        $manager->add_data = $request->add_data || 0;
        $manager->update_data = $request->update_data || 0;
        $manager->delete_data = $request->delete_data || 0;        
        $manager->save();

        $permissions = $request->permission;
        $manager_id = $manager->id;        

        for($i = 0; $i < count($permissions) ; $i++){
            $admin_permission = new AdminPermission();
            $admin_permission->admin_id = $manager_id;
            $admin_permission->permission_id = $permissions[$i];
            $admin_permission->save();
        }
        return redirect('/admin-panel/managers/show');
   }
   
   // get all managers
   public function show(Request $request){
     $data['managers']  = Admin::orderBy('id' , 'desc')->get(); 
     return view('admin.managers' , ['data' => $data]);
   }

   // get edit manager page
   public function edit(Request $request){
     $data['manager'] = Admin::find($request->id);
     $data['permissions'] = Permission::get();
     $admin_permission = AdminPermission::where('admin_id' , $request->id)->pluck('permission_id');
     $admin_permission  = (array) $admin_permission;  
     $admin_permission = array_values($admin_permission);
     $admin_permission = $admin_permission[0];
     for($i = 0; $i < count($data['permissions']); $i++){
        if(in_array($data['permissions'][$i]['id'] , $admin_permission)){
            $data['permissions'][$i]['checked'] = "checked";
        }else{
            $data['permissions'][$i]['checked'] = "";
        }
     }

      return view('admin.manager_edit' , ['data' => $data]);
   }

   // post edit manager
   public function EditPost(Request $request){
        $check_manager_email = Admin::where('email' , $request->email)->where('id' , '!=' , $request->id)->first();
        if($check_manager_email){
            return redirect('/admin-panel/managers/edit/'.$request->id)->with('status' , 'Email Exists Before');
        }

        if(empty($request->permission)){
            return redirect('admin-panel/managers/edit/'.$request->id)->with('status', 'You must add at least one permission');
        }
       
        $admin_permissions = AdminPermission::where('admin_id' , $request->id)->delete();

        $permissions = $request->permission;
        $manager_id = $request->id;        

        for($i = 0; $i < count($permissions) ; $i++){
            $admin_permission = new AdminPermission();
            $admin_permission->admin_id = $manager_id;
            $admin_permission->permission_id = $permissions[$i];
            $admin_permission->save();
        }

        $current_manager = Admin::find($request->id);
        $current_manager->name = $request->name;
        $current_manager->email = $request->email;
        if($request->password){ 
            $current_manager->password = Hash::make($request->password);
        }

        $current_manager->add_data = $request->add_data || 0;
        $current_manager->update_data = $request->update_data || 0;
        $current_manager->delete_data = $request->delete_data || 0; 

        $current_manager->save();
        return redirect('/admin-panel/managers/show');
   }

   // delete manager
   public function delete(Request $request){
        $manager = Admin::find($request->id);
        if($manager){
            $manager->delete();
        }
        return redirect()->back();
   }
   
}