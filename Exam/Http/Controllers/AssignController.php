<?php

namespace Modules\Exam\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Exam\Entities\AcademicTimeTableInformation;
use Modules\Exam\Entities\ExamCategory;
use Modules\Exam\Entities\Examgroupes;
use Modules\Exam\Entities\AcademicTimeTableSubgroupes;
use Modules\Exam\Entities\Subgroupesstd;
use Modules\Exam\Entities\ExamgroupsStudents;
use Illuminate\Support\Facades\DB;
use Modules\Exam\Http\Filter\FilterData;
use Modules\Exam\Http\Actions\Actions;
use Modules\Exam\Entities\Subgroups;
use Modules\Exam\Entities\Course;
use Modules\Exam\Entities\Groupes;
use Modules\Exam\Entities\Studentregcourses;
use Modules\Exam\Entities\BatchStudent;
use Modules\Exam\Entities\Lectures;
use Modules\Exam\Entities\Employees;
use Modules\Exam\Entities\InvigilatorForExam;
use Session;
use Carbon\Carbon;

class AssignController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function assignLecturesForExamRemove (Request $request){
        $delete = InvigilatorForExam::find($request->row_id);
        $delete->delete();
        return response()->json(array('msg'=>1 ));
    }
    public function assignLecturesForExamStore (Request $request){
        
        $new = new InvigilatorForExam;
        $new->invigilator_id = $request->id;
        $new->academic_timetable_information_id = $request->info_id;
        $new->from_table_name = $request->table;
        $new->save();
        return response()->json(array('msg'=>1 ));
    }
    public function assignLecturesForExam($id){

        $lectures = Lectures::select('lecturer_id as id','name_in_full as name','employee_id')->where('employee_id',null);
        $employees = Employees::select('employee_id as id','name_in_full as name','employee_id');
        $list = $lectures->union($employees);
        $examgroupes = Examgroupes::where('academic_timetable_information_id',$id)->first();
        $subgroupes = AcademicTimeTableInformation::with(['subgroupesForTimetable' => function ($e){
            $e->with(['subgroup'])->get();
        },'moduleName','examCategory'])->find($id);
        $students = ExamgroupsStudents::where('academic_timetable_information_id','=',$id)->get();
        $studentsCount = 0;
        foreach($students as $student){
            if($student->subgroup_id !=null){
                $subg = Subgroupesstd::where('sg_id',$student->subgroup_id)->get()->count();
                $studentsCount = $studentsCount + $subg;
            }else{
                $studentsCount = $studentsCount + 1;
            }
        }
        $text1 = $studentsCount / $subgroupes->examCategory->student_count;
        $text2 =  strtok($text1, '.');
        if($text1 > $text2){
           $text2 = $text2 + 1; 
        }
        $invigilatos = InvigilatorForExam::where('academic_timetable_information_id',$id)->get();
        return view('exam::exam-groupes.assigninvigilator')->with(array('invigilator'=>$text2,'studentsCount'=>$studentsCount,'students'=>$students,'list'=>$list->get(),'id'=>$id,"examgroupes"=>$examgroupes,'subgroupes'=>$subgroupes));
    }
    public function assignStudentsExamGroupesAssignManual(Request $request)
    {
        $x = 0;
        foreach($request->student as $student){
            $select = "select_".$x;
            $note = "sp_note_".$x;
            if($request->$select =='on'){
            $add = new ExamgroupsStudents;
            $add->exam_group_id = $request->exam_group_id;
            $add->student_id = $student;
            $add->note = $request->$note;
            $add->status = 1;
            $add->academic_timetable_information_id = $request->info_id;
            $add->save();
            }
            $x++;
        }
        if($x==0){
           return response()->json(array('msg'=>2 ));
        }else{
           return response()->json(array('msg'=>3 ));
        }
    }
    public function studentsAssignListManual($action){
        $students = Session::get('students');
        $exam_group_id = Session::get('exam_group_id');
        $info_id = Session::get('info_id');
        return view('exam::listdata.'.$action)->with(array(
            'students'=>$students,
            'exam_group_id'=> $exam_group_id,
            'info_id'=>$info_id
            ));
    }
    public function assignStudentsExamGroupesManual  ($id)
    {
        $examgroupes = Examgroupes::where('academic_timetable_information_id',$id)->get();
        //$check = ExamgroupsStudents::where('student_id','=',0)->where('academic_timetable_information_id','=',$id)->get();
        $subgroup = DB::table('academic_timetable_subgroups')
                    ->join('subgroups', 'subgroups.id', '=', 'academic_timetable_subgroups.subgroup_id')
                    ->select('subgroups.*')
                    ->where("academic_timetable_subgroups.academic_timetable_information_id" , "=" , $id)
                    ->latest()->first();
       // dd($subgroup->main_gid);

        $group = Groupes::find($subgroup->main_gid ?? 0);
        $batches = Course::with(['batches'])->find($group->CourseID);
        //dd($batches);
        return view('exam::exam-groupes.assignstudentsm')->with(array('id'=>$id,"examgroupes"=>$examgroupes,'course_id'=>$group->CourseID ?? 0,'batches'=>$batches));
    }
    public function assignStudentsExamGroupesListManual(Request $request){
        
        $students = BatchStudent::with(['student'])->whereBatchId($request->batch_id)->whereStatus(0)->get();
        
        Session::put(array(
            'students'=>$students,
            'exam_group_id'=> $request->exam_group_id,
            'info_id'=>$request->info_id
            ));
        return response()->json(array('msg'=> 1));
    }
    public function assignStudentsExamGroupes ($id)
    {
        $examgroupes = Examgroupes::where('academic_timetable_information_id',$id)->get();
        $subgroupes = AcademicTimeTableInformation::with(['subgroupesForTimetable' => function ($e){
                        $e->with(['subgroup'])->get();
                    }])->find($id);
        //dd($subgroupes);
        return view('exam::exam-groupes.assignstudents')->with(array('id'=>$id,"examgroupes"=>$examgroupes,'subgroupes'=>$subgroupes));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function assignStudentsExamGroupesAssign(Request $request)
    {
        $subgroupes = $request->sg;
        $i=0;
        foreach($subgroupes as $subgroupes){
            $check = ExamgroupsStudents::where('subgroup_id','=',$subgroupes)->where('exam_group_id','=',$request->exam_group_id)->get()->count();
            if($check !=0){
                continue;
            }
            $i++;
            $add = new ExamgroupsStudents;
            $add->exam_group_id = $request->exam_group_id;
            $add->subgroup_id = $subgroupes;
            $add->academic_timetable_information_id = $request->info_id;
            $add->save();
        }
        if($i==0){
            return response()->json(array('msg'=>2 ));
        }else{
            return response()->json(array('msg'=>3 ));
        }
    }
    public function assignStudentsExamGroupesList (Request $request)
    {
        $subgroupes = DB::table('academic_timetable_subgroups')
                    ->join('subgroups', 'subgroups.id', '=', 'academic_timetable_subgroups.subgroup_id')
                    ->select('subgroups.*')
                    ->where("academic_timetable_subgroups.academic_timetable_information_id" , "=" , $request->info_id)
                    ->get();
            $i = 0;
            $sg = [];
            foreach($subgroupes as $subgroupes){
                
                $sg[] = $subgroupes->id;
                $data = DB::table('subgroupes_std')
                    ->join('students', 'students.range_id', '=', 'subgroupes_std.std_id')
                    ->select('students.*')
                    ->where("subgroupes_std.sg_id" , "=" , $subgroupes->id);
                    if($i < 1){
                        $students = $data;
                    }else{
                        $students->union($data);
                    }
                    $i++;
            }

            if($i !=0){
                $db = DB::table('exam_group_students')
                        ->join('students', 'students.range_id', '=', 'exam_group_students.student_id')
                        ->select('students.*')
                        ->where("exam_group_students.exam_group_id" , "=" , $request->exam_group_id)
                        ->where("exam_group_students.academic_timetable_information_id" , "=" , $request->info_id)
                        ->where("exam_group_students.student_id" , "!=" , 0);
                $ss = $students->union($db);
                $students = $ss->get();
            }else{
                $students = DB::table('exam_group_students')
                ->join('students', 'students.range_id', '=', 'exam_group_students.student_id')
                ->select('students.*')
                ->where("exam_group_students.exam_group_id" , "=" , $request->exam_group_id)
                ->where("exam_group_students.academic_timetable_information_id" , "=" , $request->info_id)
                ->where("exam_group_students.student_id" , "!=" , 0)->get();
            }
        
        Session::put(array(
            'students'=>$students,
            'exam_group_id'=> $request->exam_group_id,
            'info_id'=>$request->info_id,
            'sg'=>$sg,
            ));
        return response()->json(array('msg'=> 1));

    }
    public function studentsAssignList($action){
        $students = Session::get('students');
        $exam_group_id = Session::get('exam_group_id');
        $info_id = Session::get('info_id');
        $sg = Session::get('sg');
        $assigned = Session::get('assigned');
        return view('exam::listdata.'.$action)->with(array(
            'students'=>$students,
            'exam_group_id'=> $exam_group_id,
            'info_id'=>$info_id,
            'sg'=>$sg,
            ));
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
        return view('exam::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('exam::edit');
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
