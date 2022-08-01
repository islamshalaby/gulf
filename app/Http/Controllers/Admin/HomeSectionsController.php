<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\HomeSection;
use App\HomeElement;
use App\Ad;
use App\Category;
use App\Brand;
use App\AdProduct;
use App\CarType;
use App\Company;
use App\Product;

class HomeSectionsController extends AdminController{
    // get all home sections
    public function show(){
        $data['home_sections'] = HomeSection::where('section_type', 1)->orderBy('sort' , 'asc')->get();
        return view('admin.home_sections' , ['data' => $data]);
    }

    // update sections sorting
    public function updateSectionsSorting(Request $request) {
        $post = $request->all();

        $count = 0;

        for ($i = 0; $i < count($post['id']); $i ++) :
            $index = $post['id'][$i];

            $home_section = HomeSection::findOrFail($index);

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

    // get add
    public function addGet() {
        return view('admin.home_section_form');
    }

    // fetch ads
    public function fetchData(Request $request) {
        if ($request->element == 1 || $request->element == 5) {
            $rows = Ad::orderBy('id' , 'desc')->get();
        }else if ($request->element == 2) {
            $rows = CarType::where('deleted', 0)->orderBy('id' , 'desc')->get();
        }else if ($request->element == 3) {
            $rows = Company::where('deleted', 0)->orderBy('id' , 'desc')->get();
        }else if ($request->element == 4) {
            $rows = Product::where('deleted', 0)->where('hidden', 0)->orderBy('id' , 'desc')->get();
        }
        
        $data = json_decode(($rows));

        return response($data, 200);
    }

    // add post
    public function addPost(Request $request) {
        $post = $request->all();
        $home_section_post = $request->except('ads', 'ad', 'offers', 'categories', 'brands');

        $home_section = HomeSection::create($home_section_post);

        if (isset($post['ads']) && count($post['ads']) > 0) {
            foreach($post['ads'] as $ad) {
                $home_element['element_id'] = $ad;
                $home_element['home_id'] = $home_section['id'];
                HomeElement::create($home_element);
            }
        }

        if (isset($post['mini_ads']) && count($post['mini_ads']) > 0) {
            foreach($post['mini_ads'] as $ad) {
                $home_element['element_id'] = $ad;
                $home_element['home_id'] = $home_section['id'];
                HomeElement::create($home_element);
            }
        }

        if (isset($post['categories']) && count($post['categories']) > 0) {
            foreach($post['categories'] as $category) {
                $home_element['element_id'] = $category;
                $home_element['home_id'] = $home_section['id'];
                HomeElement::create($home_element);
            }
        }

        if (isset($post['brands']) && count($post['brands']) > 0) {
            foreach($post['brands'] as $brand) {
                $home_element['element_id'] = $brand;
                $home_element['home_id'] = $home_section['id'];
                HomeElement::create($home_element);
            }
        }

        if (isset($post['offers']) && count($post['offers']) > 0) {
            foreach($post['offers'] as $offer) {
                $home_element['element_id'] = $offer;
                $home_element['home_id'] = $home_section['id'];
                HomeElement::create($home_element);
            }
        }

        return redirect()->route('home_sections.index');
    }

    // edit get
    public function EditGet(HomeSection $homeSection) {
        $data['home_section'] = $homeSection;
        $data['home_element'] = $homeSection->homeElements;
        $data['elements'] = [];

        for ($i = 0; $i < count($data['home_element']); $i ++) {
            $data['elements'][$i] = $data['home_element'][$i]->element_id;
        }

        $data['elms'] = json_encode($data['elements']);
        // dd($data['elms']);
        return view('admin.home_section_edit', ['data' => $data]);
    }

    // edit post
    public function EditPost(Request $request, HomeSection $homeSection) {
        $post = $request->all();
        $home_section_post = $request->except('ads', 'ad', 'offers', 'categories', 'brands');

        $homeSection->update($home_section_post);
        $homeSection->homeElements()->delete();
        if (isset($post['ads']) && count($post['ads']) > 0) {
            foreach($post['ads'] as $ad) {
                $home_element['element_id'] = $ad;
                $home_element['home_id'] = $homeSection->id;
                HomeElement::create($home_element);
            }
        }

        if (isset($post['mini_ads']) && count($post['mini_ads']) > 0) {
            foreach($post['mini_ads'] as $ad) {
                $home_element['element_id'] = $ad;
                $home_element['home_id'] = $homeSection->id;
                HomeElement::create($home_element);
            }
        }

        if (isset($post['categories']) && count($post['categories']) > 0) {
            foreach($post['categories'] as $category) {
                $home_element['element_id'] = $category;
                $home_element['home_id'] = $homeSection->id;
                HomeElement::create($home_element);
            }
        }

        if (isset($post['brands']) && count($post['brands']) > 0) {
            foreach($post['brands'] as $brand) {
                $home_element['element_id'] = $brand;
                $home_element['home_id'] = $homeSection->id;
                HomeElement::create($home_element);
            }
        }

        if (isset($post['offers']) && count($post['offers']) > 0) {
            foreach($post['offers'] as $offer) {
                $home_element['element_id'] = $offer;
                $home_element['home_id'] = $homeSection->id;
                HomeElement::create($home_element);
            }
        }

        if (isset($post['ad'])) {
            $home_element['element_id'] = $post['ad'];
            $home_element['home_id'] = $homeSection->id;
            HomeElement::create($home_element);
        }

        return redirect()->route('home_sections.index');
    }

    // delete
    public function delete(HomeSection $homeSection) {
        $homeSection->homeElements()->delete();

        $homeSection->delete();

        return redirect()->back();
    }

    // details
    public function details(HomeSection $homeSection) {
        $data['home_section'] = $homeSection;
        $data['home_elements'] = $homeSection->homeElements;
        // dd($homeSection->categories);
        return view('admin.home_section_details', ['data' => $data]);
    }

    // get all ad home sections
    public function showAd(){
        $data['home_sections'] = HomeSection::where('section_type', 2)->orderBy('sort' , 'asc')->get();
        return view('admin.ad_home_sections' , ['data' => $data]);
    }

    // get ad add
    public function adAddGet() {
        return view('admin.ad_home_section_form');
    }

    // ad fetch ads
    public function adFetchData(Request $request) {
        
        if ($request->element == 1) { // ads
            $rows = Ad::orderBy('id' , 'desc')->get();
        }else if ($request->element == 2) { // categories
            $rows = Category::where('type', 2)->where('deleted', 0)->orderBy('id' , 'desc')->get();
        }else if ($request->element == 3) { // feature products
            $rows = AdProduct::whereDate('expiry_date', '<', Carbon::now())->where('selected', 1)->orderBy('id' , 'desc')->get();
        }else { // products
            $rows = AdProduct::whereDate('expiry_date', '<', Carbon::now())->orderBy('id' , 'desc')->get();
        }
        
        $data = json_decode(($rows));

        return response($data, 200);
    }

    // ad add post
    public function adAddPost(Request $request) {
        $post = $request->all();
        $home_section_post = $request->except('ads', 'products', 'categories');
        
        $home_section_post['section_type'] = 2;
        $home_section = HomeSection::create($home_section_post);

        if (isset($post['ads']) && count($post['ads']) > 0) {
            foreach($post['ads'] as $ad) {
                $home_element['element_id'] = $ad;
                $home_element['home_id'] = $home_section['id'];
                HomeElement::create($home_element);
            }
        }

        if (isset($post['categories']) && count($post['categories']) > 0) {
            foreach($post['categories'] as $category) {
                $home_element['element_id'] = $category;
                $home_element['home_id'] = $home_section['id'];
                HomeElement::create($home_element);
            }
        }

        if (isset($post['products']) && count($post['products']) > 0) {
            foreach($post['products'] as $product) {
                $home_element['element_id'] = $product;
                $home_element['home_id'] = $home_section['id'];
                HomeElement::create($home_element);
            }
        }

        

        return redirect()->route('ad_home_sections.index');
    }

}