<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RequestUser;
use App\Models\User;
use App\Models\role_assign;
use App\Models\attributes;
use App\Models\jobs;
use App\Models\company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Auth;
use Session;
use \Crypt;

class CandidateController extends Controller
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

    public function step1_form($id = '')
    {
        $job = null;
        if ($id != "") {
            try {
                $id = Crypt::decrypt($id);
            }
            catch (\Throwable $th) {
                return redirect()->back()->with('message', 'Error : '.$th->getMessage());
            }
            $job = jobs::findOrFail($id);           
        }

        $user = Auth::user();
        $all_job = jobs::where("is_active" , 1)->where("is_deleted" , 0)->where("user_id" ,$user->id)->get();

        return view('web.dashboard.step-1')->with('title',"Get Started")->with(compact('job',"all_job"));
    }


    public function candidate_form()
    {
    
        $departments = attributes::where('attribute' , 'departments')->where('is_active' ,1)->get();
        $designations = attributes::where('attribute' , 'designations')->where('is_active' ,1)->get();
        $projects = attributes::where('attribute' , 'project')->where('is_active' ,1)->get();

        // $departments = DB::table('departments')->select('name')->get();
        // $designations = DB::table('designations')->select('name')->get();
        return view('candidate.candidate_form')->with('title',"Candidate Registration")->with(compact('departments','designations','projects'));
    }

    

    public function create_job($id = "")
    {
        $job = null;

        if ($id != "") {
            try {
                if (strlen($id) > 188) {
                    $id = Crypt::decrypt($id);
                    $id = Crypt::decrypt($id);
                }else{
                    $id = Crypt::decrypt($id);
                }
            }
            catch (\Throwable $th) {
                return redirect()->back()->with('error', 'Error : '.$th->getMessage());
            }
            $job = jobs::findOrFail($id);           
        }
        
        $data = array("hiring_process_role" => array("Human Resources Generalist" , "Owner / CEO" , "Assistant or Office Manager" ,"Recruiter or Talent Acquisition" ,"Hiring Manager" ,"Other") , 
            "hiring_budget" => array("Not Provided" , "I have a budget for my role(s)" , "No planned budget but I can spend if needed" , "I'm not able to spend on hiring"),
            "period" => array("hour" , "day" ,"week" , "month" ,"year"),
            "role_location" => array("One location" => "Job is performed at a specific address" ,"Multiple Locations" => "Job may be performed at multiple sites" ,"Remote" => "Job is performed remotely No one site work is required" , "On the Road" => "Job require regular travels"),
            "employment_type" => array("Full Time" , "Part time" , "Contractor" , "Temporary","Intern","Volunteer","Per diem"),
            "compensation" => array("Bonus" , "Commission" , "Tip"),

        );
        $data2 = array("Academic Adviser","Academic Support Coordinator","Administrator","Admissions Assistant","Admissions Representative","Adjunct Professor","Adviser","After-School Program Aide","After-School Program Coordinator","Assistant Coach","Assistant Dean","Assistant Instructor","Assistant Principal","Assistant Preschool Teacher","Assistant Professor","Assistant Registrar","Assistant Teacher","Associate Dean","Associate Professor","Career Counselor","Child Care Assistant","Child Care Center Teacher","Coach","Crossing Guard","Day Care Assistant","Day Care Center Teacher","Dean","Driver Education Teacher","Education Coordinator","Education Specialist","Education Technician","Educator","Financial Aid Administrator","Food Service Aide","Food Service Coordinator","Food Service Manager","Guidance Counselor","Instructor","Instructional Assistant","Lead Teacher","Lunch Monitor","Preschool Assistant Teacher","Preschool Director","Preschool Group Leader","Preschool Lead Teacher","Preschool Specialist","Preschool Teacher","Principal","Program Assistant","Program Coordinator","Registrar","Residence Hall Manager","Resource Development Coordinator","School Administrator","School Bus Driver","School Counselor","School Librarian","School Nurse","School Psychologist","School Secretary","School Social Worker","Special Education Assistant","Special Education Coordinator","Substitute Teacher","Superintendent","Superintendent of Schools","Teacher","Teacher Aide","Teacher Assistant","Teaching Assistant","Tutor","Youth Care Worker",        );
        return view('web.dashboard.create-job')->with('title',"Create Job")->with(compact('job','data','data2'));
        //return view('web.createjob')->with('title',"Create Job")->with(compact('job','data'));
    }

    public function company_profile($id = "")
    {        
        $job = null;
        if ($id != "") {
            try {
                $id = Crypt::decrypt($id);
            }
            catch (\Throwable $th) {
                return redirect()->back()->with('message', 'Error : '.$th->getMessage());
            }
            $job = jobs::findOrFail($id);           
        }
        return view('web.dashboard.company-profile')->with('title',"Company Profile")->with(compact('job'));
    }

    

    public function job_create_save(Request $request)
    {
        if (isset($_POST['job_id']) && $_POST['job_id'] != "") {
            
            if (strlen($_POST['job_id']) > 188) {
                $id = Crypt::decrypt($_POST['job_id']);
                $id = Crypt::decrypt($id);
            }else{
                $id = Crypt::decrypt($_POST['job_id']);
            }
            
            $token_ignore = ['_token' => '' , 'job_id' => ''];
            $post_feilds = array_diff_key($_POST , $token_ignore);
            $jobs = jobs::where('id', $id)->update($post_feilds);
            
            $job_id = $_POST['job_id'];
            $job_id = $job_id;
            $resp['job_id'] = $job_id;
            $resp['status'] = 1;
            $resp['message'] = "Job details has been updated";

            if ($_POST['step_filled'] == 0) {
                $resp['location'] = route('create_job',$job_id);
            }

            if ($_POST['step_filled'] == 1) {
                $resp['location'] = route('step3_form',$job_id);
            }

            if ($_POST['step_filled'] == 2) {
                $resp['location'] = route('step4_form',$job_id);
            }

            

            // if ($_POST['step_filled'] == 2) {
            //     $resp['location'] = route('create_job',$job_id);
            // }

            if ($_POST['step_filled'] == 3) {
                // $jobs = jobs::find($id);
                // $resp['checker'] = 3;
                // $resp['title'] = $jobs->job_title;
                // $resp['email'] = Auth::user()->email;
                // $resp['company_name'] = $jobs->company_name;
                // $resp['salary'] = "Starting from (".$jobs->currency.")".$jobs->starting_salary." to ".$jobs->currency."(".$jobs->ending_salary.")";
                // $resp['summary'] = $jobs->summary;
                // $resp['skills'] = $jobs->skills;
                // $resp['company_description'] = $jobs->company_description;
                // $resp['employment_type'] = $jobs->employment_type;
                // $resp['compensation'] = $jobs->compensation;
                $resp['location'] = route('step5_form',$job_id);
            }

            if ($_POST['step_filled'] == 4) {
                $resp['location'] = route('job_display');
            }

            return json_encode($resp);
        }else{
            
            $token_ignore = ['_token' => '' , 'job_id' => ''];
            $post_feilds = array_diff_key($_POST , $token_ignore);

            $jobs = jobs::create($post_feilds);
            $job_id = Crypt::encrypt($jobs->id);
            $resp['job_id'] = $job_id;
            $resp['status'] = 1;
            $resp['message'] = "Job details has been saved";
            $resp['location'] = route('create_job',$job_id);
            return json_encode($resp);
        }
    }

    public function step3_form($id = '')
    {
        $job = null;
        if ($id != "") {
            try {
                $id = Crypt::decrypt($id);
            }
            catch (\Throwable $th) {
                return redirect()->back()->with('message', 'Error : '.$th->getMessage());
            }
            $job = jobs::findOrFail($id);           
        }

        $data = array("part_time" => array("Full-time" , "Part-time" ,"Either full-time or part-time"),
            "employment_type" => array("Full Time" , "Part time" , "Contractor" , "Temporary","Internship","Volunteer","Per diem"),
            "job_schedule" => array("8 hour shift" , "10 hour shift" ,"12 hour shift","Weekend availability","Monday to Friday","On call","Holidays","Day shift","Night shift","Overtime","Other"),
            "need_to_hire" => array("1 to 3 days", "3 to 7 days","1 to 2 weeks","2 to 4 weeks","More than 4 weeks"), 
        );

        return view('web.dashboard.step-3')->with('title',"Include Details")->with(compact('job','data'));
    }

    public function step4_form($id = '')
    {
        $job = null;
        if ($id != "") {
            try {
                $id = Crypt::decrypt($id);
            }
            catch (\Throwable $th) {
                return redirect()->back()->with('message', 'Error : '.$th->getMessage());
            }
            $job = jobs::findOrFail($id);           
        }

        $data = array("compensation" => array("Bonus" , "Commission" ,"Signing bonus", "Tip","Other"),
            "benefits" => array("Health insurance" , "Paid time off" , "Dental insurance","401(k)","Vision insurance","Flexible schedule","Tuition reimbursement","Life insurance","401(k) matching","Retirement plan","Referral program","Employee discount","Flexible spending account","Health savings account","Relocation assistance","Parental leave","Professional development assistance","Employee assistance program","Other"),
            "period" => array("hour" , "day" ,"week" , "month" ,"year"),
        );

        return view('web.dashboard.step-4')->with('title',"Compensation Details")->with(compact('job','data'));
    }

    public function step5_form($id = '')
    {
        $job = null;
        if ($id != "") {
            try {
                $id = Crypt::decrypt($id);
            }
            catch (\Throwable $th) {
                return redirect()->back()->with('message', 'Error : '.$th->getMessage());
            }
            $job = jobs::findOrFail($id);           
        }

        $data = array("compensation" => array("Bonus" , "Commission" ,"Signing bonus", "Tip","Other"),
            "benefits" => array("Health insurance" , "Paid time off" , "Dental insurance","401(k)","Vision insurance","Flexible schedule","Tuition reimbursement","Life insurance","401(k) matching","Retirement plan","Referral program","Employee discount","Flexible spending account","Health savings account","Relocation assistance","Parental leave","Professional development assistance","Employee assistance program","Other"),
            "period" => array("hour" , "day" ,"week" , "month" ,"year"),
        );

        // dd(1);
        return view('web.dashboard.step-5')->with('title',"Compensation Details")->with(compact('job','data'));
    }

    public function job_display(Request $request)
    {
        $user = Auth::user();
        if ($user) {
           $jobs=jobs::where("is_active",1)->where("user_id",$user->id)->where("is_deleted",0)->get();
        }
        else{
            return redirect()->back()->with('notify_error','Kindly Login First');
        }        
        return view('web.jobs')->with(compact('jobs'));
    }
    
    public function job_Edit($id='')
    {
        $user = Auth::user();
        if ($user) {

        $job = null;
        if ($id != "") {
            try {
                $id = Crypt::decrypt($id);
            }
            catch (\Throwable $th) {
                return redirect()->back()->with('message', 'Error : '.$th->getMessage());
            }
            $jobs=jobs::where("is_active",1)->where("id",$id)->where("user_id",$user->id)->where("is_deleted",0)->get();           
        }
        }
        else{
            return redirect()->back()->with('notify_error','Kindly Login First');
        }

        

        $data = array("hiring_process_role" => array("Human Resources Generalist" , "Owner / CEO" , "Assistant or Office Manager" ,"Recruiter or Talent Acquisition" ,"Hiring Manager" ,"Other") , 
            "hiring_budget" => array("Not Provided" , "I have a budget for my role(s)" , "No planned budget but I can spend if needed" , "I'm not able to spend on hiring"),
            "period" => array("hour" , "day" ,"week" , "month" ,"year"),
            "role_location" => array("One location" => "Job is performed at a specific address" ,"Multiple Locations" => "Job may be performed at multiple sites" ,"Remote" => "Job is performed remotely No one site work is required" , "On the Road" => "Job require regular travels"),
            "employment_type" => array("Full Time" , "Part time" , "Contractor" , "Temporary","Intern","Volunteer","Per diem"),
            "compensation" => array("Bonus" , "Commission" , "Tip"),);

        $data2= array("part_time" => array("Full-time" , "Part-time" ,"Either full-time or part-time"),
            "employment_type" => array("Full Time" , "Part time" , "Contractor" , "Temporary","Internship","Volunteer","Per diem"),
            "job_schedule" => array("8 hour shift" , "10 hour shift" ,"12 hour shift","Weekend availability","Monday to Friday","On call","Holidays","Day shift","Night shift","Overtime","Other"),
            "need_to_hire" => array("1 to 3 days", "3 to 7 days","1 to 2 weeks","2 to 4 weeks","More than 4 weeks"), 
        );
       $data3= array("compensation" => array("Bonus" , "Commission" ,"Signing bonus", "Tip","Other"),
            "benefits" => array("Health insurance" , "Paid time off" , "Dental insurance","401(k)","Vision insurance","Flexible schedule","Tuition reimbursement","Life insurance","401(k) matching","Retirement plan","Referral program","Employee discount","Flexible spending account","Health savings account","Relocation assistance","Parental leave","Professional development assistance","Employee assistance program","Other"),
            "period" => array("hour" , "day" ,"week" , "month" ,"year"),

        ); 
        return view('web.job-edit')->with('title',"Create Job")->with(compact('job','data','data2','data3'));
    }
    public function company_create_save(Request $request)
    {
        $token_ignore = ['_token' => '' , 'job_id' => '' , 'full_name' => '' , 'hear_about' => ''];
        $post_feilds = array_diff_key($_POST , $token_ignore);
        $company = company::create($post_feilds);
        $job = jobs::where('id', $_POST['job_id'])->update(['hear_about' => $_POST['hear_about'] ,'company_name' => $company->id]);

        return redirect()->route('welcome')->with('message', 'Post submitted');
    }

    public function companylogo_submit(Request $request)
    {
        if (!empty($_FILES)) {
            $file = $request->file('file');
            $file_name = $request->file('file')->getClientOriginalName();
            $file_name = substr($file_name, 0, strpos($file_name, "."));
            $name = $file_name."_".time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path().'/uploads/company_logo/';
            $share = $request->file('file')->move($destinationPath,$name);
            return $name;
        }
    }

}
