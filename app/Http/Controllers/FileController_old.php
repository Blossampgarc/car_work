<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\UsersExport;
use App\Imports\UsersImport;

use App\Exports\SalesOrderExport;
use App\Imports\SalesOrder;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\Validator;

use App\Models\company;
use App\Models\car_details;
use App\Models\note;

// use Excel;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function file_generator(Request $request){
        // dd($request->file);
        try{
            $this->validate($request,[
                'file' =>'required|mimes:xls,xlsx'
            ]);
            if ($request->file) {
                $file = $request->file;
                $file_name = $request->file->getClientOriginalName();
                $file_name = substr($file_name, 0, strpos($file_name, "."));
                $name = "uploads/file/" .$file_name."_".time().'.'.$file->getClientOriginalExtension();
                $destinationPath = public_path().'/uploads/file/';
                $share = $request->file->move($destinationPath,$name);
                $path = public_path($name);
                $rows = \Excel::toArray(new SalesOrderExport, $path);
                $check = $this->upload_sheet($rows);
                if ($check) {
                    $msg = "File has been uploaded";
                    return redirect()->back()->with('message', $msg);
                } else{
                    
                }
            }
            $msg = "File could not be uploaded";
            return redirect()->back()->with('error', $msg);
        } catch(Exception $e) {
          $error = $e->getMessage();
          return redirect()->back()->with('error', "Error Code: ".$error);
        }
    }
    public function upload_sheet($collection){
        // dd($collection);
        $car_feilds= array();
        $note_feilds= array();
        $comma = ",";
        $note = false;
        $car_feilds['company_id'] = 0;
        foreach ($collection[0] as $key => $value) {
            if ($key>2) {
                if ($value[0] == "Note Legend") {
                    $note = true;
                } elseif ($note == true) {
                    if (is_numeric($value[0])) {
                        $note_feilds['note_no'] = $value[0];
                        $note_feilds['note'] = $value[1];
                        $note_upload = note::create($note_feilds);
                    } else{
                        return true;
                    }
                } else{
                    $company_check = $this->check_company($value);
                    if ($company_check) {
                        $post_feilds['name'] = $value[0];
                        $slug = strtolower(str_replace(" ","",$value[0]));
                        $post_feilds['slug'] = str_replace("-","",$slug);
                        $company_record = company::where('is_active',1)->where('slug',$slug)->first();
                        if ($company_record) {
                            $car_feilds['company_id'] = $company_record->id;
                        } else{
                            $company = company::create($post_feilds);
                            $car_feilds['company_id'] = $company->id;
                        }
                    } else{
                        $new_array = array();
                        $part_check = $this->check_part($value);
                        if ($part_check) {
                            $type_all = $value[6];
                            $value[7] = $type_all;
                            $value[8] = $type_all;
                            $value[9] = $type_all;
                        }
                        foreach ($value as $i => $v) {
                            if ($v == "N/A" || $v == "-" || $v == ">" || $v == "TBD") {
                                $new_array[$i] = null;
                            } elseif (strpos($v, $comma) == true && $i != 0) {
                                $str_arr = explode (",", $v);
                                $new_array[$i] = serialize($str_arr);
                            } else{
                                $new_array[$i] = $v;
                            }
                        }
                        $new_str = str_replace(str_split('\\/:*?"<>|,.()-_'), '', $new_array[0]);

                        $str = str_replace(" ","",$new_str);
                        $strlower = strtolower($str);
                        $drill = str_replace(str_split('\\/:*?"<>|,.()-_'), '', $new_array[6]);
                        $drillstr = str_replace(" ","",$drill);
                        $drilllower = strtolower($drillstr);
                        $slug = $strlower."-".$drilllower;
                        $check_record = car_details::where('is_active',1)->where('slug',$slug)->first();
                        if (!$check_record) {
                            $car_feilds['slug'] = $slug;
                            $car_feilds['model'] = $new_array[0];
                            $car_feilds['from_year'] = $new_array[1];
                            $car_feilds['to_year'] = $new_array[2];
                            $car_feilds['pistons_caliper'] = $new_array[3];
                            $car_feilds['finish_caliper'] = $new_array[4];
                            $car_feilds['disc_size_type'] = $new_array[5];
                            $car_feilds['drilled_no'] = $new_array[6];
                            $car_feilds['type1_no'] = $new_array[7];
                            $car_feilds['type3_no'] = $new_array[8];
                            $car_feilds['type5_no'] = $new_array[9];
                            $car_feilds['note'] = $new_array[10];
                            $car_feilds['gt_price'] = $new_array[11];
                            $car_feilds['gts_price'] = $new_array[12];
                            $car_feilds['gtr_price'] = $new_array[13];
                            $car_details = car_details::create($car_feilds);
                        }
                    }
                }
            }
        }
        return false;
    }
    public function check_part($array){
        // $flag = false;
        if ($array[6] != null && $array[7] == null && $array[8] == null && $array[9] == null) {
            return true;
        } else{
            return false;
        }

    }
    public function check_company($array){
        $flag = false;
        foreach ($array as $key => $value) {
            if ($key == 0 && $value != null) {
                $flag = true;
            } elseif ($key > 0 && $value == null) {
                $flag = true;
            } else{
                $flag = false;
                return false;
            }
        }
        if ($flag == true) {
            return true;
        } else{
            return false;
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
