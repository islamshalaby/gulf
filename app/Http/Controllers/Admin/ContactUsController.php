<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ContactUs;

class ContactUsController extends AdminController{

    // get all contact us messages
    public function show(){
        $data['contact_us'] = ContactUs::orderBy('id' , 'desc')->get();
        return view('admin.contact_us' , ['data' => $data]);   
    }

    // get contact us message details
    public function details(Request $request){
        $data['contact_us'] = ContactUs::find($request->id);
        $data['contact_us']->seen = 1;
        $data['contact_us']->save();
        return view('admin.contact_us_details' , ['data' => $data]);
    }

    // delete contact us message 
    public function delete(Request $request){
        $contact = ContactUs::find($request->id);
        if($contact){
            $contact->delete();
        }
        return redirect('admin-panel/contact_us');
    }

}