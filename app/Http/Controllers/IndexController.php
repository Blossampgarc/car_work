<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\attributes;
use App\Models\company;
use App\Models\car_details;
use App\Models\category;
use App\Models\subcategory;
use App\Models\accessories;
use App\Models\brand;
use App\Models\rating;
use App\Models\contact_details;


use Illuminate\Support\Str;
use App\Mail\mailer;
use Session;
use Helper;
use Mail;
use Carbon\Carbon;
use \Crypt;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $accessories = accessories::where('is_active', 1)->where('is_deleted', 0)->get();
        $best_seller = car_details::where('is_active', 1)->where('is_deleted', 0)->where('best_seller', 1)->get();
        $featured = car_details::where('is_active', 1)->where('is_deleted', 0)->where('is_featured', 1)->get();
        $new_product = car_details::where('is_active', 1)->where('is_deleted', 0)->where('created_at', '>=', Carbon::now()->subDays(2)->toDateTimeString())->get();
        return view('web.index')->with(compact('accessories', 'best_seller', 'featured', 'new_product'));
    }

    // public function product($id = '')
    // {
    //     // try {
    //     //     $subcategory_id = Crypt::decrypt($id);
    //     // } catch (\Throwable $th) {
    //     //     return redirect()->back()->with('message', 'Error : ' . $th->getMessage());
    //     // }
    //     if ($id != '') {
    //         $product = car_details::where('subcategory_id', $subcategory_id)->where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'desc')->paginate(20);
    //     } else {
    //         $product = car_details::where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'desc')->paginate(20);
    //     }


    //     return view('web.product')->with(compact('product'));
    // }

    public function product()
    {
        $product = car_details::where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'desc')->paginate(20);

        return view('web.product')->with(compact('product'));
    }

    public function subcategory_products($subcat_id = "")
    {
        if ($subcat_id != "") {
            try {
                $id = Crypt::decrypt($subcat_id);
            } catch (\Throwable $th) {
                return redirect()->back()->with('message', 'Error : ' . $th->getMessage());
            }
            $cat_products = car_details::where('subcategory_id', $id)->paginate(20);
            if (!$cat_products) {
                return redirect()->back()->with('notify_error', 'No record Found');
            }
            return view('web.subcategory-product-details')->with(compact('cat_products'));
        } else {
            return redirect()->back()->with('notify_error', 'No record Found');
        }
    }

    public function brand_product($id = "")
    {
       
        if ($id != "") {
            try {
                $id = Crypt::decrypt($id);
            } catch (\Throwable $th) {
                return redirect()->back()->with('message', 'Error : ' . $th->getMessage());
            }
            $products = car_details::where("is_active", 1)->where("brand_id", $id)->paginate(20);
            if (!$products) {
                return redirect()->back()->with('notify_error', 'No record Found');
            }
            return view('web.brand-product-details')->with(compact('products', 'id'));
        } else {
            return redirect()->back()->with('notify_error', 'No record Found');
        }
    }


    public function brand_category($id = "")
    {
        if ($id != "") {
            try {
                // $id = Crypt::decrypt($id);
            $category = category::where('brand_id',$id )->where('is_active', 1)->where('ParentId', 0)->get();
            } catch (\Throwable $th) {
                return redirect()->back()->with('message', 'Error : ' . $th->getMessage());
            }
            $products = car_details::where("is_active", 1)->where("brand_id", $id)->paginate(20);
            if (!$products) {
                return redirect()->back()->with('notify_error', 'No record Found');
            }
            return view('web.category_page')->with(compact('category', 'id'));
        } else {
            return redirect()->back()->with('notify_error', 'No record Found');
        }
    }

    public function brand_products_show(Request $request)
    {
        $ids = $request->id;
        $products = car_details::whereIn('brand_id', explode(",", $ids))->where('is_active', 1)->get();

        $body = '';
        if ($products->count() > 0) {
            foreach ($products as $key => $value) {
                $company = company::where('is_active', 1)->where('id', $value->company_id)->first();

                $img = asset($value->image);
                $price = number_format($value->gt_price, 2, '.', ',');
                $slug = route("detail", Crypt::encrypt($value->id));

                $body .= '<div class="row product-row">
                        <div class="col-md-9">
                            <div class="product-main">
                                <div class="product-imgg">
                                    <img src="' . $img . '" />
                                </div>
                                <div class="product-info">
                                    <h6>' . $company->name . '</h6>
                                    <h5>' . $value->model . '</h5>
                                    <p><span>' . $value->type . '</span></p>
                                    
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="starting-price">
                                <p>from <span>' . '$' . $price . '</span></p>
                                <a href="' . $slug . '">View Details</a>
                            </div>
                        </div>
                    </div>';
            }
        } else {
            $body = '<div class="col-md-12">
                    <div class="alert alert-warning" style="margin:20% 0;text-align: center;">
                    <strong>No Records Found</strong>
                    </div>
                    </div>';
        }
        return response()->json(['body' => $body]);
    }


    /*    public function search_detail(Request $request)
        {
            // dd($request);
            $product = car_details::where('is_active', 1)->where('is_deleted', 0);
            if ($request->model) {
                $product = $product->where('model', 'LIKE', "%" . $request->model . "%");
            }
            if ($request->year) {
                $product = $product->where('from_year', '>=', $request->year);
            }
            if ($request->make) {
                $company = company::select('id')->where('is_active', 1)->where('is_deleted', 0)->where('name', 'LIKE', "%" . $request->make . "%")->get()->toArray();
                $product = $product->whereIn('company_id', $company);
            }
            // dd("no");
            // dd($q);
            $product = $product->paginate(20);
            $product->appends(['year' => $request->year, 'make' => $request->make, 'model' => $request->model]);
            // dd($product);
            return view('web.product')->with(compact('product'));
            // dd("no");

        }

        public function search_text(Request $request)
        {
            if ($request->text) {
                $product = car_details::where('is_active', 1)->where('is_deleted', 0)
                    ->where('drilled_no', 'LIKE', "%" . $request->text . "%")
                    ->orWhere('type1_no', 'like', '%' . $request->text . '%')
                    ->orWhere('type3_no', 'like', '%' . $request->text . '%')
                    ->orWhere('type5_no', 'like', '%' . $request->text . '%')
                    ->orWhere('disc_size_type', 'like', '%' . $request->text . '%')
                    ->orderBy('id', 'desc')
                    ->paginate(20);
            } else {
                $product = car_details::where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'desc')->paginate(20);
            }
            return view('web.product')->with(compact('product'));
    } */


    public function search_detail()
    {

        $product = car_details::where('is_active', 1)->where('is_deleted', 0);
        if ($request->model) {
            $product = $product->where('model', 'LIKE', "%" . $request->model . "%");
        }
        if ($request->year) {
            $product = $product->where('from_year', '>=', $request->year);
        }
        if ($request->make) {
            $company = company::select('id')->where('is_active', 1)->where('is_deleted', 0)->where('name', 'LIKE', "%" . $request->make . "%")->get()->toArray();
            $product = $product->whereIn('company_id', $company);
        }
        // dd("no");
        // dd($q);
        $product = $product->paginate(20);
        $product->appends(['year' => $request->year, 'make' => $request->make, 'model' => $request->model]);
        // dd($product);
        return view('web.product')->with(compact('product'));
        // dd("no");

    }

    public function search_text(Request $request)
    {

        if ($request->text) {
            $product = car_details::where('is_active', 1)->where('is_deleted', 0)
                ->where('drilled_no', 'LIKE', "%" . $request->text . "%")
                ->orWhere('type1_no', 'like', '%' . $request->text . '%')
                ->orWhere('type3_no', 'like', '%' . $request->text . '%')
                ->orWhere('type5_no', 'like', '%' . $request->text . '%')
                ->orWhere('disc_size_type', 'like', '%' . $request->text . '%')
                ->orderBy('id', 'desc')
                ->paginate(20);
        } else {
            $product = car_details::where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'desc')->paginate(20);
        }
        return view('web.product')->with(compact('product'));
    }

    public function get_make(Request $request)
    {
        $product = car_details::select('company_id')->where('is_active', 1)->where('is_deleted', 0)->where('from_year', '>=', $_POST['year'])->get()->toArray();
        $company = company::where('is_active', 1)->where('is_deleted', 0)->whereIn('id', $product)->get();
        $body = '';
        foreach ($company as $key => $value) {
            $body .= '<option value="' . $value->name . '"></option>';
        }
        $status['message'] = $body;
        $status['status'] = 1;
        return json_encode($status);
    }

    public function get_model()
    {

        if (isset($_POST['year']) && !empty($_POST['year'])) {
            $year = $_POST['year'];
        } else {
            $year = 0;
        }
        $company = company::where('is_active', 1)->where('is_deleted', 0)->where('name', $_POST['make'])->first();
        $body = '';
        if ($company) {
            $product_model = car_details::where('is_active', 1)->where('is_deleted', 0)->where('company_id', $company->id)->where('from_year', '>=', $year)->get();
            if ($product_model) {
                foreach ($product_model as $key => $value) {
                    $body .= '<option value="' . $value->model . '"></option>';
                }
            }
        }


        $status['message'] = $body;
        $status['status'] = 0;
        return json_encode($status);
    }


    public function inner_access()
    {
        return view('web.inner_access');
    }

    public function category_list($accessories_id)
    {
        try {
            $accessories_id = Crypt::decrypt($accessories_id);
        } catch (\Throwable $th) {
            return redirect()->back()->with('message', 'Error : ' . $th->getMessage());
        }

        //dd($accessories_id);

        $accessory = accessories::where('is_active', 1)->where('is_deleted', 0)->where('id', $accessories_id)->first();

        $category = category::where('is_active', 1)->where('is_deleted', 0)->where('accessories_id', $accessories_id)->get();

        return view('web.categorylist')->with(compact('category', 'accessory'));
    }

    public function subcategory_list($category_id)
    {

        try {
            $category_id = Crypt::decrypt($category_id);
        } catch (\Throwable $th) {
            return redirect()->back()->with('message', 'Error : ' . $th->getMessage());
        }
        $category = category::where('is_active', 1)->where('is_deleted', 0)->where('id', $category_id)->first();

        $subcategory = subcategory::where('is_active', 1)->where('is_deleted', 0)->where('category_id', $category_id)->get();
        return view('web.subcategorylist')->with(compact('subcategory', 'category'));
    }

    public function detail($id)
    {

        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            return redirect()->back()->with('message', 'Error : ' . $th->getMessage());
        }

        $product = car_details::where('is_active', 1)->where('is_deleted', 0)->where('id', $id)->first();

        $product_recently = car_details::where('is_active', 1)->where('is_deleted', 0)->where('category_id', $product->category_id)->where('subcategory_id', $product->subcategory_id)->orderBy('id', 'DESC')->take(8)->get();

        $rating = rating::where('product_id', $product->id)->where('is_active', 1)->get();
        // dd($product);
        return view('web.detail')->with(compact('product', 'rating', 'product_recently'));
    }

    public function ratingSubmit(Request $request)
    {

        $rating = new rating;
        $rating->product_id = $request->product_id;
        $rating->rating_name = $request->rating_name;
        $rating->rating_email = $request->rating_email;
        $rating->rating_star = $request->rating_star;
        $rating->rating_content = $request->rating_content;
        $rating->save();
        $rating_info = intval($this->rating_info($request->product_id));
        //dd($rating_info);
        car_details::where('is_active', 1)->where('id', $request->product_id)->update(['ratings_average' => $rating_info]);
        return redirect()->back()->with('success', 'Thankyou for submitting your review.');
    }

    private function rating_info($id)
    {
        $reviews = rating::where("product_id", $id)->get();
        if (sizeof($reviews)) {
            $avg = 0;
            foreach ($reviews as $rev) {
                $avg += $rev['rating_star'];
            }
            return round($avg / count($reviews));
        } else {
            return 0;
        }
    }

    public function about()
    {
        return view('web.about');
    }

    public function contact()
    {
        return view('web.contact');
    }

    public function brand()
    {

        $brand = brand::where('is_active', 1)->where('is_deleted', 0)->get();
        return view('web.brand')->with(compact('brand'));
    }

    public function search()
    {
        $interior_category = category::where('accessories_id', 1)->get();
        $exteriror_category = category::where('accessories_id', 2)->get();
        $performance_parts_category = category::where('accessories_id', 3)->get();
        return view('web.search')->with(compact('interior_category', 'exteriror_category', 'performance_parts_category'));
    }

    public function search_more_category()
    {
        $lighting_category = category::where('accessories_id', 4)->get();
        $wheels_tries_category = category::where('accessories_id', 5)->get();
        $performance_parts_category = category::where('accessories_id', 3)->get();
        return view('web.more-categories')->with(compact('lighting_category', 'wheels_tries_category', 'performance_parts_category'));
    }

    public function account()
    {
        if (Auth::check()) {
            return redirect()->route('user_profile')->with('message', "You are already logged in");
        }
        return view('web.account');
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('user_profile')->with('message', "You are already logged in");
        }
        return view('web.account');
    }

    public function post_ajax_call(Request $request)
    {

        $ajax_company = explode(",", $_POST['company']);
        $min = isset($_POST['minimum_range']) ? $_POST['minimum_range'] : '';
        $max = isset($_POST['maximum_range']) ? $_POST['maximum_range'] : '';
        if (isset($_POST['company']) && !empty($_POST['company'])) {
            $query = car_details::where("is_active", 1)->whereIn('company_id', $ajax_company)->whereBetween('gt_price', [$min, $max])->get();

            // dd($min,$max,$query);
        } else {
            $query = car_details::where("is_active", 1)->get();
        }
        $body = '';
        if ($query->count() > 0) {
            foreach ($query as $key => $value) {
                $company = company::where('is_active', 1)->where('id', $value->company_id)->first();

                $img = asset($value->image);
                $price = number_format($value->gt_price, 2, '.', ',');
                $slug = route("detail", Crypt::encrypt($value->id));

                $body .= '<div class="row product-row">
                        <div class="col-md-9">
                            <div class="product-main">
                                <div class="product-imgg">
                                    <img src="' . $img . '" />
                                </div>
                                <div class="product-info">
                                    <h6>' . $company->name . '</h6>
                                    <h5>' . $value->model . '</h5>
                                    <p><span>' . $value->type . '</span></p>
                                    
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="starting-price">
                                <p>from <span>' . '$' . $price . '</span></p>
                                <a href="' . $slug . '">View Details</a>
                            </div>
                        </div>
                    </div>';
            }
        } else {
            $body = '<div class="col-md-12">
                    <div class="alert alert-warning" style="margin:20% 0;text-align: center;">
                    <strong>No Records Found</strong>
                    </div>
                    </div>';
        }
        return response()->json(['body' => $body]);
    }

    public function contact_submit(Request $request)
    {
        $token_ignore = ['_token' => ''];
        $post_feilds = array_diff_key($_POST, $token_ignore);
        $create = contact_details::create($post_feilds);
        $details = [
            'title' => 'Mail from Smart Auto Parts',
        ];

        $mail = \Mail::to($_POST['email'])->send(new mailer());
        // dd($mail);
        return redirect()->route('welcome');
        // return redirect()->back();
    }

    
    /* public function get_make(Request $request)
        {
            $product = car_details::select('make_id')->where('is_active', 1)->where('is_deleted', 0)->where('from_year', $_GET['year'])->get()->toArray();
            $company = make::where('is_active', 1)->where('is_deleted', 0)->whereIn('id', $product)->get();
            $body = '';
            $body .= '<option value="">Select Make</option>';
            foreach ($company as $key => $value) {
                $body .= '<option value="' . $value->name . '">' . $value->name . '</option>';
                // dd($value->name);
            }
            $status['message'] = $body;
            $status['status'] = 1;
            return json_encode($status);
            // dd($body,"here");
        }
        public function get_year(Request $request)
        {

            $response = $this->get_web_page("https://apps.semadata.org/sdapi/v1/lookup/years?token=EAAAABXnsrNanFgYlYfbSQYbsFfNvli9mhsLHYt+ZgT/JBkb");
            $resArr = array();
            $resArr = json_decode($response);
            echo "<pre>";
            print_r($resArr);
            echo "</pre>";
            $years = car_details::where('is_active', 1)->groupBy('from_year')->pluck('from_year');
            $body = '';
            $body .= '<option value="">Select Year</option>';
            foreach ($years as $key => $year) {
                $body .= '<option value="' . $year . '">' . $year . '</option>';
            }
            $status['message'] = $body;
            $status['status'] = 1;
            return json_encode($status);
        }
        public function get_model()
        {

        if (isset($_GET['year']) && !empty($_GET['year'])) {
            $year = $_GET['year'];
        } else {
            $year = 0;
        }
        $company = make::where('is_active', 1)->where('is_deleted', 0)->where('name', $_GET['make'])->first();
        $body = '';
        if ($company) {
            $product_model = car_details::where('is_active', 1)->where('is_deleted', 0)->where('make_id', $company->id)->where('from_year', $year)->groupBy('model')->pluck('model');
            // dd($product_model);
            $body .= '<option value="">Select Model</option>';
            if ($product_model) {
                foreach ($product_model as $key => $value) {
                    $body .= '<option value="' . $value . '">' . $value . '</option>';
                }
            }
        }
        $status['message'] = $body;
        $status['status'] = 1;
        return json_encode($status);
    } */


    public function get_web_page($url)
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER         => false,  // don't return headers
            CURLOPT_FOLLOWLOCATION => true,   // follow redirects
            CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
            CURLOPT_ENCODING       => "",     // handle compressed
            CURLOPT_USERAGENT      => "test", // name of client
            CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
            CURLOPT_TIMEOUT        => 120,    // time-out on response
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);

        $content  = curl_exec($ch);

        curl_close($ch);

        return $content;
    }

