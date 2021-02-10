<?php
namespace App\Http\Controllers\Admin;

use App\CarType;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\Option;
use App\Category;
use App\OptionValue;

class OptionsController extends AdminController{
    // get all options
    public function show(){
        $data['options'] = Option::orderBy('id' , 'desc')->get();
        return view('admin.options' , ['data' => $data]);
    }

    // add get
    public function addGet() {
        $data['categories'] = CarType::where('deleted', 0)->orderBy('id' , 'desc')->get();

        return view('admin.option_form', ['data' => $data]);
    }

    // add post
    public function addPost(Request $request) {
        $post = $request->except(['category_ids', 'property_values_en', 'property_values_ar']);
        $option = Option::create($post);
        $option->categories()->sync($request->category_ids);
        if (isset($request->property_values_en) && isset($request->property_values_ar)) {
            $values_en = explode(',', $request->property_values_en);
            $values_ar = explode(',', $request->property_values_ar);
        
            if (count($values_en) == count($values_ar)) {
                for ($i = 0; $i < count($values_en); $i ++) {
                    OptionValue::create([
                    'option_id' => $option->id,
                    'value_en' => trim($values_en[$i], ' '),
                    'value_ar' => trim($values_ar[$i], ' ')
                    ]);
                }
            }
        }

        return redirect()->route('options.index');
    }

    // edit get
    public function editGet(Option $option) {
        $data['option'] = $option;
        $data['categories'] = CarType::where('deleted', 0)->orderBy('id' , 'desc')->get();
        $data['categories_array'] = $data['option']->categories()->pluck('car_types.id')->toArray();

        return view('admin.option_edit', ['data' => $data]);
    }

    // edit post
    public function editPost(Request $request, Option $option) {
        $post = $request->except(['category_ids', 'property_values_en', 'property_values_ar']);
        $option->update($post);
        $option->categories()->sync($request->category_ids);
        
        if (isset($request->property_values_en) && isset($request->property_values_ar)) {
                $values_en = explode(',', $request->property_values_en);
                
                $values_ar = explode(',', $request->property_values_ar);
            
            if (count($values_en) == count($values_ar)) {
                $option->values()->delete();
                for ($i = 0; $i < count($values_en); $i ++) {
                    OptionValue::create([
                    'option_id' => $option->id,
                    'value_en' => trim($values_en[$i], ' '),
                    'value_ar' => trim($values_ar[$i], ' ')
                    ]);
                }
            }
        }

        return redirect()->route('options.index');
    }

    // delete
    public function delete(Option $option) {
        $option->categories()->sync([]);
        $option->values()->delete();
        $option->delete();

        return redirect()->back();
    }
}