<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RequestAttributes;

use Auth;
use App\Models\User;
use App\Models\attenda;
use App\Models\payslip;

use Illuminate\Support\Str;
use Session;
use Helper;
use DB;

class PayrollController extends Controller
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
    public function payroller()
    {
        $user = Auth::user();
        if ($user->role_id != 1) {
            return redirect()->back()->with('error', "No Link found");
        }
        
        return view('payroll/payroller');
    }

    public function payslips()
    {
        $user = Auth::user();
        if ($user->role_id != 1) {
            return redirect()->back()->with('error', "No Link found");
        }
        $empployees = User::where("is_active" , 1)->where("is_deleted" ,0)->where("id" , "!=" , "1")->orderBy('name')->get();
        $payslips = payslip::where("is_active" , 1)->where("is_deleted" ,0)->get();
        return view('payroll/payslips')->with(compact('empployees','payslips'));
    }

    public function payslip_generate(Request $request)
    {
      $user = Auth::user();
      $payslip = new payslip;
      $payslip->emp_id = $request->emp_id;
      $payslip->created_by = $user->emp_id;
      $payslip->salary = $request->salary;
      $payslip->deduction = $request->deduction_amount;
      $payslip->net_pay = $request->net_pay;
      $payslip->reason = $request->reason;
      $payslip->month = $request->month;

      $payslip->medical_allowance = $request->medical_allowance;
      $payslip->fuel_allowance = $request->fuel_allowance;
      $payslip->house_rent = $request->house_rent;
      $payslip->conveyance = $request->conveyance;
      $payslip->late_timing = $request->late_timing;
      $payslip->leaves = $request->leaves;
      $payslip->advance_payment = $request->advance_payment;
      $payslip->income_tax = $request->income_tax;

      $payslip->save();
      //return redirect()->back()->with('message', "Payslip has been generated");
      return redirect()->route('view_payslip',[$payslip->id])->with('message', "Payslip has been generated");
    }

    public function view_payslip($id='')
    {
      $payslip = payslip::find($id);
      if (!$payslip) {
        return redirect()->back()->with('error', "Payslip not found");
      }
      return view('payroll/paysheet')->with(compact('payslip'));
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

    public function payroll_month_report()
    {
        DB::enableQueryLog();
        $month_name = $_POST['month_name'];
        $data = explode('-', $month_name);
        $year = $data[0];
        $month = $data[1];
        $from = intval($month)-1;

        $from = date($year."-".sprintf("%02d", $from).'-26');
        $to = date($year."-".$month.'-25');

        $attendance = attenda::where("is_active" , 1)
        ->whereBetween('day_date' , [$from, $to])
        ->get();

        //dd(DB::getQueryLog());
        $body = "";
        $body = $this->make_group($attendance);

        //dd($body);
        $user = Auth::user();
        
        
        $bod['body'] = $body;
        $response = json_encode($bod);
        return $response;
    }

    function make_group($data) {
        $result = array();
        foreach ($data as $key => $value) {
          $result[$value->emp_id][$key] = $value->id ;
        }
        
        $body = "";
        foreach ($result as $key => $value) {
          $body .= "<tr>";
          $body .= "<td>".$key."</td>";
          $user = User::where("emp_id" , $key)->first();
          $body .= "<td>".$user->name."</td>";
          $WD = $AB = $LI = $EO = $WH = 0;
          foreach ($value as $val) {
            $record = attenda::find($val);
            if ($record->timein_status == "On-Time" && $record->timeout_status == "On-Time" ) {
              $WD++;
              $WH += strtotime($record->working_hour);
            }

            // if ($record->timein_status == "Time-In-Missing" || $record->timeout_status == "Time-Out-Missing" ) {
            //   $WD--;
            //   $AB++;
            // }
          }

          if ($WD < 0) {
            $WD =0;
          }
          $body .= "<td>".$WD."</td>";
          $body .= "<td>".$AB."</td>";
          $body .= "<td>".$LI."</td>";
          $body .= "<td>".$EO."</td>";
          $body .= "<td>".date("H:i" , $WH)."</td>";
          $body .= "<td>".$user->salary."</td>";
          $body .= "</tr>";
        }
        return $body;
    }
}