public function get_cat()
{
//      $accessories = accessories::where('is_active', 1)->where('is_deleted', 0)->get();
//         $best_seller = car_details::where('is_active', 1)->where('is_deleted', 0)->where('best_seller', 1)->get();
//         $featured = car_details::where('is_active', 1)->where('is_deleted', 0)->where('is_featured', 1)->get();
//         $new_product = car_details::where('is_active', 1)->where('is_deleted', 0)->where('created_at', '>=', Carbon::now()->subDays(2)->toDateTimeString())->get();
//     $options = array(
//             CURLOPT_RETURNTRANSFER => true,   // return web page
//             CURLOPT_HEADER         => false,  // don't return headers
//             CURLOPT_FOLLOWLOCATION => true,   // follow redirects
//             CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
//             CURLOPT_ENCODING       => "",     // handle compressed
//             CURLOPT_USERAGENT      => "test", // name of client
//             CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
//             CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
//             CURLOPT_TIMEOUT        => 120,    // time-out on response
//         );

//         $ch = curl_init("https://apps.semadata.org/sdapi/v1/export/branddatasets?token=EAAAABXnsrNanFgYlYfbSQYbsFfNvli9mhsLHYt+ZgT/JBkb");
//         curl_setopt_array($ch, $options);

//         $content  = curl_exec($ch);
//         $resArr = array();
//             $resArr = json_decode($content);
//             // dd($resArr);
//              curl_close($ch);
//              if (is_array($resArr) || is_object($resArr) )
//  {
//              foreach ($resArr as $value) {
//                  if($value != ''){
//              foreach ($value as $v) {
//              $replace = str_replace(' ', '-', $v->BrandName);
//              $hi = strtolower($replace);
//              $users = new brand();
//              $users->brand_id = $v->AAIABrandId;
//              $users->BrandName = $v->BrandName;
//              $users->slug = $hi;
//              $users->DatasetId = $v->DatasetId;
//              $users->DatasetName = $v->DatasetName;
//                          $users->save();
//                  }
//  }
// return redirect()->route('welcome')->with(compact('content','accessories','best_seller','featured','new_product'));
// }
               
//              }
                
       
            }
