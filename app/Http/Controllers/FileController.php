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
use App\Models\category;
use App\Models\subcategory;

ini_set('max_execution_time', '0');
ini_set('memory_limit', '-1');    

// use Excel;

class FileController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function file_generator(Request $request){
        // dd($request->file,$request->brand_id);
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
                // dd($rows);
                if ($request->brand_id == 1) {
                    $check = $this->upload_brembo_sheet($rows);
                } elseif ($request->brand_id == 9) {
                    $brand_id=9;
                    $accessories_id=3;
                    $check = $this->upload_accel_sheet($rows,$brand_id,$accessories_id);
                }elseif ($request->brand_id == 10) {
                    $brand_id=10;
                    $accessories_id=4;
                    $check = $this->upload_accel_sheet($rows,$brand_id,$accessories_id);
                } elseif ($request->brand_id == 11) {
                    $brand_id=11;
                    $accessories_id=2;
                    $check = $this->upload_accel_sheet($rows,$brand_id,$accessories_id);
                } else{
                    $check = false;
                }
                
                if ($check) {
                    $msg = "File has been uploaded";
                    return redirect()->back()->with('message', $msg);
                } else{
                    $msg = "File could not be uploaded";
                    return redirect()->back()->with('error', $msg);
                }
            }
            $msg = "File could not be uploaded";
            return redirect()->back()->with('error', $msg);
        } catch(Exception $e) {
          $error = $e->getMessage();
          return redirect()->back()->with('error', "Error Code: ".$error);
        }
    }
    public function upload_accel_sheet($collection,$brand_id,$accessories_id){
        foreach ($collection[0] as $i => $v) {
            foreach ($v as $j => $x) {
                if ($collection[0][$i][$j] == null || $collection[0][$i][$j] == "") {
                    $collection[0][$i][$j] = "N/A";
                }
            }
        }
        foreach ($collection[0] as $key => $value) {
            $car_feilds = array();
            if ($key>0) {
                if ($value[0] != null && $value[0] != '') {
                    $slug = $value[0];
                    $model = $value[2];
                    $slug .= strtolower(str_replace(" ","",$value[2]));
                    if ($value[3] != 'N/A') {
                        $slug .= '-'.strtolower(str_replace(" ","",$value[3]));
                        $model .= ' '.$value[3];
                    }
                    $check_slug = car_details::where('is_active',1)->where('slug',$slug)->first();
                  // dd($check_slug);
                    // if ($check_slug === null) {
                    if ($check_slug == null) {
                        $company_slug = strtolower(str_replace(" ","",$value[1]));
                        $check_company = company::where('is_active',1)->where('slug',$company_slug)->first();
                        if ($check_company == null) {
                            $company_feilds = array('slug'=>$company_slug , 'name' => $value[1]);
                            $company = company::create($company_feilds);
                            $car_feilds['company_id'] = $company->id;
                        } else{
                            $car_feilds['company_id'] = $check_company->id;
                        }
                        $car_feilds['from_year'] = $value[0];
                        $car_feilds['brand_id'] = $brand_id;
                        $car_feilds['part_no'] = $value[7];
                        $car_feilds['gtin_no'] = $value[9];
                        $car_feilds['extended_desc'] = $value[11];
                         if ($value[19]=='N/A') {
                        $car_feilds['retail_price'] = '0';
                         }else{
                        $car_feilds['retail_price'] = $value[19];
                         }
                        $car_feilds['desc'] = $value[21];
                        // dd($model);
                        $car_feilds['slug'] = $slug;
                        $car_feilds['model'] = $model;
                        $category_slug = strtolower(str_replace(" ","",$value[6]));
                        $check_category = category::where('is_active',1)->where('slug',$category_slug)->first();
                        if ($check_category == null) {
                            $category_feilds = array('slug'=>$category_slug , 'name' => $value[6] , 'accessories_id' =>$accessories_id);
                            $category = category::create($category_feilds);
                            $category_id = $category->id;
                            $car_feilds['category_id'] = $category_id;
                        } else{
                            $category_id = $check_category->id;
                            $car_feilds['category_id'] = $category_id;
                        }
                        $subcategory_slug = strtolower(str_replace(" ","",$value[8]));
                        $check_subcategory = subcategory::where('is_active',1)->where('slug',$subcategory_slug)->first();
                        if ($check_subcategory == null) {
                            $subcategory_feilds = array('slug'=>$subcategory_slug , 'name' => $value[8] , 'accessories_id' =>$accessories_id, 'category_id'=>$category_id);
                            $subcategory = subcategory::create($subcategory_feilds);
                            $car_feilds['subcategory_id'] = $subcategory->id;
                        } else{
                            $car_feilds['subcategory_id'] = $check_subcategory->id;
                        }
        // dd($car_feilds);
                        $car_details = car_details::create($car_feilds);
                    }
                }
            }
        }
        return true;
    }
    public function upload_brembo_sheet($collection){
        // dd($collection);
        $car_feilds= array();
        $note_feilds= array();
        $comma = ",";
        $note = false;
        $car_feilds['company_id'] = 0;
        $car_feilds['brand_id'] = 1;
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
