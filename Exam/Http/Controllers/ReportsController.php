<?php

namespace Modules\Exam\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Slo\Entities\Batch;
use Modules\Exam\Http\Filter\FilterData;
use Modules\Slo\Entities\Courses;
use Modules\Slo\Entities\Faculty; 
use Modules\Slo\Entities\Departments;
use Modules\Slo\Entities\Student;
use Modules\Slo\Entities\BatchStudent;
use Modules\Slo\Entities\Studentregcourses;
use Modules\Slo\Entities\Stdreqdetails;
use Modules\Slo\Entities\Groupes; 
use Modules\Slo\Entities\Subjecsgroupestypes;
use Modules\Slo\Entities\Subgroups;
use Modules\Slo\Entities\Subgroupesstd;
use Modules\Slo\Entities\Uploadc;
use Modules\Slo\Entities\Moduletypes;
use Modules\Slo\Entities\Inputf;
use Modules\Slo\Entities\Selectoptions;
use Modules\Slo\Entities\Stdtitles;
use Modules\Slo\Entities\StudentUp;
use Modules\Slo\Entities\Country;
use Modules\Slo\Entities\Provinces;
use Modules\Slo\Entities\District;
use Modules\Slo\Entities\Cities;

use DB;
use Session;
use Illuminate\Support\Facades\Schema;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable 
     */
    
    public function genTable (Request $request){
        
        $field_name = [];
        $field_input = [];
        $field_db_tb = [];
        
        for($x=1;$x < count($request->all()) - 1;$x++){
            $field = 'field_'.$x;
            if($request->$field == 'Title'){
                $field_name[$x] = $request->$field;
                $field_input[$x] = 3;
                $field_db_tb[$x] = 'std_title';
            }else if($request->$field == 'Name_with_Initials'){
                $field_name[$x] = $request->$field;
                $field_input[$x] = 1;
                $field_db_tb[$x] = 'name_initials';
            }else if($request->$field == 'Full_Name'){
                $field_name[$x] = $request->$field;
                $field_input[$x] = 1;
                $field_db_tb[$x] = 'full_name';
            }else if($request->$field == 'NIC_/_Passport'){
                $field_name[$x] =  $request->$field;
                $field_input[$x] = 1;
                $field_db_tb[$x] =  'nic_passport';
            }else if($request->$field == 'Mobile_Number'){
                $field_name[$x] = $request->$field;
                $field_input[$x] =  1;
                $field_db_tb[$x] =  'tel_mobile1';
            }else if($request->$field == 'Work_Telephone'){
                $field_name[$x] =  $request->$field;
                $field_input[$x] =  1;
                $field_db_tb[$x] =  'tel_work';
            }else if($request->$field == 'Resident_Telephone'){
                $field_name[$x] =  $request->$field;
                $field_input[$x] =  1;
                $field_db_tb[$x] =  'tel_residence';
            }else if($request->$field == 'Email'){
                $field_name[$x] = $request->$field;
                $field_input[$x] =  1;
                $field_db_tb[$x] =  'email1';
            }else if($request->$field == 'KIU_Email'){
                $field_name[$x] =  $request->$field;
                $field_input[$x] =  1;
                $field_db_tb[$x] =  'kiu_mail';
            }else if($request->$field == 'KIU_Register_Date'){
                $field_name[$x] =  $request->$field;
                $field_input[$x] = 4;
                $field_db_tb[$x] =  'reg_date';
            }else if($request->$field == 'Country'){
                $field_name[$x] =  $request->$field;
                $field_input[$x] = 3;
                $field_db_tb[$x] =  'per_country';
            }else if($request->$field == 'Province'){
                $field_name[$x] =  $request->$field;
                $field_input[$x] = 3;
                $field_db_tb[$x] =  'per_province';
            }else if($request->$field == 'District'){
                $field_name[$x] =  $request->$field;
                $field_input[$x] = 3;
                $field_db_tb[$x] =  'per_district';
            }else if($request->$field == 'City'){
                $field_name[$x] =  $request->$field;
                $field_input[$x] = 3;
                $field_db_tb[$x] =  'per_city';
            }else if($request->$field == 'Address'){
                $field_name[$x] =  $request->$field;
                $field_input[$x] = 1;
                $field_db_tb[$x] =  'per_address';
            }else if($request->$field == 'Postal_Country'){
                $field_name[$x] =  $request->$field;
                $field_input[$x] = 1;
                $field_db_tb[$x] =  'postal_country';
            }else if($request->$field == 'Postal_Province'){
                $field_name[$x] =  $request->$field;
                $field_input[$x] = 1;
                $field_db_tb[$x] =  'postal_province';
            }else if($request->$field == 'Postal_District'){
                $field_name[$x] =  $request->$field;
                $field_input[$x] = 1;
                $field_db_tb[$x] =  'postal_district';
            }else if($request->$field == 'Postal_City'){
                $field_name[$x] =  $request->$field;
                $field_input[$x] = 1;
                $field_db_tb[$x] =  'postal_city';
            }else if($request->$field == 'Postal_Address'){
                $field_name[$x] =  $request->$field;
                $field_input[$x] = 1;
                $field_db_tb[$x] =  'postal_address';
            }else if($request->$field == 'Upload_Category'){
                $field_name[$x] =  $request->$field;
                $field_input[$x] = 3;
                $field_db_tb[$x] =  'category';
            }else if($request->$field == 'Upload_Sub_Category'){
                $field_name[$x] =  $request->$field;
                $field_input[$x] = 3;
                $field_db_tb[$x] =  'sc_id';
            }else if($request->$field == 'Faculty'){
                $field_name[$x] =  $request->$field;
                $field_input[$x] = 1;
                $field_db_tb[$x] =  'faculty_id';
            }else if($request->$field == 'Departments'){
                $field_name[$x] =  $request->$field;
                $field_input[$x] = 1;
                $field_db_tb[$x] =  'dept_id';
            }else if($request->$field == 'Courses'){
                $field_name[$x] =  $request->$field;
                $field_input[$x] = 1;
                $field_db_tb[$x] =  'course_id';
            }else if($request->$field == 'Batches'){
                $field_name[$x] =  $request->$field;
                $field_input[$x] = 1;
                $field_db_tb[$x] =  'batch_id';
            }else if($request->$field == 'Groupes'){
                if($request->batch_id !=""){
                    $field_input[$x] = 3;
                }else{
                    $field_input[$x] = 1;
                }
                $field_name[$x] =  $request->$field;
                $field_db_tb[$x] =  'mg_id';
            }else{
                $colmn_name = str_replace("_","",$request->$field);
                $inputf = Inputf::where('inputname','=',$colmn_name)->first();
                $field_name[$x] =  $inputf->fname ?? '';
                $field_input[$x] = $inputf->fid ?? '';
                $field_db_tb[$x] =  $colmn_name ?? '';
            }
        }
        $field_name = str_replace("_"," ",$field_name);
        return view('slo::listdata.stdfiltertable')->with(array(
            "field_name"=>$field_name,
            "field_input"=>$field_input,
            "field_db_tb"=>$field_db_tb,
            "lastUrl" => $request->lastUrl,
            "batch_id" => $request->batch_id
        ));
    } 
    public function genFieldsAll(Request $request){

        $additional_val = $request->additional_val ?? []; /// this is additional data
        $table_type = $request->table_type; /// this is table type. ex:- batch
        $table_type_id = $request->table_type_id; /// this is type id. ex:- batch_id
        $table_details = [$table_type,$table_type_id]; 
        $col_name = []; 
        $db_col_name = []; 
        $data_value = [];
        $col_order = 0; 
        for($x=1;$x<=$request->total_cols;$x++){
            $col_name2 = "field_name_".$x;
            $col_name_before[$x] =  $request->$col_name2 ?? ''; 

            $field_tb = "field_".$x;
            $db_col_name2 =  $request->$field_tb ?? '';
            $db_col_name_before[$x] =  $request->$field_tb ?? ''; 

            $data_value_before[$x] = $request->$db_col_name2 ?? ''; 

            if($col_name_before[$x] == '' || $db_col_name_before[$x] == ''){
                continue;
            }else{
                $col_order++;
                $col_name[$col_order] = $col_name_before[$x]; /// this is col name. ex:- Title
                $db_col_name[$col_order] = $db_col_name_before[$x]; /// this is col name in table. ex:- std_title
                $data_value[$col_order] = $data_value_before[$x]; /// this is search value. ex:- Mr.
            }
        }
        
        $data = FilterData::filterStudentsData($table_type,$table_type_id);
        $y = 0;
        $z = 0;
        $group = array();
        foreach($data as $data){
        
            for($x=1;$x<=$col_order;$x++){
                $z = 0;
                if($db_col_name[$x] == "std_title" ){
                    if($data_value[$x] !=''){
                        $title = Stdtitles::find($data_value[$x]);
                        $check = Student::where('std_title','=',$title->t_name)->where('range_id','=',$data->student_id)->get()->count();
                        if($check == 0){
                            continue 2; 
                        }
                    }
                }else if($db_col_name[$x] == "reg_date" ){
                    if($data_value[$x] !=''){
                        $check = Student::where('reg_date','=',$data_value[$x])->where('range_id','=',$data->student_id)->get()->count();
                        if($check == 0){
                            continue 2;
                        }
                    }
                }else if($db_col_name[$x] == "category" ){
                    if($data_value[$x] !=''){
                        $check = StudentUp::where('category','=',$data_value[$x])->where('student','=',$data->std_id)->get()->count();
                        if($check == 0){
                            continue 2;
                        }
                    }
                }else if($db_col_name[$x] == "sc_id" ){
                    if($data_value[$x] !=''){
                        $check = StudentUp::where('sc_id','=',$data_value[$x])->where('student','=',$data->std_id)->get()->count();
                        if($check == 0){
                            continue 2;
                        }
                    }
                }else if($db_col_name[$x] == "mg_id" ){
                    if($data_value[$x] !=''){
                        $check = BatchStudent::where('mg_id','=',$data_value[$x])->where('student_inc_id','=',$data->std_id)->get()->count();
                        if($check == 0){
                            continue 2;
                        }
                    }
                }else if($db_col_name[$x] == "gender" ){
                    if($data_value[$x] !=''){
                        $check = Student::where('gender','=',$data_value[$x])->where('student_id','=',$data->std_id)->get()->count();
                        if($check == 0){
                            continue 2;
                        }
                    }
                }else if($db_col_name[$x] == "per_country" ){
                    if($data_value[$x] !=''){
                        $check = Student::where('per_country','=',$data_value[$x])->where('student_id','=',$data->std_id)->get()->count();
                        if($check == 0){
                            continue 2;
                        }
                    }
                }else if($db_col_name[$x] == "postal_country" ){
                    if($data_value[$x] !=''){
                        $check = Student::where('postal_country','=',$data_value[$x])->where('student_id','=',$data->std_id)->get()->count();
                        if($check == 0){
                            continue 2;
                        }
                    }
                }else if($db_col_name[$x] == "per_province" ){
                    if($data_value[$x] !=''){
                        $check = Student::where('per_province','=',$data_value[$x])->where('student_id','=',$data->std_id)->get()->count();
                        if($check == 0){
                            continue 2;
                        }
                    }
                }else if($db_col_name[$x] == "per_district" ){
                    if($data_value[$x] !=''){
                        $check = Student::where('per_district','=',$data_value[$x])->where('student_id','=',$data->std_id)->get()->count();
                        if($check == 0){
                            continue 2;
                        }
                    }
                }else if($db_col_name[$x] == "per_city" ){
                    if($data_value[$x] !=''){
                        $check = Student::where('per_city','=',$data_value[$x])->where('student_id','=',$data->std_id)->get()->count();
                        if($check == 0){
                            continue 2;
                        }
                    }
                }else{
                    if($data_value[$x] !=''){
                        $inputf = Inputf::where('inputname','=',$db_col_name[$x])->first();
                        $sdtreq = Stdreqdetails::where('inputname','=',$inputf->fname)->where('text','=',$data_value[$x])->where('std_id','=',$data->std_id)->get()->count();
                        if($sdtreq == 0){
                            continue 2;
                        }
                    }
                }
                $z++;
            }
            if($z !=0){
                $y++;
            }
            $group[$y]['std_id'] = $data->std_id;
            $group[$y]['student_id'] = $data->student_id;
            $group[$y]['gen_id'] = $data->gen_id;
            $group[$y]['b_s_p_k'] = $data->batch_student_primary_key ?? 0;
            $group[$y]['batch_id'] = $data->batch_id ?? 0;
            for($x=1;$x<=$col_order;$x++){
                
                $checkinputf  = Inputf::where('inputname','=',$db_col_name[$x])->first();
                if($checkinputf->fid ?? '' != ''){
                    $val = Stdreqdetails::where('inputname','=',$checkinputf->fname)->where('std_id','=',$data->std_id)->first();
                    if(($checkinputf->fid == 1) || ($checkinputf->fid == 2) || ($checkinputf->fid == 4)){
                        $group[$y][$db_col_name[$x]] = $val['text'] ?? null; /// this is value
                    }else if($checkinputf->fid == 3){
                        $option = Selectoptions::find($val['text'] ?? null);
                        $group[$y][$db_col_name[$x]] = $option->option_value ?? null; /// this is value
                    }
                }else if($db_col_name[$x] == 'category'){
                    //$val = DB::table('student_uploads')->join('upload_categories','upload_categories.upload_cat_id','=','student_uploads.category')->select('upload_categories.upload_cat_id','upload_categories.category_name','upload_categories.cat_code')->where('student_uploads.student','=',$data->std_id)->distinct()->get();
                    $group[$y][$db_col_name[$x]] = 'ct'; //// this is value
                }else if($db_col_name[$x] == 'sc_id'){
                    //$val = DB::table('student_uploads')->join('upload_subcategories','upload_subcategories.id','=','student_uploads.sc_id')->select('upload_subcategories.id','upload_subcategories.category_name','upload_subcategories.sc_code','upload_subcategories.mc_id')->where('student_uploads.student','=',$data->std_id)->get();
                    $group[$y][$db_col_name[$x]] = 'sct'; //// this is value
                }else if($db_col_name[$x] == 'faculty_id' || $db_col_name[$x] == 'dept_id' || $db_col_name[$x] == 'course_id'){
                    $col = $db_col_name[$x];
                    $val = '';
                    $type = Student::select('student_id')->with(["regCourses:student_inc_id,$col"])->find($data->std_id);
                    //foreach($type->regCourses as $regCourses){
                        if($col == 'faculty_id'){ 
                            $dd = Faculty::find($type->regCourses->$col);
                            $val = $val.','.$dd->faculty_name ?? "";
                        }
                        else if($col == 'dept_id'){
                            $dd = Departments::find($type->regCourses->$col);
                            $val = $val.','.$dd->dept_name ?? "";
                        }
                        else if($col == 'course_id'){
                            $dd = Courses::find($type->regCourses->$col);
                            $val = $val.','.$dd->course_name ?? "";
                        }
                    //}
                    $val = substr($val, 1);
                    $group[$y][$db_col_name[$x]] = $val;

                }else if($db_col_name[$x] == 'per_country'){
                    $val = Country::find($data->per_country);
                    $group[$y][$db_col_name[$x]] = $val->country_name;
                }else if($db_col_name[$x] == 'postal_country'){
                    $val = Country::find($data->postal_country);
                    $group[$y][$db_col_name[$x]] = $val->country_name;
                }else if($db_col_name[$x] == 'per_province'){
                    $val = Provinces::find($data->per_province);
                    $group[$y][$db_col_name[$x]] = $val->name_en ?? "";
                }else if($db_col_name[$x] == 'per_district'){
                    $val = District::find($data->per_district);
                    $group[$y][$db_col_name[$x]] = $val->name_en ?? "";
                }else if($db_col_name[$x] == 'per_city'){
                    $val = Cities::find($data->per_city);
                    $group[$y][$db_col_name[$x]] = $val->name_en ?? "";
                }else if($db_col_name[$x] == 'batch_id' || $db_col_name[$x] == 'mg_id'){
                    $col = $db_col_name[$x];
                    $val = '';
                    $type = Student::select('student_id')->with(["batchStudent:student_inc_id,$col"])->find($data->std_id);
                    foreach($type->batchStudent as $batchStudent){
                        if($col == 'batch_id'){ 
                            $dd = Batch::find($batchStudent->$col);
                            $val = $val.','.$dd->batch_name ?? '';
                        }
                        else if($col == 'mg_id'){
                            $dd = Groupes::find($batchStudent->$col);
                            if($dd !=null){
                                $val = $val.','.$dd->GroupName ?? '';
                            }
                        }
                    }
                    $val = substr($val, 1);
                    $group[$y][$db_col_name[$x]] = $val;
                }else{
                    $val = $db_col_name[$x];
                    $group[$y][$db_col_name[$x]] = $data->$val ?? ''; /// this is value
                }
            }
        }
        Session::put(array(
            'additional_val'=>$additional_val,
            'group'=> $group,
            'col_name'=>$col_name,
            'db_col_name'=>$db_col_name,
            'table_details'=>$table_details
            ));
        return response()->json(array('group'=> $group,'col_name'=>$col_name,'db_col_name'=>$db_col_name));
        //return response()->json(array('msg'=> 1));
        
    } 
    public function finalRes($action){
        $col_name = Session::get('col_name');
        $db_col_name = Session::get('db_col_name');
        $group = Session::get('group');
        $additional_val = Session::get('additional_val');
        $table_details = Session::get('table_details');
        return view('slo::listdata.'.$action)->with(array(
            'additional_val'=>$additional_val,
            'group'=> $group,
            'col_name'=>$col_name,
            'db_col_name'=>$db_col_name,
            'table_details'=>$table_details
            ));
    }
    public function genFields(Request $request){
        /////////////// groupes ////////////////////////
        $group_cols = [];
        foreach($request->groupes ?? [] as $groupes){
             $group_cols[] = str_replace(" ","_",$groupes);
        }
        /////////////// main///////////////////////////
        $main_cols = [];
        foreach($request->main_req_input_id ?? [] as $main_req_input_id){
             $main_cols[] = str_replace(" ","_",$main_req_input_id);
        }
        /////////////////////////general/////////////////
        $gen_cols = [];
        foreach($request->general_req_inputf_id ?? [] as $general_req_inputf_id){
             $gen_cols[] = str_replace(" ","_",$general_req_inputf_id);
        }
        /////////////////////////course/////////////////
        $course_cols = [];
        foreach($request->course_req_inputf_id ?? [] as $course_req_inputf_id){
             $course_cols[] = str_replace(" ","_",$course_req_inputf_id);
        }
        return response()->json(array('main'=> $main_cols,'gen'=>$gen_cols,'course'=>$course_cols,'groupes'=>$group_cols));
    }
    public function filterData($type, $id)
    {   
        if($type == 'faculty'){
            $xx = FilterData::filterDataModules($id,0,0,0,0,0,0);
            
            return response()->json($xx);
        }else if($type == 'department'){
            $xx = FilterData::filterDataModules(0,$id,0,0,0,0,0);
            return response()->json($xx);
        }else if($type == 'course'){
            $xx = FilterData::filterDataModules(0,0,$id,0,0,0,0);
            return response()->json($xx);
        }else if($type == 'batch'){
            $xx = FilterData::filterDataModules(0,0,0,$id,0,0,0);
            return response()->json($xx);
        }else if($type == 'batchtypes'){
            $xx = FilterData::filterDataModules(0,0,0,0,$id,0,0);
            return response()->json($xx);
        }else if($type == 'coursereqs'){
            $xx = FilterData::filterDataModules(0,0,0,0,0,$id,0);
            return response()->json($xx);
        }else if($type == 'idrangedata'){
            $xx = FilterData::filterDataModules(0,0,0,0,0,0,$id);
            return response()->json($xx);
        }else if($type == 'per_country'){
            $xx = FilterData::filterDataModulesPerProvinces($id);
            return response()->json($xx);
        }else if($type == 'per_province'){
            $xx = FilterData::filterDataModulesPerDistricts($id);
            return response()->json($xx);
        }else if($type == 'per_district'){
            $xx = FilterData::filterDataModulesPerCities($id);
            return response()->json($xx);
        }else{
            $xx = FilterData::filterDataTables($type,$id);
            return view('slo::listdata.'.$type)->with("list",$xx);
        }
    }
    
    public function studentsListReqAll()
    {
        $faculty = Faculty::all();
        return view('exam::reports.studentsreqall')->with(array("faculty"=> $faculty));
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('slo::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('slo::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('slo::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
