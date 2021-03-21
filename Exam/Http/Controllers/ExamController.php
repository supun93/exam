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
    public function availabilityCheck(Request $request){
        $id = $request->id;
        $info = AcademicTimeTableInformation::with(['subgroupesForTimetable' => function ($e){
            $e->with(['subgroup'])->get();
        },'moduleName','examCategory'])->find($id);
        $aa = AcademicSpaceRepository::getAcademicSpaceIds();
        $bb = new AcademicTimetableRepository;
        $cc = $bb->getAvailableSpaceIds($info->academic_timetable_id,$info->tt_date,$info->start_time,$info->end_time,$aa,10);
        $x = 0;
        $available_ids = []; $available_ids_type = []; $available_ids_category_name = []; $available_ids_category = [];
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
                $x = $x + $count;
                if($x > $request->studentsCount){
                    break 2;
                }
            }
        }

        if($x > $request->studentsCount){
            return response()->json(array(
                'availability'=> 1 , 
                'available_ids'=> $available_ids,
                'available_ids_type'=>$available_ids_type,
                'available_ids_category_name'=> $available_ids_category_name,
                'available_ids_category' => $available_ids_category));
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
        $invigilatos = InvigilatorForExam::where('academic_timetable_information_id',$id)->get();
        $spacename = Spacename::with(['spacecategory'])->whereDeletedAt(Null)->get();
        //dd($spacename);
        return view('exam::exam-timetable.spaces',Compact('id','info','studentsCount','invigilatos','spacename'));
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
