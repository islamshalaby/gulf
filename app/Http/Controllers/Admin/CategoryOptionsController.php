<?php
namespace App\Http\Controllers\Admin;
use App\CategoryOption;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\Category;

class CategoryOptionsController extends AdminController{
    public function index()
    {
    }

    public function show($id){
        $data = CategoryOption::where('category_id',$id)->where('deleted', 0)->orderBy('id', 'desc')->get();
        return view('admin.category_options',compact('data','id'));
    }

    public function store(Request $request){
        $data = $this->validate(\request(),
            [
                'category_id' => 'required',
                // 'image' => 'required',
                'title_ar' => 'required',
                'title_en' => 'required',
                'is_required' => 'required'
            ]);

        // $image_name = $request->file('image')->getRealPath();
        // Cloudder::upload($image_name, null);
        // $imagereturned = Cloudder::getResult();
        // $image_id = $imagereturned['public_id'];
        // $image_format = $imagereturned['format'];
        // $image_new_name = $image_id.'.'.$image_format;
        // $data['image'] = $image_new_name ;
        CategoryOption::create($data);
        session()->flash('success', trans('messages.added_s'));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CategoryOption::where('id',$id)->update(['deleted' => 1]);

        session()->flash('success', trans('messages.deleted_s'));
        return back();
    }
}
