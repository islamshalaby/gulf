<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Company;

class CompanyController extends AdminController{
    // type : get -> to add new
    public function AddGet(){
        return view('admin.company_form');
    }

    // type : post -> to add new
    public function AddPost(Request $request){
        $image_name = $request->file('image')->getRealPath();
        Cloudder::upload($image_name, null);
        $imagereturned = Cloudder::getResult();
        $image_id = $imagereturned['public_id'];
        $image_format = $imagereturned['format'];    
        $image_new_name = $image_id.'.'.$image_format;
        $company = new Company();
        $company->image = $image_new_name;
        $company->title_en = $request->title_en;
        $company->title_ar = $request->title_ar;
        $company->email = $request->email;
        $company->password = Hash::make($request->password);
        $company->save();

        return redirect('admin-panel/companies/show'); 
    }

    // show
    public function show() {
        $data['companies'] = Company::where('deleted', 0)->orderBy('id', 'desc')->get();
        
        return view('admin.companies', ['data' => $data]);
    }

    // get edit page
    public function EditGet(Request $request){
        $data['company'] = Company::find($request->id);
        return view('admin.company_edit' , ['data' => $data ]);
    }

    // edit category
    public function EditPost(Request $request){
        $company = Company::find($request->id);
        if($request->file('image')){
            $image = $company->image;
            $publicId = substr($image, 0 ,strrpos($image, "."));    
            Cloudder::delete($publicId);
            $image_name = $request->file('image')->getRealPath();
            Cloudder::upload($image_name, null);
            $imagereturned = Cloudder::getResult();
            $image_id = $imagereturned['public_id'];
            $image_format = $imagereturned['format'];    
            $image_new_name = $image_id.'.'.$image_format;
            $company->image = $image_new_name;
        }

        $company->title_en = $request->title_en;
        $company->title_ar = $request->title_ar;
        $company->email = $request->email;
        if (isset($request->email) && !empty($request->email)) {
            $company->password = Hash::make($request->password);
        }else {
            $company->password = $company->password;
        }
        
        $company->save();
        return redirect('admin-panel/companies/show');
    }

    // delete category
    public function delete(Request $request){
        $company = Company::find($request->id);
        $company->deleted = 1;
        $company->save();
        return redirect()->back();
    }

    // details
    public function details(Company $company) {
        $data['company'] = $company;

        return view('admin.company_details', ['data' => $data]);
    }
}