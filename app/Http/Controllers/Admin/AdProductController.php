<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use App\AdProduct;
use App\AdProductImage;
use App\Category;
use App\SubCategory;
use App\SubTwoCategory;
use App\SubThreeCategory;
use App\User;
use App\Setting;
use App\BestOffer;
use App\Comment;


class AdProductController extends AdminController{

    // show
    public function show() {
        $data['products'] = AdProduct::where('deleted', 0)->orderBy('id','desc')->get();
        
        return view('admin.adproducts', ['data' => $data]);
    }

    // add get
    public function addGet() {
        $data['categories'] = Category::orderBy('created_at', 'desc')->where('type' , 2)->get();
        $data['users'] = User::orderBy('created_at', 'desc')->get();
        return view('admin.ad_product_form', ['data' => $data]);
    }

    // add post
    public function AddPost(Request $request){
        $user = User::findOrFail($request->user_id);

        if($user->free_ads_count == 0 && $user->paid_ads_count == 0){
            return redirect('admin-panel/ad_products/add')->with('status', 'There are not enough ads for this user');
        }

        if($user->free_ads_count > 0){
            $count = $user->free_ads_count;
            $user->free_ads_count = $count - 1;
        }else{
            $count = $user->paid_ads_count;
            $user->paid_ads_count = $count - 1;
        }
        $user->save();

        $ad_period = Setting::find(1)['ad_period'];

        $selected = $request->selected ? 1 : 0;

        $product = new AdProduct();
        $product->user_id = $user->id;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->publication_date = date("Y-m-d H:i:s");
        $product->expiry_date = date('Y-m-d H:i:s', strtotime('+'.$ad_period.' days'));
        $product->sub_category_id = $request->sub_category_id;
        $product->sub_category_two_id = $request->sub_category_two_id;
        $product->sub_category_three_id = $request->sub_category_three_id;
        $product->selected = $selected;
        $product->save();        

        
        if ( $images = $request->file('images') ) {
            foreach ($images as $image) {
                $image_name = $image->getRealPath();
                Cloudder::upload($image_name, null);
                $imagereturned = Cloudder::getResult();
                $image_id = $imagereturned['public_id'];
                $image_format = $imagereturned['format'];    
                $image_new_name = $image_id.'.'.$image_format;
                $image = new AdProductImage();
                $image->image = $image_new_name;
                $image->product_id = $product->id;
                $image->save();
            }
        }

        return redirect('admin-panel/ad_products/show');
    }

    // edit get
    public function EditGet(Request $request) {
        $data['product'] = AdProduct::find($request->id);
        $data['categories'] = Category::orderBy('created_at', 'desc')->where('deleted' , 0)->where('type' , 2)->get();
        $data['sub_categories'] = SubCategory::where('category_id' , $data['product']['category_id'])->where('deleted' , 0)->get();
        $data['sub_two_categories'] = SubTwoCategory::where('sub_category_id' , $data['product']['sub_category_id'])->where('deleted' , 0)->get();
        $data['sub_three_categories'] = SubThreeCategory::where('sub_category_id' , $data['product']['sub_category_two_id'])->where('deleted' , 0)->get();
        $data['users'] = User::orderBy('created_at', 'desc')->get();
        $data['product']->images = AdProductImage::where('product_id' , $data['product']['id'])->get();

        return view("admin.ad_product_edit", ["data" => $data]);
    }

    // edit post
    public function EditPost(Request $request){

        $selected = $request->selected ? 1 : 0;
        $product = AdProduct::find($request->id);
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->sub_category_two_id = $request->sub_category_two_id;
        $product->sub_category_three_id = $request->sub_category_three_id;
        $product->selected = $selected;
        $product->save();   


        if ( $main_product_image = $request->file('main') ) {
            $main_image = AdProductImage::findOrFail($product->images[0]->id);
            $image = $main_image->image;
            $publicId = substr($image, 0 ,strrpos($image, "."));    
            Cloudder::delete($publicId);
            $image_name = $main_product_image->getRealPath();
            Cloudder::upload($image_name, null);
            $imagereturned = Cloudder::getResult();
            $image_id = $imagereturned['public_id'];
            $image_format = $imagereturned['format'];    
            $image_new_name = $image_id.'.'.$image_format;
            $main_image['image'] = $image_new_name;
            $main_image->save();
        }

        if ( $images = $request->file('images') ) {
            foreach ($images as $image) {
                $image_name = $image->getRealPath();
                Cloudder::upload($image_name, null);
                $imagereturned = Cloudder::getResult();
                $image_id = $imagereturned['public_id'];
                $image_format = $imagereturned['format'];    
                $image_new_name = $image_id.'.'.$image_format;
                $product_image = new AdProductImage();
                $product_image->image = $image_new_name;
                $product_image->product_id = $product->id;
                $product_image->save();
            }
        }

        return redirect('admin-panel/ad_products/show');
    }

    // delete product image
    public function delete_product_image(Request $request) {
        $image = AdProductImage::find($request->id);
        $theimage = $image['image'];
        $publicId = substr($theimage, 0 ,strrpos($theimage, "."));    
        Cloudder::delete($publicId);
        $image->delete();

        return redirect()->back();
    }

    // product details
    public function details(Request $request) {
        $data['product'] = AdProduct::find($request->id);

        return view('admin.ad_product_details', ['data' => $data]);
    }

    // delete product
    public function delete(Request $request) {
        $product = AdProduct::find($request->id);
        $product->deleted = 1;
        $product->save();

        return redirect()->back();
    }

    // add to best offers
    public function addToBestOffers(AdProduct $product) {
        BestOffer::create(['product_id' => $product->id]);

        return redirect()->back();
    }

    // remove from best offers
    public function removeFromBestOffers(AdProduct $product) {
        $bestOffer = BestOffer::where('product_id', $product->id)->first();
        $bestOffer->delete();

        return redirect()->back();
    }

    // show comments
    public function showComments(AdProduct $product) {
        $data['product'] = $product;

        return view('admin.comments', compact('data'));
    }

    
}