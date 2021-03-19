<?php

namespace Modules\Exam\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Exam\Entities\Batch as batchtbl;
use Modules\Exam\Entities\Course;
use Modules\Exam\Entities\Faculty;
use Modules\Exam\Entities\Department; 
use Modules\Exam\Http\Filter\FilterData;
use Modules\Exam\Http\Actions\Actions;
use Modules\Academic\Entities\AcademicCalendar;
use Modules\Academic\Entities\AcademicTimetable;
use Modules\Academic\Entities\AcademicTimetableInformation;
use Modules\Academic\Repositories\AcademicCalendarRepository;
use Modules\Academic\Repositories\AcademicTimetableRepository;
use DB;

class LoadDataController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function setpumenu($id){
        return view('exam::exam-timetable.setupmenu', Compact('id'));
    }
    public function timetable($timetableId=false)
    {
        if($timetableId)
        {
            $model = AcademicTimetable::with(["course", "academicYear", "semester", "batch", "group", "deliveryMode", "subgroup"])->find($timetableId);
            //dd($model);
            if($model)
            {
                if($model->auto_gen_status!="1")
                {
                    $courseId = $model->course_id;
                    $academicYearId = $model->academic_year_id;
                    $semesterId = $model->semester_id;
                    $batchId = $model->batch_id;

                    $acaCalRepo = new AcademicCalendarRepository();
                    $academicCalendar = $acaCalRepo->getAcademicCalendar($courseId, $academicYearId, $semesterId, $batchId);

                    $repository = new AcademicTimetableRepository();
                    if($academicCalendar)
                    {
                        $model->department = $model->course->department;
                        $model->faculty = $model->department->faculty->toArray();

                        if(!$model->deliveryMode)
                        {
                            $model->deliveryMode = $model->subgroup->deliveryMode->toArray();
                        }

                        $record = $model->toArray();

                        $record["academicCalendar"] = $academicCalendar;
                        $records = AcademicTimetableInformation::query()->where("academic_timetable_id", $timetableId)->get()->toArray();

                        $record["timetable"] = $repository->getTimetable($records);

                        return view('slo::attendence.index', compact('record'));
                    }
                    else
                    {
                        $aCModel = new AcademicCalendar();
                        $course = $aCModel->course()->first();
                        $year = $aCModel->academicYear()->first();
                        $semester = $aCModel->semester()->first();
                        $batch = $aCModel->batch()->first();

                        $response["status"]="failed";
                        $response["notify"][]=$course->name." - ".$year->name." - ".$semester->name." - ".$batch->name. " academic calendar has been removed.";
                        $response["notify"][]="Academic timetable will not be available until fix this issue.";

                        return $repository->handleResponse($response);
                    }
                }
                else
                {
                    abort(403, "Timetable update is not available while auto generation of this timetable is in progress.");
                }
            }
            else
            {
                abort(404, "Requested record does not exist.");
            }
        }
        else
        {
            $model = new AcademicTimetable();
            $record = $model;

            $record["timetable"] = [];
            return view('exam::exam-timetable.timetable' , compact('record'));
            //return view('slo::attendence.index', compact('record'));
        }
        //return view('exam::exam-groupes.create');
    }
    public function filterData($type, $id)
    {   
        
        if($type == 'faculty'){
            $xx = FilterData::filterDataModules($id,0,0,0,0,0);
            return response()->json($xx);
        }else if($type == 'department'){
            $xx = FilterData::filterDataModules(0,$id,0,0,0,0);
            return response()->json($xx);
        }else if($type == 'course'){
            $xx = FilterData::filterDataModules(0,0,$id,0,0,0);
            return response()->json($xx);
        }else if($type == 'batch'){
            $xx = FilterData::filterDataModules(0,0,0,$id,0,0);
            return response()->json($xx);
        }else if($type == 'batchtypes'){
            $xx = FilterData::filterDataModules(0,0,0,0,$id,0);
            return response()->json($xx);
        }else if($type == 'coursereqs'){
            $xx = FilterData::filterDataModules(0,0,0,0,0,$id);
            return response()->json($xx);
        }else{
            $xx = FilterData::filterDataTables($type,$id);
            return view('slo::listdata.'.$type)->with("list",$xx);
        }
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
