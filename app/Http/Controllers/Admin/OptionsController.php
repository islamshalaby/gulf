<?php
namespace App\Http\Controllers\Admin;

use App\CarType;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Option;
use App\Category;
use App\OptionsCategory;
use App\OptionValue;
use Lang;

class OptionsController extends AdminController{
    // get all options
    public function show(){
        $data['options'] = Option::where('parent_id', 0)->orderBy('id' , 'desc')->get();
        $data['categories'] = CarType::where('deleted', 0)->orderBy('id' , 'desc')->get();
        return view('admin.options' , ['data' => $data]);
    }

    // get sub filters
    public function getSubFilters() {
        $data['options'] = Option::where('parent_id', '!=', 0)->orderBy('id' , 'desc')->get();
        $data['main_filters'] = Option::where('parent_id', 0)->orderBy('id' , 'desc')->get();

        return view('admin.sub_options' , ['data' => $data]);
    }

    // post sub filter
    public function postSubFilter(Request $request) {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'title_en' => 'required',
            'title_ar' => 'required',
            'parent_id' => 'required'
        ]);
        if($validator->fails()){
            return 0;
        }
        $post = $request->all();
        
        $option = Option::create($post);

        return $option->id;
    }

    // fetch values by main option
    public function fetchValuesByMainOption(Request $request) {
        $lang = Lang::getLocale();
        $rows = OptionValue::where('option_id', $request->option)->select('id', 'value_' . $lang . ' as val' )->orderBy('id' , 'desc')->get();

        $data = json_decode($rows);
        return response($data, 200);
    }

    // add get
    public function addGet() {
        $data['categories'] = CarType::where('deleted', 0)->orderBy('id' , 'desc')->get();

        return view('admin.option_form', ['data' => $data]);
    }

    // add post
    public function addPost(Request $request) {
        $validator = Validator::make($request->all(), [
            'title_en' => 'required',
            'title_ar' => 'required'
        ]);
        if($validator->fails()){
            return 0;
        }
        $post = $request->all();
        $option = Option::create($post);
        

        return $option->id;
    }

    // add post
    public function updateFilter(Request $request) {
        $validator = Validator::make($request->all(), [
            'title_en' => 'required',
            'title_ar' => 'required'
        ]);
        if($validator->fails()){
            return 0;
        }
        $post = $request->all();
        $option = Option::where('id', $request->option_id)->first();
        if (!$option) {
            return 0;
        }
        $option->update($post);

        return $option->id;
    }

    // update option categories
    public function updateOptionCategories(Request $request) {
        $option = Option::where("id", $request->option_id)->first();
        if ($request->status == 1) {
            OptionsCategory::create(["option_id" => $request->option_id, "category_id" => $request->id]);
        }else {
            $optionCat = OptionsCategory::where('option_id', $request->option_id)->where('category_id', $request->id)->first();
            $optionCat->delete();
        }

        return $request->status;
    }

    // add values
    public function addVals(Request $request) {
        $validator = Validator::make($request->all(), [
            'value_en' => 'required',
            'value_ar' => 'required',
            "option_id" => "required"
        ]);
        // dd($request->all());
        if($validator->fails()){
            return 0;
        }
        OptionValue::create(["option_id" => $request->option_id, "value_en" => $request->value_en, "value_ar" => $request->value_ar]);

        return 1;
    }

    // update value
    public function updateValue(Request $request) {
        $validator = Validator::make($request->all(), [
            'value_en' => 'required',
            'value_ar' => 'required',
            "value_id" => "required"
        ]);

        if($validator->fails()){
            return 0;
        }

        $optionValue = OptionValue::where('id', $request->value_id)->first();

        if (!$optionValue) {
            return 0;
        }
        $post = $request->except(['value_id']);
        $optionValue->update($post);

        return 1;
    }

    // add sub val
    public function addSubVal(Request $request) {
        $validator = Validator::make($request->all(), [
            'value_en' => 'required',
            'value_ar' => 'required',
            "option_id" => "required",
            "parent_id" => "required"
        ]);

        if($validator->fails()){
            return 0;
        }
        $post = $request->all();
        OptionValue::create($post);

        return 1;
    }

    // delete value
    public function deleteVal(Request $request) {
        $validator = Validator::make($request->all(), [
            'value_id' => 'required|exists:option_values,id'
        ]);

        if($validator->fails()){
            return 0;
        }
        $optionVal = OptionValue::where('id', $request->value_id)->first();
        if (count($optionVal->products) > 0) {
            return 2;
        }

        $optionVal->delete();

        return 1;
    }

    // update sections sorting
    public function updateOptionsSorting(Request $request) {
        $post = $request->all();

        $count = 0;

        for ($i = 0; $i < count($post['id']); $i ++) :
            $index = $post['id'][$i];

            $home_section = Option::findOrFail($index);

            $count ++;

            $newPosition = $count;

            $data['sort'] = $newPosition;




            if($home_section->update($data)) {
                echo "successss";
            }else {
                echo "failed";
            }


        endfor;

        exit('success');

    }

    // edit option categories
    public function editOptionCategories(Request $request) {
        $data['categories'] = CarType::where('deleted', 0)->orderBy('id' , 'desc')->get();
        $data['categories_array'] = $data['option']->categories()->pluck('car_types.id')->toArray();

        return view('admin.option_categories_edit', ['data' => $data]);
    }

    // edit get
    public function editGet(Option $option) {
        $data['option'] = $option;
        $data['categories'] = CarType::where('deleted', 0)->orderBy('id' , 'desc')->get();
        $data['categories_array'] = $data['option']->categories()->pluck('car_types.id')->toArray();

        return view('admin.option_edit', ['data' => $data]);
    }

    // edit sub filter
    public function editSubFilter(Option $option) {
        $data['option'] = $option;

        return view('admin.sub_option_edit', ['data' => $data]);
    }

    // edit post
    public function editPost(Request $request, Option $option) {
        $post = $request->except(['category_ids', 'property_values_en', 'property_values_ar']);
        $option->update($post);
        $option->categories()->sync($request->category_ids);
        if (empty($request->property_values_en)) {
            $option->values()->delete();
            $optionValues = OptionValue::where('option_id', $option->id)->get();
            for ($n = 0; $n < count($optionValues); $n ++) {
                $optionValues[$n]->delete();
            }
        }
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

    // delete
    public function delete(Option $option) {
        $option->categories()->sync([]);
        $option->values()->delete();
        $option->delete();

        return redirect()->back()->with('success', __('messages.deleted_s'));
    }
}