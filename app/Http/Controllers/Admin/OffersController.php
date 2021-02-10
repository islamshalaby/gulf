<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use App\Offer;
use App\Product;
use App\Category;

class OffersController extends AdminController{
    // get all offers
    public function show(){
        $offers_before = Offer::orderBy('sort' , 'asc')->get();
        $data['offers'] = [];
        for($i = 0; $i < count($offers_before); $i++){
            if($offers_before[$i]['type'] == 1){
                $result = Product::find($offers_before[$i]['target_id']);
            }else{
                $result = Category::find($offers_before[$i]['target_id']);
            }

            if($result['deleted'] == 0){
                array_push($data['offers'] , $offers_before[$i]);
            }

        }


        return view('admin.offers' , ['data' => $data]);
    }

    // add get
    public function addGet() {
        return view('admin.offer_form');
    }

    // fetch type
    public function fetchType(Request $request) {
        if ($request->type == 1) {
            $rows = Product::where('deleted', 0)->orderBy('id', 'desc')->get();
        }else if($request->type == 2) {
            $rows = Category::where('deleted', 0)->orderBy('id', 'desc')->get();
        }

        $data = json_decode(($rows));

        return response($data, 200);
    }

    // add post
    public function addPost(Request $request) {
        $post = $request->all();
        $image_name = $request->file('image')->getRealPath();
        Cloudder::upload($image_name, null);
        $imagereturned = Cloudder::getResult();
        $image_id = $imagereturned['public_id'];
        $image_format = $imagereturned['format'];    
        $image_new_name = $image_id.'.'.$image_format;
        $post['image'] = $image_new_name;
        Offer::create($post);

        return redirect()->route('offers.index');
    }

    // update offer sorting
    public function updateOffersSorting(Request $request) {
        $post = $request->all();

        $count = 0;

        // dd($post);
        for ($i = 0; $i < count($post['id']); $i ++) :
            $index = $post['id'][$i];

            $home_section = Offer::findOrFail($index);

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

    // edit get
    public function EditGet(Offer $offer) {
        $data['offer'] = $offer;

        // dd($data['offer']);

        return view('admin.offer_edit', ['data' => $data]);
    }

    // edit post
    public function EditPost(Request $request, Offer $offer) {
        $post = $request->all();
        
        if($request->file('image')){
            $image = $offer->image;
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

        $offer->update($post);

        return redirect()->route('offers.index');
    }

    // delete
    public function delete(Offer $offer) {
        $offer->delete();

        return redirect()->back();
    }

    // details
    public function details(Offer $offer) {
        $data['offer'] = $offer;
        

        return view('admin.offer_details', ['data' => $data]);
    }

}