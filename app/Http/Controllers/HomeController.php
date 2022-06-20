<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\attributes;
use App\Models\packages;
use App\Models\testimonials;
use App\Models\config;
use App\Models\inquiry;
use App\Models\player;
use App\Models\logo;
use App\Models\order_detail;
use App\Models\orders;
use Illuminate\Support\Str;
use Session;
use Helper;
use \Crypt;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {

        // Balance Sheet
        $balance = 0;
        
        
        return view('dashboard')->with(compact('balance'));
    }

    public function index()
    {
        return view('welcome');
    }

    public function steps()
    {
        if(Auth::user()->role_id == 1){
            $projects = attributes::where('attribute' , 'project')->where('is_active' ,1)->get();
            return view('steps')->with(compact('projects'));
        }else{
            return redirect()->back()->with('error', 'No Page Found');
        }
    }
    public function logo()
    {
        $user = Auth::user();
        $logo = logo::orderBy('id','desc')->get();
        $mainLogo = logo::orderBy('id','desc')->first();
        return view('logo')->with('title',"System Configuration")->with(compact('user','logo','mainLogo'));
    }
    public function change_logo(Request $request)
    {               
        $logo = new logo;
        $path = "";
        if ($request->file('pic_attach') != '') {
            $path = ($request->file('pic_attach'))->store('uploads/logo/'.md5(Str::random(20)), 'public');
        }
        $logo->image = $path;
        $logo->save();
        return redirect()->back()->with('success', 'Image has been successfully updated');       
    }
    public function switch_project($project_id)
    {
        if(Auth::user()->role_id == 1){
            $project = attributes::where('id',$project_id)->where('is_active' ,1)->first();
            $data['project_id'] = $project_id;
            Session::put("project_id" , $project_id);
            Helper::activity_log("login",$data);
            return redirect()->route('user_profile')->with('message', "Welcome to ".$project->name);
        }else{
            return redirect()->back()->with('error', 'No Page Found');
        }
    }
    public function user_profile()
    {
        $user = Auth::user();
        if (!$user->role_id == 1) {
            return redirect()->route("welcome");
        }
        return view('user-profile')->with('title',"Home Page")->with(compact('user'));
    }

    public function update_password()
    {
        $user = Auth::user();
        if (!$user->role_id == 1) {
            return redirect()->route("welcome");
        }
        return view('user-password')->with('title',"Home Page")->with(compact('user'));
    }

    public function user_rights()
    {
        $user = Auth::user();
        //dd(Session::get("project_id" ));
        $roles = attributes::where("is_active" ,1)->where('is_deleted' , 0)->get();
        return view('user-rights')->with('title',"User Rights")->with(compact('user','roles'));
    }
    public function user_infoupdate(Request $request)
    {
        $user = User::find(Auth::user()->id);
        
        $user->name = $request->name;
        // $name = explode(" ",$request->name);
        // $edit_feilds['firstname'] = $name[0];
        // $edit_feilds['lastname'] = $name[1];
        // dd($edit_feilds);
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->address = $request->address;
        $user->save();
        // $update = player::where("id" , $user->id)->update($edit_feilds);
        return redirect()->back()->with('message', 'Information updated successfully');
    }
    public function user_passwordupdate(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $post_feilds['password']  = $hashed_password;
        if(password_verify($old_password, $user->password) && $new_password == $confirm_password && $new_password != $old_password) {
            $create = User::where("id" , $user->id)->update($post_feilds);
            return redirect()->back()->with('message', 'Information updated successfully');
        } else{
            return redirect()->back()->with('message', 'Problem updating Information');
        }
    }

    public function user_updates(Request $request)
    {
        $user = User::find($_POST['user_id']);
        if (!is_null($request->emp_id) && $request->emp_id != "") {
            $user->emp_id = $request->emp_id;
        }
        if (!is_null($request->role_id) && $request->role_id !="") {
            $user->role_id = $request->role_id;
        }
        if (!is_null($request->department_id) && $request->department_id != "") {
            $user->department = $request->department_id;
        }
        if (!is_null($request->designations) && $request->designations != "") {
            $user->designation = $request->designations;
        }
        if (!is_null($request->reporting_line_id) && $request->reporting_line_id != "") {
            $user->reporting_line = $request->reporting_line_id;
        }
        if (!is_null($request->salary) && $request->salary != "") {
            $user->salary = $request->salary;
        }
        if (!is_null($request->status) && $request->status != "") {
            $user->is_active = $request->status;
        }
        if (!is_null($request->shift_in) && $request->shift_in != "") {
            $user->shift_in = $request->shift_in;
        }
        if (!is_null($request->shift_out) && $request->shift_out != "") {
            $user->shift_out = $request->shift_out;
        }

        $user->save();
        return redirect()->back()->with('message', 'Information updated successfully');
    }

    public function shift_change()
    {
        
    }
    

// office details start
    public function user_office_details()
    {
        $user = Auth::user();
        return view('user-office-details')->with('title',"Office Details")->with(compact('user'));
    }
    public function user_office_infoupdate(Request $request)
    {
        $user = User::find(Auth::user()->id);
        
        // $user->emp_id = $request->emp_id;
        // $user->email = $request->email;
        // $user->designation = $request->designation;
        // $user->department = $request->department;
        // $user->join_date = $request->join_date;
        // $user->reporting_line = $request->reporting_line;
        $user->bank_account_number = $request->bank_account_number;
        $user->v_model_name = $request->v_model_name;
        $user->v_model_year = $request->v_model_year;
        $user->v_number_plate = $request->v_number_plate;
        
        $user->save();
        // Session::flash('message', 'This is a message!'); 
         Session::flash('alert-class', 'alert-danger'); 
        return redirect()->back()->with('message', 'Information updated successfully');
    }
