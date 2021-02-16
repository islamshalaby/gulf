<?php
namespace App\Http\Controllers\Admin;
use App\Category_option;
use App\CategoryOptionValue;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\Category;

class OptionsValuesController extends AdminController{


    public function show($id){
        $option_id = $id;
        $data = CategoryOptionValue::where('option_id',$id)->where('deleted', 0)->get();
        return view('admin.option_values',compact('data','option_id'));
    }

    public function create($id){

        $option_id = $id;
        return view('admin.option_value_form',compact('option_id'));
    }

    public function store(Request $request)
    {
        $data = $this->validate(\request(),
            [
                'value_ar' => 'required',
                'value_en' => 'required',
                'option_id'=> 'required'
            ]);
            CategoryOptionValue::create($data);
        session()->flash('success', trans('messages.added_s'));
        return redirect( route('options_values.show',$request->option_id));
    }

    public function edit($id)
    {
        $data = CategoryOptionValue::findOrFail($id);
        return view('admin.option_value_edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $option_value = CategoryOptionValue::find($id);
        $option_value->value_ar = $request->value_ar;
        $option_value->value_en = $request->value_en;
        $option_value->save();
        return redirect( route('options_values.show',$option_value->option_id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['deleted'] = "1";
        CategoryOptionValue::where('id',$id)->update($data);
        session()->flash('success', trans('messages.deleted_s'));
        return back();
    }

}
