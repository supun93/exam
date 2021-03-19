<?php

namespace Modules\Exam\Http\Filter;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Slo\Entities\BatchTypes;
use Modules\Slo\Entities\Batch;
use Modules\Slo\Entities\Courses;
use Modules\Slo\Entities\Groupes;
use Modules\Slo\Entities\Faculty;
use Modules\Slo\Entities\Departments;
use Modules\Slo\Entities\Student;
use Modules\Slo\Entities\CourseStudent;
use Modules\Slo\Entities\Country;
use Modules\Slo\Entities\StudentUp;
use Modules\Slo\Entities\Idrange;
use Modules\Slo\Entities\Slqfstr;
use Modules\Slo\Entities\Inputf;
use Modules\Slo\Entities\BatchStudent;
use Modules\Slo\Entities\Stdreqdetails;
use Modules\Slo\Entities\Stdtitles;
use Modules\Slo\Entities\Studentregcourses;
use Modules\Slo\Entities\Subgroupesstd;
use Modules\Slo\Entities\Studentslogindetails;
use Modules\Slo\Entities\Smsmessages;
use Modules\Slo\Entities\Smshistory;
use Modules\Slo\Entities\Subgroups;
use Modules\Slo\Entities\Studentstransfer; 
use Modules\Slo\Entities\Moduletypes;
use Modules\Slo\Entities\Studentsdetailschangesrequests;
use Modules\Slo\Http\Controllers\Smscontroller;
use Modules\Slo\Entities\Cities;
use Modules\Slo\Entities\Actionsdocs;
use Modules\Slo\Entities\StudentsActions;
use Modules\Slo\Entities\Provinces;
use Modules\Slo\Entities\District;
use Modules\Slo\Entities\ActionsforBatchStudents;