public function get_product(){
//      $brands = brand::select('brand_id')->where('is_active', 1)->where('is_deleted', 0)->get();
// // dd($brands);
//       $accessories = accessories::where('is_active', 1)->where('is_deleted', 0)->get();
//         $best_seller = car_details::where('is_active', 1)->where('is_deleted', 0)->where('best_seller', 1)->get();
//         $featured = car_details::where('is_active', 1)->where('is_deleted', 0)->where('is_featured', 1)->get();
//         $new_product = car_details::where('is_active', 1)->where('is_deleted', 0)->where('created_at', '>=', Carbon::now()->subDays(2)->toDateTimeString())->get();



    $aaid = 'GMGJ';
    $url = "https://apps.semadata.org/sdapi/v1/lookup/productsbycategory";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
       "Content-Type: application/x-www-form-urlencoded",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    

    $data = "token=EAAAABXnsrNanFgYlYfbSQYbsFfNvli9mhsLHYt+ZgT/JBkb&CategoryId=6224";

    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);
    curl_close($curl);
    $data_response = json_decode($resp);
    dd($data_response);
//        if (is_array($data_response) || is_object($data_response) )
//        {
//             foreach ($data_response as $value) {
//                 // dd($value);
//                 if($data_response->Categories != ''){
//                 if($value != '' && is_array($value)){
// // dd($value);
//             foreach ($value as $v) {
//                 // dd($v);
//             $replace = str_replace(' ', '-', $v->Name);
//             $hi = strtolower($replace);
//             $hey = strtolower($aaid);
//             $hello = $hi.'-'.$hey;
//             $get_slug = category::where('slug',$hello)->first();
//             if($get_slug == ''){
//             $users = new category();
//             $users->brand_id = $aaid;
//             $users->ParentId = $v->ParentId;
//             $users->category_id = $v->CategoryId; 
//             $users->name = $v->Name;
//             $users->slug = $hello;
//                         $users->save();

