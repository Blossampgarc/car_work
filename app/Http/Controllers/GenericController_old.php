<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RequestAttributes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Models\User;
use App\Models\attributes;
use App\Models\role_assign;
use App\Models\accessories;
use App\Models\category;
use App\Models\subcategory;
use App\Models\brand;
use App\Models\contact_details;
use App\Models\company;
use App\Models\note;
use App\Models\car_details;
use App\Models\car_sale;
use App\Models\ads;

use Illuminate\Support\Str;
use Session;
use Helper;
use \Crypt;

class GenericController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $user = Helper::curren_user();

        // $att_tag = attributes::where('is_active' ,1)->select('attribute')->distinct()->get();
        // $role_assign = role_assign::where('is_active' ,1)->where("role_id" ,$user->role_id)->first();
        
        // View()->share('att_tag',$att_tag);
        // View()->share('role_assign',$role_assign);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function roles()
    {
        $user = Auth::user();
        if ($user->role_id != 1) {
            return redirect()->back()->with('error', "No Link found");
        }
        $att_tag = attributes::where('is_active' ,1)->select('attribute')->distinct()->get();
        $attributes = attributes::where('is_active' ,1)->get();
        $role_assign = role_assign::where('is_active' ,1)->where("role_id" ,$user->role_id)->first();
        
        return view('roles/roles')->with(compact('attributes','att_tag','role_assign'));
    }
    
    public function generic_submit(RequestAttributes $request)
    {
        // $user = User::find(Auth::user()->id);
        // $columns  = \Schema::getColumnListing("attributes");
        // $ignore = ['id' , 'is_active' ,'is_deleted' , 'created_at' , 'updated_at' ,'deleted_at'];
        //$push_in = array_diff($columns, $ignore);

        $token_ignore = ['_token' => ''];
        $post_feilds = array_diff_key($_POST , $token_ignore);
        
        try{
            attributes::insert($post_feilds);
            return redirect()->back()->with('message', 'Information updated successfully');
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'Error will saving record');
        }
    }

    public function role_assign_modal()
    {
        $user = Auth::user();
        $role_assign = role_assign::where('is_active' ,1)->where("role_id" ,$_POST['role_id'])->orderBy('id','desc')->first();
        $att_tag = attributes::where('is_active' ,1)->select('attribute')->distinct()->get();
        $body = "";
        if ($att_tag) {
            $route = route('roleassign_submit');
            $body .= "<input type='hidden' name='role_id' id='fetch-role-id' value='".$_POST['role_id']."'>";
            if ($role_assign && $role_assign->assignee!='N;') {
                $checker = unserialize($role_assign->assignee);
                $body .= "<input type='hidden' name='record_id' value='".$role_assign->id."'>";
            }else{
                $checker = [];
            }
            foreach($att_tag as $key => $role){
                $body .= "<tr><td>".ucwords($role->attribute)."</td><td><div class='custom-control custom-checkbox'>
                                  <input type='checkbox' name='assignee[]' class='custom-control-input' id='customCheck1".$key."' ";
                                   if(in_array($role->attribute."_1", $checker)){ $body .= "checked"; }
                                    $body .= " value='".$role->attribute."_1'>
                                  <label class='custom-control-label' for='customCheck1".$key."'>1</label></div></td>
                            
                            <td><div class='custom-control custom-checkbox'>
                                  <input type='checkbox' name='assignee[]' class='custom-control-input' id='customCheck2".$key."' ";
                                   if(in_array($role->attribute."_2", $checker)){ $body .= "checked"; }
                                    $body .= " value='".$role->attribute."_2'>
                                  <label class='custom-control-label' for='customCheck2".$key."'>2</label></div></td>

                            <td><div class='custom-control custom-checkbox'>
                                  <input type='checkbox' name='assignee[]' class='custom-control-input' id='customCheck3".$key."' ";
                                   if(in_array($role->attribute."_3", $checker)){ $body .= "checked"; }
                                    $body .= " value='".$role->attribute."_3'>
                                  <label class='custom-control-label' for='customCheck3".$key."'>3</label></div></td>

                            <td><div class='custom-control custom-checkbox'>
                                  <input type='checkbox' name='assignee[]' class='custom-control-input' id='customCheck4".$key."' ";
                                   if(in_array($role->attribute."_4", $checker)){ $body .= "checked"; }
                                    $body .= " value='".$role->attribute."_4'>
                                  <label class='custom-control-label' for='customCheck4".$key."'>4</label></div></td></tr>";    
            }
        }

        $bod['body'] = $body;
        $response = json_encode($bod);
        return $response;
    }

    public function roleassign_submit(Request $request)
    {
        if (isset($request->record_id) && $request->record_id != 0) {
            $role_assign = role_assign::where('is_active' ,1)->where("id" ,$request->record_id)->first();
        }else{
            $role_assign = new role_assign;
            $role_assign->role_id = $request->role_id;    
        }
        
        $role_assign->assignee = serialize($request->assignee);
        $role_assign->save();
        return redirect()->back()->with('message', 'Role has been assigned successfully');
    }

    public function listing($slug='')
    {
        if ($slug == 'contact') {
            $slug = "contact_details";
        }
        $user = Auth::user();
        $role_assign = role_assign::where('is_active' ,1)->where("role_id" ,$user->role_id)->first();
        if ($role_assign) {
            $validator = Helper::check_rights($slug);
            if (is_null($validator)) {
                return redirect()->back()->with('error', "Don't have sufficient rights to access this page");
            }
        }else{
            return redirect()->back()->with('error', "Don't have sufficient rights to access this page");
        }
        
        $form = null;
        $table = null;
        $eloquent = '';
        if($slug == "roles"){
            $att_tag = attributes::where('is_active' ,1)->select('attribute')->distinct()->get();

            $attributes = attributes::where('is_active' ,1)->where('attribute' , $slug)->get();
            $is_hide = 0;
        }else{
            $att_tag = attributes::where('is_active' ,1)->select('attribute')->distinct()->get();
            $attributes = attributes::where('is_active' ,1)->where('attribute' , $slug)->get();
            $get_eloquent = attributes::where('is_active' ,1)->where('attribute' , $slug)->first();
            $eloquent = ($get_eloquent->model != '')?$get_eloquent->model:'';
            $is_hide = 1;
            if ($eloquent != '') {
                $form = $this->generated_form($slug);
                $table = $this->generated_table($slug);
            }

        }
        return view('roles/crud')->with(compact('attributes','att_tag','role_assign','validator','slug','is_hide','eloquent','form','table'));
    }
    
    private function generated_form($slug = '')
    {
        $body = '';

        if ($slug == 'testimonials') {
            $route_url = route('crud_generator', $slug);
            $body = '<form class="" id="generic-form" method="POST" action="'.$route_url.'">
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <input type="hidden" name="record_id" id="record_id" value="">
                    <div class="row">
                        <div id="assignrole"></div>
                        <div class="col-md-12 col-sm-6 col-12" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Name:</label>
                                <div class="d-flex">
                                    <input id="name" placeholder="Name" name="name" class="form-control" type="text" autocomplete="off" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6 col-12" id="role-label">
                            <div class="form-group end-date">
                                <label for="end-date" class="">Description:</label>
                                <div class="d-flex">
                                    <textarea id="description" required name="desc" class="form-control" ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>';
            return $body;
        } elseif ($slug == 'fileUploader') {
            $route_url = route('file_generator');
            $body = '<form class="" id="generic-form" enctype="multipart/form-data" method="POST" action="'.$route_url.'">
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <input type="hidden" name="record_id" id="record_id" value="">
                    <div class="row">
                        <div id="assignrole"></div>
                        <div class="col-md-6 col-sm-6 col-6 im" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">File:</label>
                                <div class="d-flex">
                                    <input type="file" name="file" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>';
            return $body;
        } elseif ($slug == 'ads') {
            $route_url = route('crud_generator', $slug);
            $body = '<form class="" id="generic-form"  enctype="multipart/form-data" method="POST" action="'.$route_url.'">
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <input type="hidden" name="record_id" id="record_id" value="">
                    <div class="row">
                        <div id="assignrole"></div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Title:</label>
                                <div class="d-flex">
                                    <input id="name" placeholder="Title" name="name" class="form-control" type="text" autocomplete="off" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Image:</label>
                                <div class="d-flex">
                                    <input type="file" id="image" accept="image/*" name="image" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <div class="d-flex">
                                    <td><img id="image-add" style="width:80px;height:80px;display:none;" src=""></td>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6 col-12" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Description:</label>
                                <div class="d-flex">
                                    <input id="desc" placeholder="Description" name="desc" class="form-control" type="text" autocomplete="off" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6 col-12" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">URL:</label>
                                <div class="d-flex">
                                    <input id="url" placeholder="URL" name="url" class="form-control" type="text" autocomplete="off" required/>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </form>';
            return $body;
        } elseif ($slug == 'accessories') {
            $route_url = route('crud_generator', $slug);
            $body = '<form class="" id="generic-form"  enctype="multipart/form-data" method="POST" action="'.$route_url.'">
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <input type="hidden" name="record_id" id="record_id" value="">
                    <div class="row">
                        <div id="assignrole"></div>
                        <div class="col-md-12 col-sm-6 col-12" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Banner Image:</label>
                                <div class="d-flex">
                                    <input type="file" id="banner" accept="image/*" name="banner" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6 col-12" id="rank-label">
                            <div class="form-group start-date">
                                <div class="d-flex">
                                    <td><img id="banner-add" style="width:180px;height:60px;display:none;" src=""></td>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Title:</label>
                                <div class="d-flex">
                                    <input id="name" placeholder="Title" name="name" class="form-control" type="text" autocomplete="off" required="" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Image:</label>
                                <div class="d-flex">
                                    <input type="file" id="image" accept="image/*" name="image" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <div class="d-flex">
                                    <td><img id="image-add" style="width:80px;height:80px;display:none;" src=""></td>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6 col-12" id="role-label">
                            <div class="form-group end-date">
                                <label for="end-date" class="">Description:</label>
                                <div class="d-flex">
                                    <textarea id="desc" name="desc" class="form-control" placeholder="Description" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6 col-12" id="role-label">
                            <div class="form-group end-date">
                                <label for="end-date" class="">Key Words:</label>
                                <div class="d-flex">
                                    <textarea id="keyword" name="keyword" class="form-control" placeholder="Key Words" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>';
            return $body;
        } elseif ($slug == 'category') {
            $route_url = route('crud_generator', $slug);
            $body = '<form class="" id="generic-form" enctype="multipart/form-data" method="POST" action="'.$route_url.'" >
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <input type="hidden" name="record_id" id="record_id" value="">
                    <div class="row">
                        <div id="assignrole"></div>
                        <div class="col-md-12 col-sm-6 col-12" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Accessory:</label>
                                <div class="d-flex">
                                    <select name="accessories_id" id="accessories_id" class="form-control profession" required value="">
                                        <option selected="true" disabled="disabled" >Select Accessory</option>';
                                        $accessories= accessories::where("is_active",1)->where("is_deleted",0)->get();
                                        if ($accessories) {
                                            foreach($accessories as $k => $val){
                                            $body.='<option value="'.$val->id.'">'.$val->name.'</option>';
                                            }
                                        }
                            $body.='</select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6 col-12" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Banner Image:</label>
                                <div class="d-flex">
                                    <input type="file" id="banner" accept="image/*" name="banner" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6 col-12" id="rank-label">
                            <div class="form-group start-date">
                                <div class="d-flex">
                                    <td><img id="banner-add" style="width:180px;height:60px;display:none;" src=""></td>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Title:</label>
                                <div class="d-flex">
                                    <input id="name" placeholder="Title" name="name" class="form-control" type="text" autocomplete="off" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Image:</label>
                                <div class="d-flex">
                                    <input type="file" id="image" accept="image/*" name="image" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <div class="d-flex">
                                    <td><img id="image-add" style="width:80px;height:80px;display:none;" src=""></td>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6 col-12" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Detail:</label>
                                <div class="d-flex">
                                    <input id="detail" placeholder="Detail" name="detail" class="form-control" type="text" autocomplete="off" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6 col-12" id="role-label">
                            <div class="form-group end-date">
                                <label for="end-date" class="">Description:</label>
                                <div class="d-flex">
                                    <textarea id="desc" name="desc" class="form-control" placeholder="Description" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6 col-12" id="role-label">
                            <div class="form-group end-date">
                                <label for="end-date" class="">Key Words:</label>
                                <div class="d-flex">
                                    <textarea id="keyword" name="keyword" class="form-control" placeholder="Key Words" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>';
            return $body;
        } elseif ($slug == 'brand') {
            $route_url = route('crud_generator', $slug);
            $body = '<form class="" id="generic-form" enctype="multipart/form-data" method="POST" action="'.$route_url.'" >
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <input type="hidden" name="record_id" id="record_id" value="">
                    <div class="row">
                        <div id="assignrole"></div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Name:</label>
                                <div class="d-flex">
                                    <input id="name" placeholder="Name" name="name" class="form-control" type="text" autocomplete="off" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Image:</label>
                                <div class="d-flex">
                                    <input type="file" id="image" accept="image/*" name="image" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <div class="d-flex">
                                    <td><img id="image-add" style="width:80px;height:80px;display:none;" src=""></td>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>';
            return $body;
        } elseif ($slug == 'product') {
            $note = note::select('note_no','note')->where('is_active',1)->where('is_deleted',0)->groupBy('note_no','note')->get();
            // dd($note);
            $route_url = route('crud_generator', 'car_details');
            $body = '<form class="" id="generic-form" enctype="multipart/form-data" method="POST" action="'.$route_url.'" >
                    <input type="hidden" name="_token" value="'.csrf_token().'">
                    <input type="hidden" name="record_id" id="record_id" value="">
                    <div class="row">
                        <div id="assignrole"></div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Company:</label>
                                <div class="d-flex">
                                    <select name="company_id" id="company_id" class="form-control profession" required value="">
                                        <option selected="true" disabled="disabled" >Select Company</option>';
                                        $company= company::where("is_active",1)->where("is_deleted",0)->get();
                                        if ($company) {
                                            foreach($company as $k => $val){
                                            $body.='<option value="'.$val->id.'">'.$val->name.'</option>';
                                            }
                                        }
                            $body.='</select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Brand:</label>
                                <div class="d-flex">
                                    <select name="brand_id" id="brand_id" class="form-control profession" required value="">
                                        <option selected="true" disabled="disabled" >Select Brand</option>';
                                        $brand= brand::where("is_active",1)->where("is_deleted",0)->get();
                                        if ($brand) {
                                            foreach($brand as $k => $val){
                                            $body.='<option value="'.$val->id.'">'.$val->name.'</option>';
                                            }
                                        }
                            $body.='</select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Type:</label>
                                <div class="d-flex">
                                    <input id="type" placeholder="Type" name="type" class="form-control" type="text" autocomplete="off" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Model:</label>
                                <div class="d-flex">
                                    <input id="model" placeholder="Model" name="model" class="form-control" type="text" autocomplete="off" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">From Year:</label>
                                <div class="d-flex">
                                    <input id="from_year" placeholder="From Year" name="from_year" class="form-control" type="number" autocomplete="off" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">To Year:</label>
                                <div class="d-flex">
                                    <input id="to_year" placeholder="To Year" name="to_year" class="form-control" type="number" autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Pistons Caliper:</label>
                                <div class="d-flex">
                                    <input id="pistons_caliper" placeholder="Pistons Caliper" name="pistons_caliper" class="form-control" type="number" autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Finish Caliper:</label>
                                <div class="d-flex">
                                    <select class="js-example-basic-multiple js-states form-control" id="finish_caliper" name="finish_caliper[]" multiple="multiple">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Disc Size and Type:</label>
                                <div class="d-flex">
                                    <input id="disc_size_type" placeholder="Disc Size and Type" name="disc_size_type" class="form-control" type="text" autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Drilled Part Number:</label>
                                <div class="d-flex">
                                    <input id="drilled_no" placeholder="Drilled Part Number" name="drilled_no" class="form-control" type="text" autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Type 1 Part Number:</label>
                                <div class="d-flex">
                                    <input id="type1_no" placeholder="Type 1 Part Number" name="type1_no" class="form-control" type="text" autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Type 3 Part Number:</label>
                                <div class="d-flex">
                                    <input id="type3_no" placeholder="Type 3 Part Number" name="type3_no" class="form-control" type="text" autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Type 5 Part Number:</label>
                                <div class="d-flex">
                                    <input id="type5_no" placeholder="Type 5 Part Number" name="type5_no" class="form-control" type="text" autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">GT Price:</label>
                                <div class="d-flex">
                                    <input id="gt_price" placeholder="GT Price" name="gt_price" class="form-control" type="number" autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">GTS Price:</label>
                                <div class="d-flex">
                                    <input id="gts_price" placeholder="GTS Price" name="gts_price" class="form-control" type="number" autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">GTR Price:</label>
                                <div class="d-flex">
                                    <input id="gtr_price" placeholder="GTR Price" name="gtr_price" class="form-control" type="number" autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6 col-12" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Note:</label>
                                <div class="d-flex">
                                    <select class="js-example-basic-multiple js-states form-control" id="note" name="note[]" multiple="multiple">';
                                    foreach ($note as $key => $value) {
                                        $body .= '<option value="'.$value->note_no.'">'.$value->note.'</option>';
                                    }
                                    $body.= '</select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6 col-12" id="rank-label">
                            <div class="form-group start-date">
                                <label for="start-date" class="">Image:</label>
                                <div class="d-flex">
                                    <input type="file" id="image" name="image" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6 col-12" id="rank-label">
                            <div class="form-group start-date">
                                <div class="d-flex">
                                    <td><img id="image-add" style="width:80px;height:80px;display:none;" src=""></td>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </form>';
            return $body;
        } else{
            return $body;
        }
    }

    private function generated_table($slug='')
    {
        

        $body = '';
        if ($slug == "testimonials") {
            $data = 'App\Models\\'.$slug;
            $loop = $data::where("is_active" ,1)->where("is_deleted" ,0)->get();
            if ($loop) {
            $body = '<thead>
                                       <tr>
                                          <th>S. No</th>
                                          <th>Name</th>
                                          <th>Description</th>
                                          <th>Creation Date</th>
                                          <th>Action</th>
                                       </tr>
                                    </thead>
                                    <tbody>';
                                       if($loop) {
                                       foreach($loop as $key => $val){
                                       $body .= '<tr>
                                          <td>'.++$key.'</td> 
                                          <td>'.$val->name.'</td> 
                                          <td>'.$val->desc.'</td>
                                          <td>'.date("M d,Y" ,strtotime($val->created_at)).'</td>
                                          <td>
                                             <button type="button" class="btn btn-primary editor-form" data-edit_id= "'.$val->id.'" data-name= "'.$val->name.'" data-desc= "'.$val->desc.'" >Edit</button>
                                             <button type="button" class="btn btn-danger delete-record" data-model="'.$data.'" data-id= "'.$val->id.'" >Delete</button>
                                          </td>
                                       </tr>';
                                       }
                                   }
                                    $body .= '</tbody>
                                    <tfoot>
                                       <tr>
                                          <th>S. No</th>
                                          <th>Name</th>
                                          <th>Description</th>
                                          <th>Creation Date</th>
                                          <th>Action</th>
                                       </tr>
                                    </tfoot>';
                                }
                                $script = '$("body").on("click" ,".editor-form",function(){
                                                $("#name").val($(this).data("name"))
                                                $("#record_id").val($(this).data("edit_id"))
                                                var texta = $(this).data("desc");
                                                CKEDITOR.instances.description.setData(texta);
                                                $("#addevent").modal("show")
                                            })';
                                $resp['body'] = $body;
                                $resp['script'] = $script;
                                return $resp;
        } elseif ($slug == "ads") {
            $data = 'App\Models\\'.$slug;
            $loop = $data::where("is_deleted" ,0)->get();
            if ($loop) {
            $body = '<thead>
                                       <tr>
                                          <th>S. No</th>
                                          <th>Title</th>
                                          <th>Description</th>
                                          <th>URL</th>
                                          <th>Image</th>
                                          <th>Active</th>
                                          <th>Creation Date</th>
                                          <th>Action</th>
                                       </tr>
                                    </thead>
                                    <tbody>';
                                       if($loop) {
                                       foreach($loop as $key => $val){
                                        $i=asset($val->image);
                                        $checked = " ";
                                        if ($val->is_active == 1) {
                                            $checked = "checked";
                                        }
                                        $body .= '<tr>
                                          <td>'.++$key.'</td> 
                                          <td>'.$val->name.'</td>
                                          <td>'.$val->desc.'</td>
                                          <td>'.$val->url.'</td>
                                          <td><img style="width:80px;height:80px;" src="'.$i.'"></td>
                                          <td>
                                                <label class="switch">
                                                    <input type="checkbox" data-ad_id ="'.$val->id.'" class="active_ads"  '.$checked.'>
                                                    <span class="slider"></span>
                                                </label>
                                          </td>
                                          <td>'.date("M d,Y" ,strtotime($val->created_at)).'</td>
                                          <td>
                                             <button type="button" class="btn btn-primary editor-form" data-edit_id= "'.$val->id.'" data-name= "'.$val->name.'" data-image="'.$i.'" data-url="'.$val->url.'" data-desc="'.$val->desc.'" >Edit</button>
                                             <button type="button" class="btn btn-danger delete-record" data-model="'.$data.'" data-id= "'.$val->id.'" >Delete</button>
                                          </td>
                                       </tr>';
                                       }
                                   }
                                    $body .= '</tbody>
                                    <tfoot>
                                       <tr>
                                          <th>S. No</th>
                                          <th>Title</th>
                                          <th>Description</th>
                                          <th>URL</th>
                                          <th>Image</th>
                                          <th>Active</th>
                                          <th>Creation Date</th>
                                          <th>Action</th>
                                       </tr>
                                    </tfoot>';
                                }
                                $script = '$("body").on("click" ,".editor-form",function(){
                                                $("#name").val($(this).data("name"))
                                                $("#url").val($(this).data("url"))
                                                $("#desc").val($(this).data("desc"))
                                                $("#image").removeAttr("required");
                                                $("#image-add").css("display","");
                                                $("#image-add").attr("src",$(this).data("image"));
                                                $("#record_id").val($(this).data("edit_id"))
                                                $("#addevent").modal("show")
                                            })';
                                $resp['body'] = $body;
                                $resp['script'] = $script;
                                return $resp;
        } elseif ($slug == "accessories") {
            $data = 'App\Models\\'.$slug;
            $loop = $data::where("is_active" ,1)->where("is_deleted" ,0)->get();
            if ($loop) {
            $body = '<thead>
                                       <tr>
                                          <th>S. No</th>
                                          <th>Title</th>
                                          <th>Image</th>
                                          <th>Key Word</th>
                                          <th>Description</th>
                                          <th>Banner</th>
                                          <th>Creation Date</th>
                                          <th>Action</th>
                                       </tr>
                                    </thead>
                                    <tbody>';
                                       if($loop) {
                                       foreach($loop as $key => $val){
                                        $i=asset($val->image);
                                        $bann=asset($val->banner);

                                        $body .= '<tr>
                                          <td>'.++$key.'</td> 
                                          <td>'.$val->name.'</td>
                                          <td><img style="width:80px;height:80px;" src="'.$i.'"></td>
                                          <td>'.$val->keyword.'</td>
                                          <td>'.$val->desc.'</td>
                                          <td><img style="width:180px;height:60px;" src="'.$bann.'"></td>
                                          <td>'.date("M d,Y" ,strtotime($val->created_at)).'</td>
                                          <td>
                                             <button type="button" class="btn btn-primary editor-form" data-edit_id= "'.$val->id.'" data-name= "'.$val->name.'" data-image="'.$i.'" data-keyword="'.$val->keyword.'" data-desc="'.$val->desc.'" data-banner="'.$bann.'" >Edit</button>
                                             <button type="button" class="btn btn-danger delete-record" data-model="'.$data.'" data-id= "'.$val->id.'" >Delete</button>
                                          </td>
                                       </tr>';
                                       }
                                   }
                                    $body .= '</tbody>
                                    <tfoot>
                                       <tr>
                                          <th>S. No</th>
                                          <th>Title</th>
                                          <th>Image</th>
                                          <th>Key Word</th>
                                          <th>Description</th>
                                          <th>Banner</th>
                                          <th>Creation Date</th>
                                          <th>Action</th>
                                       </tr>
                                    </tfoot>';
                                }
                                $script = '$("body").on("click" ,".editor-form",function(){
                                                $("#name").val($(this).data("name"))
                                                $("#keyword").val($(this).data("keyword"))
                                                $("#desc").val($(this).data("desc"))
                                                $("#image").removeAttr("required");
                                                $("#banner").removeAttr("required");
                                                $("#image-add").css("display","");
                                                $("#banner-add").css("display","");
                                                $("#image-add").attr("src",$(this).data("image"));
                                                $("#banner-add").attr("src",$(this).data("banner"));
                                                $("#record_id").val($(this).data("edit_id"))
                                                $("#addevent").modal("show")
                                            })';
                                $resp['body'] = $body;
                                $resp['script'] = $script;
                                return $resp;
        } elseif ($slug == "category") {
            $data = 'App\Models\\'.$slug;
            $loop = $data::where("is_active" ,1)->where("is_deleted" ,0)->get();
            if ($loop) {
            $body = '<thead>
                                       <tr>
                                          <th>S. No</th>
                                          <th>Accessory</th>
                                          <th>Title</th>
                                          <th>Detail</th>
                                          <th>Image</th>
                                          <th>key Word</th>
                                          <th>Description</th>
                                          <th>Banner</th>
                                          <th>Top Category</th>
                                          <th>Creation Date</th>
                                          <th>Action</th>
                                       </tr>
                                    </thead>
                                    <tbody>';
                                       if($loop) {
                                       foreach($loop as $key => $val){
                                        $checked = " ";
                                        if ($val->is_top == 1) {
                                            $checked = "checked";
                                        }
                                        $i=asset($val->image);
                                        $bann=asset($val->banner);
                                        
                                        $subcategory = route('subcategory',[$val->accessories_id,$val->id]);
                                        $accessories= accessories::where('is_active',1)->where('is_deleted',0)->where('id',$val->accessories_id)->first();
                                        if ($accessories) {
                                        
                                       $body .= '<tr>
                                          <td>'.++$key.'</td> 
                                          <td>'.$accessories->name.'</td>
                                          <td>'.$val->name.'</td>
                                          <td>'.$val->detail.'</td>
                                          <td><img style="width:80px;height:80px;" src="'.$i.'"></td>
                                          <td>'.$val->keyword.'</td>
                                          <td>'.$val->desc.'</td>
                                          <td><img style="width:180px;height:60px;" src="'.$bann.'"></td>
                                          <td>
                                                <label class="switch">
                                                    <input type="checkbox" data-cat_id ="'.$val->id.'" class="approval"  '.$checked.'>
                                                    <span class="slider"></span>
                                                </label>
                                          </td>
                                          <td>'.date("M d,Y" ,strtotime($val->created_at)).'</td>
                                          <td>
                                            <a type="button" class="btn btn-secondary" style="color:white;" href="'.$subcategory.'" target="_blank">Sub Category</a>
                                             <button type="button" class="btn btn-primary editor-form" data-edit_id= "'.$val->id.'" data-name= "'.$val->name.'" data-accessories_id="'.$val->accessories_id.'" data-detail ="'.$val->detail.'" data-image="'.$i.'" data-keyword="'.$val->keyword.'" data-desc="'.$val->desc.'" data-banner="'.$bann.'">Edit</button>
                                             <button type="button" class="btn btn-danger delete-record" data-model="'.$data.'" data-id= "'.$val->id.'" >Delete</button>
                                          </td>
                                       </tr>';
                                       }
                                       }
                                   }
                                    $body .= '</tbody>
                                    <tfoot>
                                       <tr>
                                          <th>S. No</th>
                                          <th>Accessory</th>
                                          <th>Title</th>
                                          <th>Detail</th>
                                          <th>Image</th>
                                          <th>key Word</th>
                                          <th>Description</th>
                                          <th>Banner</th>
                                          <th>Creation Date</th>
                                          <th>Action</th>
                                       </tr>
                                    </tfoot>';
                                }
                                
                                $script = '$("body").on("click" ,".editor-form",function(){
                                                $("#name").val($(this).data("name"))
                                                $("#detail").val($(this).data("detail"))
                                                $("#keyword").val($(this).data("keyword"))
                                                $("#desc").val($(this).data("desc"))
                                                $("#image").removeAttr("required");
                                                $("#banner").removeAttr("required");
                                                $("#image-add").css("display","");
                                                $("#banner-add").css("display","");
                                                $("#image-add").attr("src",$(this).data("image"));
                                                $("#banner-add").attr("src",$(this).data("banner"));
                                                $("#accessories_id").val($(this).data("accessories_id"))
                                                $("#record_id").val($(this).data("edit_id"))
                                                $("#addevent").modal("show")
                                            })';
                                $resp['body'] = $body;
                                $resp['script'] = $script;
                                return $resp;
        } elseif ($slug == "brand") {
            $data = 'App\Models\\'.$slug;
            $loop = $data::where("is_active" ,1)->where("is_deleted" ,0)->get();
            if ($loop) {
            $body = '<thead>
                                       <tr>
                                          <th>S. No</th>
                                          <th>Name</th>
                                          <th>Image</th>
                                          <th>Creation Date</th>
                                          <th>Action</th>
                                       </tr>
                                    </thead>
                                    <tbody>';
                                       if($loop) {
                                       foreach($loop as $key => $val){
                                        $i=asset($val->image);
                                        
                                       $body .= '<tr>
                                          <td>'.++$key.'</td> 
                                          <td>'.$val->name.'</td>
                                          <td><img style="width:80px;height:80px;" src="'.$i.'"></td>
                                          <td>'.date("M d,Y" ,strtotime($val->created_at)).'</td>
                                          <td>
                                             <button type="button" class="btn btn-primary editor-form" data-edit_id= "'.$val->id.'" data-name= "'.$val->name.'" data-image="'.$i.'" >Edit</button>
                                             <button type="button" class="btn btn-danger delete-record" data-model="'.$data.'" data-id= "'.$val->id.'" >Delete</button>
                                          </td>
                                       </tr>';
                                       }
                                   }
                                    $body .= '</tbody>
                                    <tfoot>
                                       <tr>
                                          <th>S. No</th>
                                          <th>Name</th>
                                          <th>Image</th>
                                          <th>Creation Date</th>
                                          <th>Action</th>
                                       </tr>
                                    </tfoot>';
                                }
                                $script = '$("body").on("click" ,".editor-form",function(){
                                                $("#name").val($(this).data("name"))
                                                $("#image").removeAttr("required");
                                                $("#image-add").css("display","");
                                                $("#image-add").attr("src",$(this).data("image"));
                                                $("#record_id").val($(this).data("edit_id"))
                                                $("#addevent").modal("show")
                                            })';
                                $resp['body'] = $body;
                                $resp['script'] = $script;
                                return $resp;
        } elseif ($slug == "contact_details") {
            $data = 'App\Models\\'.$slug;
            $loop = $data::get();
            if ($loop) {
            $body = '<thead>
                                       <tr>
                                          <th>S. No</th>
                                          <th>First Name</th>
                                          <th>Last Name</th>
                                          <th>Email</th>
                                          <th>Comment</th>
                                          <th>Creation Date</th>
                                       </tr>
                                    </thead>
                                    <tbody>';
                                       if($loop) {
                                       foreach($loop as $key => $val){
                                        
                                       $body .= '<tr>
                                          <td>'.++$key.'</td> 
                                          <td>'.$val->first_name.'</td>
                                          <td>'.$val->last_name.'</td>
                                          <td>'.$val->email.'</td>
                                          <td>'.$val->comment.'</td>
                                          <td>'.date("M d,Y" ,strtotime($val->created_at)).'</td>
                                          
                                       </tr>';
                                       }
                                   }
                                    $body .= '</tbody>
                                    <tfoot>
                                       <tr>
                                          <th>S. No</th>
                                          <th>First Name</th>
                                          <th>Last Name</th>
                                          <th>Email</th>
                                          <th>Comment</th>
                                          <th>Creation Date</th>
                                       </tr>
                                    </tfoot>';
                                }
                                $script = '';
                                $resp['body'] = $body;
                                $resp['script'] = $script;
                                return $resp;
        } elseif ($slug == "orders") {
            $data = 'App\Models\\'.$slug;
            $person = Auth::user();
            if ($person->role_id == 1) {
                $loop = $data::get();
            } else{
                $loop = $data::where('user_id',$person->id)->get();
            }
            if ($loop) {
            $body = '<thead>
                                       <tr>
                                          <th>S. No</th>
                                          <th>Name</th>
                                          <th>Email</th>
                                          <th>Company Name</th>
                                          <th>Address</th>
                                          <th>City</th>
                                          <th>Country</th>
                                          <th>Phone</th>
                                          <th>Post Code</th>
                                          <th>Note</th>
                                          <th>Total Amount</th>
                                          <th>Creation Date</th>
                                          <th>Action</th>
                                       </tr>
                                    </thead>
                                    <tbody>';
                                       if($loop) {
                                       foreach($loop as $key => $val){
                                        $order_details = route('order_details', Crypt::encrypt($val->id));
                                        $user = User::where('is_active',1)->where('is_deleted',0)->where('id',$val->user_id)->first();
                                       $body .= '<tr>
                                          <td>'.++$key.'</td> 
                                          <td>'.$user->name.'</td>
                                          <td>'.$user->email.'</td>
                                          <td>'.$val->company_name.'</td>
                                          <td>'.$val->address.'</td>
                                          <td>'.$val->city.'</td>
                                          <td>'.$val->country.'</td>
                                          <td>'.$val->phone.'</td>
                                          <td>'.$val->postcode.'</td>
                                          <td>'.$val->note.'</td>
                                          <td>$'.$val->amount_total.'</td>
                                          <td>'.date("M d,Y" ,strtotime($val->created_at)).'</td>
                                          <td>
                                             <a class="btn btn-warning" style="font-weight:bold;" href="'.$order_details.'" target="_blank">View Order Detail</a>
                                          </td>
                                       </tr>';
                                       }
                                   }
                                    $body .= '</tbody>
                                    <tfoot>
                                       <tr>
                                          <th>S. No</th>
                                          <th>Name</th>
                                          <th>Email</th>
                                          <th>Company Name</th>
                                          <th>Address</th>
                                          <th>City</th>
                                          <th>Country</th>
                                          <th>Phone</th>
                                          <th>Post Code</th>
                                          <th>Note</th>
                                          <th>Total Amount</th>
                                          <th>Creation Date</th>
                                          <th>Action</th>
                                       </tr>
                                    </tfoot>';
                                }
                                $script = '';
                                $resp['body'] = $body;
                                $resp['script'] = $script;
                                return $resp;
        } elseif ($slug == "product") {
            $data = 'App\Models\car_details';
            $loop = $data::where("is_active" ,1)->where("is_deleted" ,0)->get();
            if ($loop) {
            $body = '<thead>
                                       <tr>
                                          <th>S. No</th>
                                          <th>Company</th>
                                          <th>Brand</th>
                                          <th>Type</th>
                                          <th>Model</th>
                                          <th>Image</th>
                                          <th>Featured Product</th>
                                          <th>Best Seller</th>
                                          <th>On Sale</th>
                                          <th>Creation Date</th>
                                          <th>Action</th>
                                       </tr>
                                    </thead>
                                    <tbody>';
                                        if($loop) {
                                        foreach($loop as $key => $val){
                                        $featured = " ";
                                        if ($val->is_featured == 1) {
                                            $featured = "checked";
                                        }
                                        $best_seller = " ";
                                        if ($val->best_seller == 1) {
                                            $best_seller = "checked";
                                        }
                                        $sale = " ";
                                        if ($val->is_sale == 1) {
                                            $sale = "checked";
                                        }

                                        $data_image = '';
                                        $table_image = '<td>-</td>';
                                        if (isset($val->image) && $val->image != '' && $val->image !== null) {
                                            $data_image=asset($val->image);
                                            
                                            $table_image = '<td><img style="width:80px;height:80px;" src="'.$data_image.'"></td>';

                                        }
                                        $company = company::where('is_active',1)->where('is_deleted',0)->where('id',$val->company_id)->first();
                                        $brand = brand::where('is_active',1)->where('is_deleted',0)->where('id',$val->brand_id)->first();
                                        $finishScript = '';
                                        if (isset($val->finish_caliper) && $val->finish_caliper != '' && $val->finish_caliper !== null) {
                                            $check = @unserialize($val->finish_caliper);
                                            if ($check !== false) {
                                                $finish_caliper = unserialize($val->finish_caliper);
                                                $finish_data = '<td> <ul>';
                                                foreach ($finish_caliper as $i => $value) {
                                                    $finish_data .= '<li>'.$value.'</li>';
                                                    $finishScript .= $value.',';
                                                }
                                                $finish_data .= '</ul> </td>';
                                            } else{
                                                $finish_data = '<td> <ul> <li> '.$val->finish_caliper.'</li> </ul> </td>';
                                                $finishScript .= $val->finish_caliper.',';
                                            }
                                        } else{
                                            $finish_data ='<td>-</td>';
                                        }
                                        // dd($finishScript);
                                        $noteScript = '';
                                        if (isset($val->note) && $val->note != '' && $val->note !== null) {
                                            $check_note = @unserialize($val->note);
                                            if ($check_note !== false) {
                                                $noteArray = unserialize($val->note);
                                                $note_data = '<td> <ul>';
                                                foreach ($noteArray as $j => $v) {
                                                    $note = note::where('is_active',1)->where('is_deleted',0)->where('note_no',$v)->orderBy('id', 'desc')->first();
                                                    $note_data .= '<li>'.$note->note.'</li> ';
                                                    $noteScript .= $v.',';
                                                }
                                                $note_data .= '</ul> </td>';
                                            } else{
                                                $note = note::where('is_active',1)->where('is_deleted',0)->where('note_no',$val->note)->orderBy('id', 'desc')->first();
                                                $note_data = '<td> <ul> <li> '.$note->note.'</li> </ul> </td>';
                                                $noteScript .= $val->note.',';
                                            }
                                        } else{
                                            $note_data ='<td>-</td>';
                                        }
                                        $body .= '<tr>
                                          <td>'.++$key.'</td> 
                                          <td>'.$company->name.'</td>
                                          <td>'.$brand->name.'</td>
                                          <td>'.$val->type.'</td>
                                          <td>'.$val->model.'</td>
                                          '.$table_image.'
                                          <td>
                                                <label class="switch">
                                                    <input type="checkbox" data-pro_id ="'.$val->id.'" class="featured"  '.$featured.'>
                                                    <span class="slider"></span>
                                                </label>
                                          </td>
                                          <td>
                                                <label class="switch">
                                                    <input type="checkbox" data-pro_id ="'.$val->id.'" class="best_seller"  '.$best_seller.'>
                                                    <span class="slider"></span>
                                                </label>
                                          </td>
                                          <td>
                                                <label class="switch">
                                                    <input type="checkbox" data-pro_id ="'.$val->id.'" class="sale"  '.$sale.'>
                                                    <span class="slider"></span>
                                                </label>
                                                ';
                                                if ($sale == "checked") {
                                                    $car_sale = car_sale::where('product_id',$val->id)->first();
                                                    $body .= '<p>Start Date: '.$car_sale->start_date.'</p>
                                                            <p>End Date: '.$car_sale->end_date.'</p>
                                                            <p>Discount: '.$car_sale->dis_percentage.'%</p>
                                                        
                                                    ';
                                                }
                                            $body .= '
                                          </td>
                                          
                                          <td>'.date("M d,Y" ,strtotime($val->created_at)).'</td>
                                          <td>
                                            <button type="button" class="btn btn-secondary show-form" data-edit_id= "'.$val->id.'"
                                                 data-company_id= "'.$val->company_id.'" 
                                                 data-brand_id= "'.$val->brand_id.'" 
                                                 data-type= "'.$val->type.'"
                                                 data-model= "'.$val->model.'"
                                                 data-from_year= "'.$val->from_year.'"
                                                 data-to_year= "'.$val->to_year.'"
                                                 data-pistons_caliper= "'.$val->pistons_caliper.'"
                                                 data-disc_size_type= "'.$val->disc_size_type.'"
                                                 data-drilled_no= "'.$val->drilled_no.'"
                                                 data-type1_no= "'.$val->type1_no.'"
                                                 data-type3_no= "'.$val->type3_no.'"
                                                 data-type5_no= "'.$val->type5_no.'"
                                                 data-gt_price= "'.$val->gt_price.'"
                                                 data-gts_price= "'.$val->gts_price.'"
                                                 data-gtr_price= "'.$val->gtr_price.'" 
                                                 data-finish_caliper= "'.$finishScript.'" 
                                                 data-note= "'.$noteScript.'"
                                                 data-image= "'.$data_image.'" >Show</button>
                                             <button type="button" class="btn btn-primary editor-form" data-edit_id= "'.$val->id.'"
                                                 data-company_id= "'.$val->company_id.'" 
                                                 data-brand_id= "'.$val->brand_id.'" 
                                                 data-type= "'.$val->type.'"
                                                 data-model= "'.$val->model.'"
                                                 data-from_year= "'.$val->from_year.'"
                                                 data-to_year= "'.$val->to_year.'"
                                                 data-pistons_caliper= "'.$val->pistons_caliper.'"
                                                 data-disc_size_type= "'.$val->disc_size_type.'"
                                                 data-drilled_no= "'.$val->drilled_no.'"
                                                 data-type1_no= "'.$val->type1_no.'"
                                                 data-type3_no= "'.$val->type3_no.'"
                                                 data-type5_no= "'.$val->type5_no.'"
                                                 data-gt_price= "'.$val->gt_price.'"
                                                 data-gts_price= "'.$val->gts_price.'"
                                                 data-gtr_price= "'.$val->gtr_price.'" 
                                                 data-finish_caliper= "'.$finishScript.'" 
                                                 data-note= "'.$noteScript.'"
                                                 data-image= "'.$data_image.'" >Edit</button>
                                             <button type="button" class="btn btn-danger delete-record" data-model="'.$data.'" data-id= "'.$val->id.'" >Delete</button>
                                          </td>
                                       </tr>';
                                       }
                                   }
                                    $body .= '</tbody>
                                    <tfoot>
                                       <tr>
                                          <th>S. No</th>
                                          <th>Company</th>
                                          <th>Brand</th>
                                          <th>Type</th>
                                          <th>Model</th>
                                          <th>Image</th>
                                          <th>Featured Product</th>
                                          <th>Best Seller</th>
                                          <th>On Sale</th>
                                          <th>Creation Date</th>
                                          <th>Action</th>
                                       </tr>
                                    </tfoot>';
                                }
                                $script = '$("body").on("click" ,".editor-form",function(){
                                                $("#generic-form").find("select,textarea,input").each(function(i,e){
                                                    $(e).attr("disabled",false);
                                                })
                                                $("#image").css("display","")
                                                $("#image").removeAttr("required");
                                                $("#image-add").css("display","none")
                                                $("#image-add").attr("src","")
                                                var image_data = $(this).data("image")
                                                if(image_data != ""){
                                                    $("#image-add").css("display","")
                                                    $("#image-add").attr("src",image_data)
                                                }
                                                $("#company_id").val($(this).data("company_id"))
                                                $("#brand_id").val($(this).data("brand_id"))
                                                $("#type").val($(this).data("type"))
                                                $("#model").val($(this).data("model"))
                                                $("#from_year").val($(this).data("from_year"))
                                                $("#to_year").val($(this).data("to_year"))
                                                $("#pistons_caliper").val($(this).data("pistons_caliper"))
                                                $("#disc_size_type").val($(this).data("disc_size_type"))
                                                $("#drilled_no").val($(this).data("drilled_no"))
                                                $("#type1_no").val($(this).data("type1_no"))
                                                $("#type3_no").val($(this).data("type3_no"))
                                                $("#type5_no").val($(this).data("type5_no"))
                                                $("#gt_price").val($(this).data("gt_price"))
                                                $("#gts_price").val($(this).data("gts_price"))
                                                $("#gtr_price").val($(this).data("gtr_price"))
                                                $("#record_id").val($(this).data("edit_id"))
                                                var selectedFinish = $(this).data("finish_caliper")
                                                var finishArray = selectedFinish.split(",")
                                                finishArray.splice(-1);
                                                $("#finish_caliper").select2({
                                                    data: finishArray,
                                                    tags: true,
                                                    });
                                                $("#finish_caliper").val(finishArray).trigger("change");
                                                var selectedNote = $(this).data("note")
                                                var noteArray = selectedNote.split(",")
                                                noteArray.splice(-1);
                                                $("#note").select2({
                                                    tags: true,
                                                    });
                                                $("#note").val(noteArray).trigger("change");
                                                $("#addevent").modal("show")
                                            });
                                            ';
                                $script .= '$("body").on("click" ,".show-form",function(){
                                                $("#generic-form").find("select,textarea,input").each(function(i,e){
                                                    $(e).attr("disabled",true);
                                                })
                                                $("#image-add").css("display","none")
                                                $("#image").css("display","none")
                                                $("#image-add").attr("src","")
                                                var image_data = $(this).data("image")
                                                if(image_data != ""){
                                                    $("#image-add").css("display","")
                                                    $("#image-add").attr("src",image_data)
                                                }
                                                $("#company_id").val($(this).data("company_id"))
                                                $("#brand_id").val($(this).data("brand_id"))
                                                $("#type").val($(this).data("type"))
                                                $("#model").val($(this).data("model"))
                                                $("#from_year").val($(this).data("from_year"))
                                                $("#to_year").val($(this).data("to_year"))
                                                $("#pistons_caliper").val($(this).data("pistons_caliper"))
                                                $("#disc_size_type").val($(this).data("disc_size_type"))
                                                $("#drilled_no").val($(this).data("drilled_no"))
                                                $("#type1_no").val($(this).data("type1_no"))
                                                $("#type3_no").val($(this).data("type3_no"))
                                                $("#type5_no").val($(this).data("type5_no"))
                                                $("#gt_price").val($(this).data("gt_price"))
                                                $("#gts_price").val($(this).data("gts_price"))
                                                $("#gtr_price").val($(this).data("gtr_price"))
                                                $("#record_id").val($(this).data("edit_id"))
                                                var selectedFinish = $(this).data("finish_caliper")
                                                var finishArray = selectedFinish.split(",")
                                                finishArray.splice(-1);
                                                $("#finish_caliper").select2({
                                                    data: finishArray,
                                                    tags: true,
                                                    });
                                                $("#finish_caliper").val(finishArray).trigger("change");
                                                var selectedNote = $(this).data("note")
                                                var noteArray = selectedNote.split(",")
                                                noteArray.splice(-1);
                                                $("#note").select2({
                                                    tags: true,
                                                    });
                                                $("#note").val(noteArray).trigger("change");
                                                $("#addevent").modal("show")
                                            });';
                                $resp['body'] = $body;
                                $resp['script'] = $script;
                                return $resp;
        } else{
            return $body;
        }
    }

    public function report_user($slug)
    {
        $user = Auth::user();
        
        $role_assign = role_assign::where('is_active' ,1)->where("role_id" ,$user->role_id)->first();
        if ($role_assign) {
            $validator = Helper::check_rights($slug);
            if (is_null($validator)) {
                return redirect()->back()->with('error', "Don't have sufficient rights to access this page");
            }
        }else{
            return redirect()->back()->with('error', "Don't have sufficient rights to access this page");
        }
        
        $att_tag = attributes::where('is_active' ,1)->select('attribute')->distinct()->get();
        $attributes = attributes::where('is_active' ,1)->where('attribute' , $slug)->get();
        return view('reports/report_generic_user')->with(compact('attributes','att_tag','role_assign','validator','slug'));
    }

    public function custom_report()
    {
        $status['status'] = 0;
        if (isset($_POST['role_id'])) {
            $attributes = attributes::find($_POST['role_id']);
            if ($attributes->attribute == "departments") {
                $status['status'] = 1;
                $status['redirect'] = route('custom_report_user' ,[$attributes->attribute , str::slug($attributes->name)]);

                return json_encode($status);
            }elseif ($attributes->attribute == "designations") {
                $status['status'] = 1;
                $status['redirect'] = route('custom_report_user' ,[$attributes->attribute , str::slug($attributes->name)]);
                return json_encode($status);
            }elseif ($attributes->attribute == "roles") {
                $status['status'] = 1;
                $status['redirect'] = route('custom_report_user' ,[$attributes->attribute , str::slug($attributes->role)]);
                return json_encode($status);
            }else{
                $status['status'] = 0;
                return json_encode($status);
            }
        }else{
            $status['status'] = 0;
            return json_encode($status);
        }
    }

    public function custom_report_user($slug='',$slug2='')
    {
        $attributes = attributes::where("attribute" , $slug)->first();
        $designation = attributes::where("is_active" , 1)->get();
        $project_id = Session::get("project_id");
        if ($attributes) {

            if ($attributes->attribute == "departments") {
                $all_user = User::where("is_active" , 1)->where("department" , $attributes->id)->get();
                return view('reports/custom-user-report')->with(compact('attributes','all_user','slug','designation'));
            }elseif ($attributes->attribute == "designations") {
                $slug2 = ucwords(str_replace('-', ' ', $slug2));
                $attributes = attributes::where("attribute" , $slug)->where("name" , "LIKE" , $slug2)->first();
                $all_user = User::where("is_active" , 1)->where("designation" , $attributes->id)->get();
                return view('reports/custom-user-report')->with(compact('attributes','all_user','slug','designation'));
            }elseif ($attributes->attribute == "roles") {
                $slug2 = ucwords(str_replace('-', ' ', $slug2)); 
                $attributes = attributes::where("attribute" , $slug)->where("role" , "LIKE" , $slug2)->first();
                if (!$attributes) {
                    return redirect()->back()->with('error', "Didn't find any records.!");
                }
                $all_user = User::where("is_active" , 1)->where("role_id" , $attributes->id)->get();
                return view('reports/custom-user-report')->with(compact('attributes','all_user','slug','designation'));
            }else{
                return redirect()->back()->with('error', "Didn't find any records.!");
            }
        }else{
            return redirect()->back()->with('error', "Didn't find any records..");
        }
    }
    public function sale_generator(Request $request){
        $token_ignore = ['_token' => '' ];
        $post_feilds = array_diff_key($_POST , $token_ignore);
        $data = 'App\Models\car_sale';
        $car_feilds['is_sale'] = 1;
        // dd($post_feilds);
        try {
            if ($_POST['start_date']<$_POST['end_date']) {
                $check = $data::where('is_active',1)->where('is_deleted',0)->where('product_id',$_POST['product_id'])->first();

                if ($check) {
                    $create = $data::where("id" ,$check->id)->update($post_feilds);
                    $product_sale = car_details::where("id" ,$_POST['product_id'])->update($car_feilds);
                    $msg = "Record has been updated";
                } else{
                    $create = $data::create($post_feilds);
                    $product_sale = car_details::where("id" ,$_POST['product_id'])->update($car_feilds);
                    $msg = "Record has been created";
                }
            } else{
                $msg = "Start Date must be greater than End Date";
                return redirect()->back()->with('error', $msg);
            }
          return redirect()->back()->with('message', $msg);
        } catch(Exception $e) {
          $error = $e->getMessage();
          return redirect()->back()->with('error', "Error Code: ".$error);
        }
    }
    public function crud_generator($slug='' , Request $request)
    {
        $token_ignore = ['_token' => '' , 'record_id' => '' , 'image' => '', 'finish_caliper' => '' , 'note' => ''];
        $post_feilds = array_diff_key($_POST , $token_ignore);
        // dd($post_feilds);
        $data = 'App\Models\\'.$slug;
        if (isset($_POST['name']) && $_POST['name'] != '') {
            $s = $_POST['name'];
            $s = str_replace(' ', '', $s);
            $s = strtolower($s);
            $post_feilds['slug'] = $s;
        }
        if ($slug == 'car_details') {
            $new_str = str_replace(str_split('\\/:*?"<>|,.()-_'), '', $_POST['model']);
            $str = str_replace(" ","",$new_str);
            $strlower = strtolower($str);
            $drill = str_replace(str_split('\\/:*?"<>|,.()-_'), '', $_POST['drilled_no']);
            $drillstr = str_replace(" ","",$drill);
            $drilllower = strtolower($drillstr);
            $slug = $strlower."-".$drilllower;
            $post_feilds['slug'] = $slug;
            
            if (isset($_POST['finish_caliper']) && $_POST['finish_caliper'] != '') {
                $post_feilds['finish_caliper'] = serialize($_POST['finish_caliper']);
            } else{
                $post_feilds['finish_caliper'] = null;
            }
            if (isset($_POST['note']) && $_POST['note'] != '') {
                $post_feilds['note'] = serialize($_POST['note']);
            } else{
                $post_feilds['note'] = null;
            }
            foreach ($post_feilds as $key => $value) {
                if (!(isset($post_feilds[$key]) && $post_feilds[$key] != '')) {
                    $post_feilds[$key] = null;
                }
            }
            // dd($post_feilds,$_POST);
        }
        $extension=array("jpeg","jpg","png");
        if (isset($request->image)) {
            $file = $request->image;
            $ext = $request->image->getClientOriginalExtension();
            if(in_array($ext,$extension)) {
                $file_name = $request->image->getClientOriginalName();
                $file_name = substr($file_name, 0, strpos($file_name, "."));
                $name = "uploads/product/" .$file_name."_".time().'.'.$file->getClientOriginalExtension();
                $destinationPath = public_path().'/uploads/product/';
                $share = $request->image->move($destinationPath,$name);
                $post_feilds['image'] = $name;
            } else{
                $msg = "This File type is not Supported!";
                return redirect()->back()->with('error', "Error Code: ".$msg);
            }
        }
        if (isset($request->banner)) {
            $file = $request->banner;
            $ext = $request->banner->getClientOriginalExtension();
            if(in_array($ext,$extension)) {
                $file_name = $request->banner->getClientOriginalName();
                $file_name = substr($file_name, 0, strpos($file_name, "."));
                $name = "uploads/product/banner/" .$file_name."_".time().'.'.$file->getClientOriginalExtension();
                $destinationPath = public_path().'/uploads/product/banner/';
                $share = $request->banner->move($destinationPath,$name);
                $post_feilds['banner'] = $name;
            } else{
                $msg = "This File type is not Supported!";
                return redirect()->back()->with('error', "Error Code: ".$msg);
            }
        }
        try {
            if (isset($_POST['record_id']) && $_POST['record_id'] != '') {
                $create = $data::where("id" , $_POST['record_id'])->update($post_feilds);
                $msg = "Record has been updated";
            } else{
                if ($slug == 'car_details') {
                    $check_record = car_details::where('is_active',1)->where('slug',$slug)->first();
                    if ($check_record) {
                        $msg = "This Product already exists";
                        return redirect()->back()->with('error',$msg);
                    }
                }
                $create = $data::create($post_feilds);
                $msg = "Record has been created";
            }
          return redirect()->back()->with('message', $msg);
        } catch(Exception $e) {
          $error = $e->getMessage();
          return redirect()->back()->with('error', "Error Code: ".$error);
        }
    }
    public function delete_record(Request $request)
    {
        $token_ignore = ['_token' => '' , 'id' => '' , 'model' => ''];
        $post_feilds = array_diff_key($_POST , $token_ignore);
        $data = $_POST['model'];
        try{
            $update = $data::where("id" , $_POST['id'])->update($post_feilds);
            $status['message'] = "Record has been deleted";
            $status['status'] = 1;
            return json_encode($status);
        }catch(Exception $e) {
            $error = $e->getMessage();
            $status['message'] = $error;
            $status['status'] = 0;
            return json_encode($status);
        }
    }
    public function switch_top_category(Request $request){
        try{
            $cat_id = $_POST['cat_id'];
            $category = category::where("is_active" ,1)->where("is_deleted" ,0)->where("id",$cat_id)->first();
            if ($category->is_top == 0) {
                $post_feilds['is_top'] = 1;
                $status['message'] = "Category has been marked as Top Category";
            } else{
                $post_feilds['is_top'] = 0;
                $status['message'] = "Category has been removed from Top Categories";
            }
            $update = category::where("id" , $cat_id)->update($post_feilds);
            $status['status'] = 1;
            return json_encode($status);
        }catch(Exception $e) {
            $error = $e->getMessage();
            $status['message'] = $error;
            $status['status'] = 0;
            return json_encode($status);
        }
        
    }
    public function active_ads(Request $request){
        try{
            $ad_id = $_POST['ad_id'];
            $ad = ads::where("is_deleted" ,0)->where("id",$ad_id)->first();
            if ($ad->is_active == 0) {
                $post_feilds['is_active'] = 1;
                $status['message'] = "Ad has been Activated";
            } else{
                $post_feilds['is_active'] = 0;
                $status['message'] = "Ad has been Deactivated";
            }
            $update = ads::where("id" , $ad_id)->update($post_feilds);
            $status['status'] = 1;
            return json_encode($status);
        }catch(Exception $e) {
            $error = $e->getMessage();
            $status['message'] = $error;
            $status['status'] = 0;
            return json_encode($status);
        }
        
    }
    public function featured_product(Request $request){
        try{
            $product_id = $_POST['product_id'];
            $product = car_details::where("is_active" ,1)->where("is_deleted" ,0)->where("id",$product_id)->first();
            if ($product->is_featured == 0) {
                $post_feilds['is_featured'] = 1;
                $status['message'] = "Product has been marked as Featured Product";
            } else{
                $post_feilds['is_featured'] = 0;
                $status['message'] = "Product has been removed from Featured Product";
            }
            $update = car_details::where("id" , $product_id)->update($post_feilds);
            $status['status'] = 1;
            return json_encode($status);
        }catch(Exception $e) {
            $error = $e->getMessage();
            $status['message'] = $error;
            $status['status'] = 0;
            return json_encode($status);
        }
        
    }
    public function best_seller(Request $request){
        try{
            $product_id = $_POST['product_id'];
            $product = car_details::where("is_active" ,1)->where("is_deleted" ,0)->where("id",$product_id)->first();
            if ($product->best_seller == 0) {
                $post_feilds['best_seller'] = 1;
                $status['message'] = "Product has been marked as Best Seller";
            } else{
                $post_feilds['best_seller'] = 0;
                $status['message'] = "Product has been removed from Best Seller";
            }
            $update = car_details::where("id" , $product_id)->update($post_feilds);
            $status['status'] = 1;
            return json_encode($status);
        }catch(Exception $e) {
            $error = $e->getMessage();
            $status['message'] = $error;
            $status['status'] = 0;
            return json_encode($status);
        }
        
    }

    public function remove_sale(Request $request){
        try{
            $product_id = $_POST['product_id'];
            $car_feilds['is_sale'] = 0;
            $status['message'] = "Product Sale has been removed";
            $update = car_details::where("id" , $product_id)->update($car_feilds);
            $status['status'] = 1;
            return json_encode($status);
        }catch(Exception $e) {
            $error = $e->getMessage();
            $status['message'] = $error;
            $status['status'] = 0;
            return json_encode($status);
        }
        
    }

    public function sale_detail(Request $request){
        try{
            $product_id = $_POST['product_id'];
            $product = car_sale::where("product_id" , $product_id)->first();
            dd($product->start_date);
            if ($product) {
                $status['status'] = 1;
                $status['dis_percentage'] = $product->dis_percentage;
                $status['start_date'] = date("d-M-Y H:i:s" ,strtotime($product->start_date));
                $status['end_date'] = date("d-M-Y H:i:s" ,strtotime($product->end_date));
            } else{
                $status['status'] = 0;
            }
            return json_encode($status);
        }catch(Exception $e) {
            $error = $e->getMessage();
            $status['message'] = $error;
            $status['status'] = 0;
            return json_encode($status);
        }
        
    }
    
}