use DB;
class FilterData extends Controller
{ 
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public static function filterDataModulesPerCities($district){
        $data = District::find($district)->citiesSelect;
        return $data;
    }
    public static function filterDataModulesPerDistricts($province){
        $data = Provinces::find($province)->districtsSelect;
        return $data;
    }
    public static function filterDataModulesPerProvinces($country){
        $data = Country::find($country)->provincesSelect;
        return $data;
    }
    public static function filterDataModules($faculty,$department,$course,$batch,$batchtypes,$coursereqs,$ids)
    {
        if($faculty !=0){
            $data = Faculty::find($faculty)->departmentsSelect;
        }else if($department !=0){
            $data = Departments::find($department)->coursesSelect;
        }else if($course !=0){
            $data = Courses::find($course)->batchesSelect;
        }else if($batch !=0){
            $data =  DB::table('groupe_batches')
                    ->join('groupes', 'groupes.GroupID', '=', 'groupe_batches.group_id')
                    ->select('groupes.GroupID as id','groupes.GroupName as text')
                    ->where('groupe_batches.batch_id' , '=' , $batch)
                    ->where('groupes.deleted_at' , '=' , null)
                    ->where('groupe_batches.deleted_at' , '=' , null)->get();
        }else if($batchtypes !=0){ 
            $data =  DB::table('types_batch')
                    ->join('batch_types', 'batch_types.id', '=', 'types_batch.type_id')
                    ->join('batches', 'batches.batch_id', '=', 'types_batch.batch_id')
                    ->join('courses', 'courses.course_id', '=', 'batches.course_id')
                    ->select('types_batch.type_id as id','batch_types.description as text')
                    ->where("courses.course_id" , "=" , $batchtypes)
                    ->distinct()->get();
        }else if($coursereqs !=0){
            $data =  DB::table('inputfs')
                    ->select('inputfs.id','inputfs.fname as text')
                    ->where('inputfs.course_id' , '=' , $coursereqs)->get();
        }else if($ids !=0){
            $data =  DB::table('id_ranges')
                    ->select('id_ranges.start','id_ranges.end')
                    ->where('id_ranges.course_id' , '=' , $ids)->where('deleted_at','=',null)->where('hold','=',0);
                    if($data->count() !=0){
                        $data = $data->latest()->first();
                    }else{
                        $data = [];
                    }
        }
        return $data;
    }
    public static function filterDataTables($type,$id)
    {
        if($type == 'batches'){
            $data = DB::table('batches')
                        ->join('courses', 'courses.course_id', '=', 'batches.course_id')
                        ->join('course_syllabi', 'course_syllabi.syllabus_id', '=', 'batches.syllabus_id')
                        ->select('batches.*', 'courses.course_name', 'courses.course_code','course_syllabi.syllabus_name')
                        ->where("batches.deleted_at" , "=" , null)
                        ->where("batches.course_id" , "=" , $id)->get();
        }else if($type == 'idranges'){
            $data = DB::table('id_ranges')
                        ->join('courses', 'courses.course_id', '=', 'id_ranges.course_id')
                        ->select('id_ranges.*', 'courses.course_name', 'courses.course_code')
                        ->where('id_ranges.deleted_at' , '=' , null)
                        ->where('id_ranges.course_id' , '=' , $id)
                        ->get();
        }else if($type == 'groupes'){
            $data = DB::table('groupe_batches')
                        ->join('groupes', 'groupes.GroupID', '=', 'groupe_batches.group_id')
                        ->join('courses', 'courses.course_id', '=', 'groupes.CourseID')
                        ->select('groupes.*', 'courses.course_code','courses.course_name')
                        ->where('groupe_batches.batch_id' , '=' , $id)
                        ->where('groupe_batches.deleted_at' , '=' , null)->get();
        }else if($type == 'subgroupes'){
            $data = DB::table('subgroups')
                        ->join('groupes', 'groupes.GroupID', '=', 'subgroups.main_gid')
                        ->join('academic_semesters', 'academic_semesters.semester_id', '=', 'subgroups.semester')
                        ->join('academic_years', 'academic_years.academic_year_id', '=', 'subgroups.year')
                        ->join('courses', 'courses.course_id', '=', 'groupes.CourseID')
                        ->join('module_delivery_modes', 'module_delivery_modes.delivery_mode_id', '=', 'subgroups.dm_id')
                        ->select('subgroups.*', 'groupes.*','courses.*','module_delivery_modes.*','subgroups.max_students as maxstudents','subgroups.assigned as subassigned','academic_semesters.semester_name','academic_years.year_name')
                        ->where("subgroups.deleted_at" , "=" , null)
                        ->where("subgroups.main_gid" , "=" , $id)->get();
        }else{
            $data = 'invalid type';
        }
        return $data;
    }
    public static function filterStudentsData($table_type,$table_type_id)
    {
        if($table_type == 'batch'){
            $data = DB::table('batch_student')
                    ->join('students', 'students.range_id', '=', 'batch_student.student_id')
                    ->select('batch_student.batch_id','batch_student.id as batch_student_primary_key','students.*','students.student_id as std_id','students.range_id as student_id','students.full_name')
                    ->where('batch_student.batch_id' , '=' , $table_type_id)
                    ->where('batch_student.status' , '=' , 0)
                    ->distinct()->get();
        }else if($table_type == 'course'){
            $data = DB::table('student_reg_courses')
                    ->join('students', 'students.range_id', '=', 'student_reg_courses.student_id')
                    ->join('batch_student', 'batch_student.student_id', '=', 'students.range_id')
                    ->select('students.*','students.*','students.student_id as std_id','students.range_id as student_id','students.full_name')
                    ->where('student_reg_courses.course_id' , '=' , $table_type_id)
                    ->where('batch_student.status' , '=' , 0)
                    ->distinct()->get();
        }else if($table_type == 'dept'){
            $data = DB::table('student_reg_courses')
                    ->join('students', 'students.range_id', '=', 'student_reg_courses.student_id')
                    ->join('batch_student', 'batch_student.student_id', '=', 'students.range_id')
                    ->select('students.*','students.*','students.student_id as std_id','students.range_id as student_id','students.full_name')
                    ->where('student_reg_courses.dept_id' , '=' , $table_type_id)
                    ->where('batch_student.status' , '=' , 0)
                    ->distinct()->get();
        }else if($table_type == 'faculty'){
            $data = DB::table('student_reg_courses')
                    ->join('students', 'students.range_id', '=', 'student_reg_courses.student_id')
                    ->join('batch_student', 'batch_student.student_id', '=', 'students.range_id')
                    ->select('students.*','students.student_id as std_id','students.range_id as student_id','students.full_name')
                    ->where('student_reg_courses.faculty_id' , '=' , $table_type_id)
                    ->where('batch_student.status' , '=' , 0)
                    ->distinct()->get();
        }else{
            $data = [];
        }
        return $data;
    }
}
