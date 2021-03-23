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
use Modules\Exam\Entities\Spacename;
use Modules\Exam\Entities\Studentregcourses;
use Modules\Exam\Entities\BatchStudent;
use Modules\Exam\Entities\Lectures;
use Modules\Exam\Entities\Employees;
use Modules\Exam\Entities\InvigilatorForExam;
use Modules\Exam\Entities\ExamRates;
use Modules\Slo\Entities\Spaceassign;
use Modules\Slo\Entities\Student;
use Modules\Exam\Entities\ExamSpacesStudents;
use Modules\Exam\Entities\ExamSpacesInvigilators;
use Modules\Academic\Repositories\AcademicSpaceRepository;
use Modules\Academic\Repositories\AcademicTimetableRepository;
use Session;
use Carbon\Carbon;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('exam::index');
    }
    public function assignSpaces (Request $request){
        
        $info_id = $request->id;
        $students = ExamgroupsStudents::where('academic_timetable_information_id',$info_id)->get();
        $studentsAll = []; $invigilatorsAll = [];
        foreach($students as $student){
            if($student->subgroup_id !=null){
                $stds = Subgroupesstd::where('sg_id',$student->subgroup_id)->get();
                foreach($stds as $stds){
                    $std = Student::whereRangeId($stds->std_id)->first();
                    $studentsAll[] = $std->student_id;
                }
            }else{
                $std = Student::whereRangeId($student->student_id)->first();
                $studentsAll[] = $std->student_id;
            }
        }
        $invigilators = InvigilatorForExam::where('academic_timetable_information_id',$info_id)->get();
        foreach($invigilators as $invigilator){
            $invigilatorsAll[] = $invigilator->row_id;
        }
        $added = 0;
        foreach($request->space_id as $space_id){
            $space = Spaceassign::find($space_id);
            for($x=1;$x<=$space->std_count;$x++){
                if(count($studentsAll) > 0){
                    $student = array_rand($studentsAll);
                    $student_id = $studentsAll[$student];
                    unset($studentsAll[$student]);
                    $check = ExamSpacesStudents::whereStudentId($student_id)->where('academic_timetable_information_id',$info_id)->get()->count();
                    if($check == 0){
                        $added++;
                        $add = new ExamSpacesStudents;
                        $add->space_id = $space_id;
                        $add->student_id = $student_id;
                        $add->sheet_number = $x;
                        $add->academic_timetable_information_id = $info_id;
                        $add->save();
                    }
                }
            }
        }
        $spaces_ids = $request->space_id;
        foreach($invigilatorsAll as $invigilator){
            $space = array_rand($spaces_ids);
            $space_id = $spaces_ids[$space];
            $check = ExamSpacesInvigilators::whereInvigilatorId($invigilator)->where('academic_tt_info_id',$info_id);
            $last = $check->latest()->first();
            if($last->space_id ?? 0 == $space_id){
                $space = array_rand($spaces_ids);
                $space_id = $spaces_ids[$space];
            }
            if($last->space_id ?? 0 == $space_id){
                $space = array_rand($spaces_ids);
                $space_id = $spaces_ids[$space];
            }
            if($last->space_id ?? 0 == $space_id){
                $space = array_rand($spaces_ids);
                $space_id = $spaces_ids[$space];
            }
            $supervisor = InvigilatorForExam::find($invigilator);
            if($check->get()->count() == 0){
                $added++;
                $add = new ExamSpacesInvigilators;
                $add->invigilator_id = $invigilator;
                if($supervisor->supervisor == 0){
                    $add->space_id = $space_id;
                }
                $add->academic_tt_info_id = $info_id;
                $add->save();
            }
        }
        if($added == 0){
            return response()->json(array('res'=> 3,'msg'=> 'Nothing to assign'));
        }else{
            return response()->json(array('res'=> 1));
        }
        
    }
    public function availabilityCheck(Request $request){
        $id = $request->id;
        $info = AcademicTimeTableInformation::with(['subgroupesForTimetable' => function ($e){
            $e->with(['subgroup'])->get();
        },'moduleName','examCategory'])->find($id);
        $aa = AcademicSpaceRepository::getAcademicSpaceIds();
        $bb = new AcademicTimetableRepository;
        $cc = $bb->getAvailableSpaceIds($info->academic_timetable_id,$info->tt_date,$info->start_time,$info->end_time,$aa,10);
        $x = 0;
        $available_ids = []; $available_ids_type = []; $available_ids_category_name = []; $available_ids_category = []; $students_limit = [];
        foreach($request->space_category_name_id as $space_category_name_id){
            foreach($cc as $available_id){
                $check = Spaceassign::with(['spaceCategoryName' => function($e){
                    $e->with(['spacecategory'])->get();
                },'spaceType'])->whereId($available_id)->whereCnId($space_category_name_id)->first();
                $count = $check->std_count ?? 0;
                $type = $check->spaceType->type_name ?? "";
                $category_name = $check->spaceCategoryName->name ?? "";
                $category = $check->spaceCategoryName->spacecategory->category_name ?? "";
                $available_ids[] = $available_id;
                $available_ids_type[] = $type;
                $available_ids_category_name[] = $category_name;
                $available_ids_category[] = $category;
                $students_limit[] = $count;
                $x = $x + $count;
                
            }
        }

        if($x > $request->studentsCount){
            return response()->json(array(
                'availability'=> 1 , 
                'available_ids'=> $available_ids,
                'available_ids_type'=>$available_ids_type,
                'available_ids_category_name'=> $available_ids_category_name,
                'available_ids_category' => $available_ids_category,
                'students_limit'=>$students_limit));
        }else{
            return response()->json(array('availability'=> 2 ));
        }
        
    }
    public function spacesList($id)
    {
        $info = AcademicTimeTableInformation::with(['subgroupesForTimetable' => function ($e){
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
        $invigilatos = InvigilatorForExam::where('academic_timetable_information_id',$id)->where('supervisor',0)->get();
        $spacename = Spacename::with(['spacecategory'])->whereDeletedAt(Null)->get();
        $assignedStudentsList = ExamSpacesStudents::with(['student','spaces' =>function ($e){
            $e->with(['spaceType','spaceCategoryName' => function ($b){
                $b->with(['spacecategory'])->get();
            }])->get();
        }])->where('academic_timetable_information_id',$id)->get();
        //dd($assignedStudentsList[0]);
        $assignedInvigilatorsList = ExamSpacesInvigilators::with(['spaces' =>function ($e){
            $e->with(['spaceType','spaceCategoryName' => function ($b){
                $b->with(['spacecategory'])->get();
            }])->get();
        }])->where('academic_tt_info_id',$id)->where('space_id','!=',null)->get();
        $assignedStudentsCount = $assignedStudentsList->count();
        //dd($assignedInvigilatorsList);
        $assignedSpaces = ExamSpacesInvigilators::select('space_id')->with(['spaces' => function($e){
            $e->with(['spaceType','spaceCategoryName' => function($b){
                $b->with(['spacecategory'])->get();
            }])->get();
        }])->where('academic_tt_info_id',$id)->where('space_id','!=',null)->distinct()->get();
        //dd($assignedSpaces);
        $supervisors = ExamSpacesInvigilators::where('academic_tt_info_id',$id)->where('space_id','=',null)->get();
        return view('exam::exam-timetable.spaces',Compact('supervisors','assignedSpaces','id','info','studentsCount','invigilatos','spacename','assignedStudentsCount','assignedStudentsList','assignedInvigilatorsList'));
    }
    public function examRatesForm()
    {
        $examRates = ExamRates::find(1);
        return view('exam::exam-rates.create',Compact('examRates'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('exam::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function examRatesUpdate (Request $request)
    {
        
        if($request->id == ''){
            $model = new ExamRates;
        }else{
            $model = ExamRates::find(1);
        }
        $res = Actions::store($model,$request);        
        return response()->json(array('res'=> $res[1],'msg'=>$res[0]), 200);
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
