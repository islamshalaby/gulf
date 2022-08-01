<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\MetaTag;

class MetaTagController extends AdminController{
    
    // get meta tags page
    public function getMetaTags(){
        $data['meta'] = MetaTag::find(1);
        return view('admin.meta_tag_edit' , ['data' => $data]);
    }   
    
    // post meta tags
    public function postMetaTags(Request $request){
        $meta = MetaTag::find(1);
        $meta->home_meta_en = $request->home_meta_en;
        $meta->home_meta_ar = $request->home_meta_ar;
        $meta->save();
        return redirect()->back();
    }


}