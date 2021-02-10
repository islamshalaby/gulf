<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\OffersSection;
use App\Product;
use App\ControlOffer;

class OffersControlController extends AdminController{
    // show
    public function show() {
        $data['offers_sections'] = OffersSection::where('type', 1)->orderBy('sort', 'asc')->get();

        // dd($data['offers_sections'][0]->offers);

        return view('admin.offers_sections', ['data' => $data]);
    }

    // add (get)
    public function AddGet() {
        $data['products'] = Product::where('deleted', 0)->where('hidden', 0)->whereHas('store', function($q){
            $q->where('status', 1);
        })->orderBy('id', 'desc')->get();

        return view('admin.offers_sections_form', ['data' => $data]);
    }

    // add (post)
    public function AddPost(Request $request) {
        $post = $request->except(['products']);

        $image_name = $request->file('icon')->getRealPath();
        Cloudder::upload($image_name, null);
        $imagereturned = Cloudder::getResult();
        $image_id = $imagereturned['public_id'];
        $image_format = $imagereturned['format'];    
        $image_new_name = $image_id.'.'.$image_format;
        $post['icon'] = $image_new_name;
        $post['type'] = 1;

        $section = OffersSection::create($post);

        if(count($request->products) > 0) {
            for ($i = 0; $i < count($request->products); $i ++) {
                ControlOffer::create(['offers_section_id' => $section['id'], 'offer_id' => $request->products[$i]]);
            }
        }

        return redirect()->route('offers_control.index');
    }

    // update offer sorting
    public function updateOffersSorting(Request $request) {
        $post = $request->all();

        $count = 0;

        // dd($post);
        for ($i = 0; $i < count($post['id']); $i ++) :
            $index = $post['id'][$i];

            $home_section = OffersSection::findOrFail($index);

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

    public function EditGet(OffersSection $section) {
        $data['section'] = $section;
        $data['ids'] = $section->offers()->pluck('products.id')->toArray();
        $data['products'] = Product::where('deleted', 0)->where('hidden', 0)->orderBy('id', 'desc')->get();

        return view('admin.offers_sections_edit', ['data' => $data]);
    }

    public function EditPost(Request $request, OffersSection $section) {
        $post = $request->except(['products']);

        if ($request->file('icon')) {
            $image_name = $request->file('icon')->getRealPath();
            Cloudder::upload($image_name, null);
            $imagereturned = Cloudder::getResult();
            $image_id = $imagereturned['public_id'];
            $image_format = $imagereturned['format'];    
            $image_new_name = $image_id.'.'.$image_format;
            $post['icon'] = $image_new_name;
        }

        $section->update($post);

        if (isset($request->products) && count($request->products) > 0) {
            $section->offers()->sync($request->products);
        }

        return redirect()->route('offers_control.index');
    }

    public function details(OffersSection $section) {
        $data['section'] = $section;

        return view('admin.offers_sections_details', ['data' => $data]);
    }

    // delete
    public function delete(OffersSection $section) {
        $section->offers()->delete();

        $section->delete();

        return redirect()->back();
    }
}