// office details end

// file details start
    public function user_file_details()
    {
        $user = Auth::user();
        return view('user-file-details')->with('title',"file Details")->with(compact('user'));
    }
    public function user_file_infoupdate(Request $request)
    {
        // $user = User::find(Auth::user()->id);
        
        // $user->emp_id = $request->emp_id;
        // $user->email = $request->email;
        // $user->designation = $request->designation;
        // $user->department = $request->department;
        // $user->join_date = $request->join_date;
        // $user->reporting_line = $request->reporting_line;
        // $user->bank_account_number = $request->bank_account_number;
        // $user->v_model_name = $request->v_model_name;
        // $user->v_model_year = $request->v_model_year;
        // $user->v_number_plate = $request->v_number_plate;
        
        // $user->save();
        // Session::flash('message', 'This is a message!'); 
        // Session::flash('alert-class', 'alert-danger'); 
        // return redirect()->back()->with('success', 'Information updated successfully');
    }
// file details end

    public function upload_image(Request $request)
    {               
        $user = User::find(Auth::user()->id);
        $path = "";
        if ($request->file('pic_attach') != '') {
            $path = ($request->file('pic_attach'))->store('uploads/avatar/'.md5(Str::random(20)), 'public');
        }
        $user->profile_pic = $path;
        $user->save();
        return redirect()->back()->with('success', 'Image has been successfully updated');       
    }
    public function profile_submit(Request $request)
    {
        $user = User::find(Auth::user()->id);
        // Avatar Upload
        if ($request->has('avatar')) {
            if ($request->file('avatar') != '') {
                 $request->validate([
                 'avatar' => ['required', 'mimes:jpeg,png,jpg', 'max:2000']
                ]);
                $path_a = ($request->file('avatar'))->store('uploads/avatar/'.md5(Str::random(20)), 'public');
                $user->profile_pic = $path_a;
                $user->save();
                return redirect()->back()->with('message', 'Profile Picture been updated successfully');
            }
            else{
                 return redirect()->back()->with('error', 'File not found, please update your Profile Picture');
            }
        }
        // Resume Upload
        if ($request->has('cnic_file')) {
            if ($request->file('cnic_file') != '') {
            $request->validate([
             'cnic_file' => ['required', 'mimes:jpeg,png,jpg', 'max:2000']
            ]);
            $path_c = ($request->file('cnic_file'))->store('uploads/cnic/'.md5(Str::random(20)), 'public');
            $user->cnic_doc = $path_c;
            $user->save();
            return redirect()->back()->with('message', 'NIC Picture has been updated successfully');
        }
            else{
                 return redirect()->back()->with('error', 'File not found, please update your NIC Picture');
            }
        }
        // // CNIC Upload
        if ($request->has('cv_file')) {
            if ($request->file('cv_file') != '') {
            $request->validate([
             'cv_file' => ['required', 'mimes:doc,docs,pdf', 'max:5000']
            ]);
            $path_r = ($request->file('cv_file'))->store('uploads/resume/'.md5(Str::random(20)), 'public');
            $user->resume_doc = $path_r;
            $user->save();
            return redirect()->back()->with('message', 'Resume/CV Document has been updated successfully');
        }
            else{
                 return redirect()->back()->with('error', 'File not found, please update your Resume/CV Document');
            }
        }
       // // Education Upload
        if ($request->has('education_file')) {
            if ($request->file('education_file') != '') {
            $request->validate([
             'education_file' => ['required', 'mimes:doc,docs,pdf', 'max:5000']
            ]);
            $path_e = ($request->file('education_file'))->store('uploads/education/'.md5(Str::random(20)), 'public');
            $user->education_doc = $path_e;
            $user->save();
            return redirect()->back()->with('message', 'Education Document has been updated successfully');
        }
            else{
                 return redirect()->back()->with('error', 'File not found, please update your Education Document');
            }
        }
    }

    public function web_config()
    {
        $user = Auth::user();
        $config = config::all();
        return view('config')->with('title',"System Configuration")->with(compact('user','config'));
    }

    public function config_update(Request $request)
    {
        $token_ignore = ['_token' => ''];
        $post_feilds = array_diff_key($_POST , $token_ignore);
        foreach ($post_feilds as $key => $value) {
            $config = config::where("type" , $key)->first();
            $config->value = $value;
            $config->save();
        }
        return redirect()->back()->with('message', 'Setting has been updated.');
    }

    

    public function inquiry_manage()
    {
        $user = Auth::user();
        if (!$user->role_id == 1) {
            return redirect()->route("welcome");
        }

        
        $inquiry = inquiry::where("is_active" ,1)->where('is_deleted' , 0)->get();
        return view('inquiry-manage')->with('title',"Inquiry Management")->with(compact('user','inquiry'));
    }
    public function subcategory($accessories_id,$category_id){
        // dd($accessories_id,$category_id);
        return view('subcategory')->with(compact('accessories_id','category_id'));
    }
    public function order_details($order_id){
        try {
            $order_id = Crypt::decrypt($order_id);
        } catch (\Throwable $th) {
            return redirect()->back()->with('message', 'Error : ' . $th->getMessage());
        }
        $order_detail= order_detail::where("is_active" ,1)->where("is_deleted" ,0)->where("order_id",$order_id)->get();
        // dd($order_detail);
        return view('order-details')->with(compact('order_detail'));
    }
}
