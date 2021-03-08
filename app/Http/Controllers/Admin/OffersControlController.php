<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\OffersSection;
use App\Product;
use App\AdProduct;
use App\ControlOffer;

class OffersControlController extends AdminController{
    // show
    public function show() {
        $data['offers_sections'] = OffersSection::where('type', 1)->orderBy('sort', 'asc')->get();

        return view('admin.offers_sections', ['data' => $data]);
    }

    // show ad
    public function showAd() {
        $data['offers_sections'] = OffersSection::where('type', 2)->orderBy('sort', 'asc')->get();

        return view('admin.offers_ad_sections', ['data' => $data]);
    }

    // add (get)
    public function AddGet() {
        $data['products'] = Product::where('deleted', 0)->where('hidden', 0)->orderBy('id', 'desc')->get();

        return view('admin.offers_sections_form', ['data' => $data]);
    }

    // add (get)
    public function AddGetAd() {
        $data['products'] = AdProduct::where('deleted', 0)->where('status', 1)->orderBy('id', 'desc')->get();

        return view('admin.offers_ad_sections_form', ['data' => $data]);
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

    // add ad (post)
    public function AddPostAd(Request $request) {
        $post = $request->except(['products']);

        $image_name = $request->file('icon')->getRealPath();
        Cloudder::upload($image_name, null);
        $imagereturned = Cloudder::getResult();
        $image_id = $imagereturned['public_id'];
        $image_format = $imagereturned['format'];    
        $image_new_name = $image_id.'.'.$image_format;
        $post['icon'] = $image_new_name;
        $post['type'] = 2;

        $section = OffersSection::create($post);

        if(count($request->products) > 0) {
            for ($i = 0; $i < count($request->products); $i ++) {
                ControlOffer::create(['offers_section_id' => $section['id'], 'offer_id' => $request->products[$i]]);
            }
        }

        return redirect()->route('offers_control.ad.index');
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

    public function EditGetAd(OffersSection $section) {
        $data['section'] = $section;
        $data['ids'] = $section->adOffers()->pluck('ad_products.id')->toArray();
        $data['products'] = AdProduct::where('deleted', 0)->where('status', 1)->orderBy('id', 'desc')->get();
        // dd($data['products']);

        return view('admin.offers_ad_sections_edit', ['data' => $data]);
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

    public function EditPostAd(Request $request, OffersSection $section) {
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
            $section->adOffers()->sync($request->products);
        }

        return redirect()->route('offers_control.ad.index');
    }

    public function details(OffersSection $section) {
        $data['section'] = $section;

        return view('admin.offers_sections_details', ['data' => $data]);
    }

    public function detailsAd(OffersSection $section) {
        $data['section'] = $section;

        return view('admin.offers_ad_sections_details', ['data' => $data]);
    }

    // delete
    public function delete(OffersSection $section) {
        $section->offers()->delete();

        $section->delete();

        return redirect()->back();
    }
}