//                       if($v->Categories != ''){
//     foreach ($v->Categories as $sub_cat) {
//             $replace = str_replace(' ', '-', $sub_cat->Name);
//             $hi = strtolower($replace);
//             $user = new category();
//             $user->brand_id = $aaid;
//             $hey = strtolower($aaid);
//             $user->ParentId = $users->id;
//             $user->category_id = $sub_cat->CategoryId;
//             $user->name = $sub_cat->Name;
//             $user->slug = $hi.'-'.$hey;
//                         $user->save();
//                         if($sub_cat->Categories != ''){
//     foreach ($sub_cat->Categories as $child_cat) {
//             $replace = str_replace(' ', '-', $child_cat->Name);
//             $hi = strtolower($replace);
//             $use = new category();
//             $use->brand_id = $aaid;
//             $hey = strtolower($aaid);
//             $use->ParentId = $user->id;
//             $use->category_id = $child_cat->CategoryId;
//             $use->name = $child_cat->Name;
//             $use->slug = $hi.'-'.$hey;
//                         $use->save();
//     }
//                 }
//     }
//                 }
// }

// }
// }
//                 }



//             }
        
//         }

        
    
//     return redirect()->route('welcome')->with(compact('data_response','accessories','best_seller','featured','new_product'));
  }
}
