<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Company;
use App\Governorate;
use App\GovernorateAreas;

class CompanyController extends AdminController{
    // type : get -> to add new
    public function AddGet(){
        $governorates = Governorate::where('country_id', 4)->where('deleted', 0)->pluck('id')->toArray();
        $data['areas'] = GovernorateAreas::whereIn('governorate_id', $governorates)->where('deleted', 0)->get();
        return view('admin.company_form', compact('data'));
    }

    // type : post -> to add new
    public function AddPost(Request $request){
        $post = $request->validate([
            'image' => 'required',
            'title_en' => 'required',
            'title_ar' => 'required',
            'email' => 'required|email|unique:companies,email',
            'password' => 'required',
            'area_id' => 'required',
            'address' => 'required'
        ]);
        $image_name = $request->file('image')->getRealPath();
        Cloudder::upload($image_name, null);
        $imagereturned = Cloudder::getResult();
        $image_id = $imagereturned['public_id'];
        $image_format = $imagereturned['format'];    
        $post['image'] = $image_id.'.'.$image_format;
        $post['password'] = Hash::make($request->password);
        Company::create($post);

        return redirect('admin-panel/companies/show')
        ->with('success', __('messages.created_successfully')); 
    }

    // show
    public function show() {
        $data['companies'] = Company::where('deleted', 0)->orderBy('id', 'desc')->get();
        
        return view('admin.companies', ['data' => $data]);
    }

    // get edit page
    public function EditGet(Request $request){
        $data['company'] = Company::find($request->id);
        $governorates = Governorate::where('country_id', 4)->where('deleted', 0)->pluck('id')->toArray();
        $data['areas'] = GovernorateAreas::whereIn('governorate_id', $governorates)->where('deleted', 0)->get();

        return view('admin.company_edit' , ['data' => $data ]);
    }

    // edit category
    public function EditPost(Request $request){
        $company = Company::find($request->id);
        $post = $request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'email' => 'required|email|unique:companies,email,' . $request->id,
            'area_id' => 'required',
            'address' => 'required'
        ]);
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
            $post['image'] = $image_new_name;
        }

        if (isset($request->password) && !empty($request->password)) {
            $company->password = Hash::make($request->password);
        }else {
            $company->password = $request->password;
        }
        $company->email = $request->email;
        $company->area_id = $request->area_id;
        $company->address = $request->address;
        
        $company->save();
        return redirect('admin-panel/companies/show')
        ->with('success', __('messages.updated_successfully'));
    }

    // delete category
    public function delete(Request $request){
        $company = Company::find($request->id);
        $company->deleted = 1;
        $company->save();
        return redirect()->back()->with('success', __('messages.deleted_s'));
    }

    // details
    public function details(Company $company) {
        $data['company'] = $company;

        return view('admin.company_details', ['data' => $data]);
    }

    // update shipping cost
    public function updateShippingCost(Request $request) {
        $post = $request->validate([
            "company_id" => "required",
            "shipping_cost" => "required"
        ]);

        $company = Company::where('id', $request->company_id)->select('id', 'shipping_cost')->first();
        $company->update($post);

        return redirect()->back()->with('success', __('messages.shipping_cost_added'));
    }
}