<?php

namespace Modules\Exam\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Exam\Entities\Examgroupes;
use Modules\Exam\Entities\AcademicTimeTableInformation;
use Carbon\Carbon;
use DB;
use Modules\Exam\Http\Actions\Actions;
class ExamgroupesController extends Controller 
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($id)
    {
        $subgroupes = AcademicTimeTableInformation::with(['subgroupesForTimetable' => function ($e){
            $e->with(['subgroup'])->get();
        },'moduleName'])->find($id);
        //dd($subgroupes);
        $list = Examgroupes::whereDeletedAt(null)->where('academic_timetable_information_id',$id)->get();
        return view('exam::exam-groupes.index', Compact('list','id','subgroupes'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($id)
    {
        $subgroupes = AcademicTimeTableInformation::with(['subgroupesForTimetable' => function ($e){
            $e->with(['subgroup'])->get();
        },'moduleName'])->find($id);
        //dd($subgroupes);
        return view('exam::exam-groupes.create' , Compact('id','subgroupes'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
       
        if($request->id == ''){
            $model = new Examgroupes;
        }else{
            $model = Examgroupes::find($request->id);
        }
        $request->request->add(['status' => '1']); //add request
        $res = Actions::store($model,$request);        
        return response()->json(array('res'=> $res[1],'msg'=>$res[0]), 200);
    }
    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($groupid,$id)
    {
        $data = Examgroupes::find($groupid);
        $subgroupes = AcademicTimeTableInformation::with(['subgroupesForTimetable' => function ($e){
            $e->with(['subgroup'])->get();
        },'moduleName'])->find($id);
        
        return view('exam::exam-groupes.create', Compact('data','id','subgroupes'));
    }
    public function trash(Request $id)
    {
        return Actions::trash(Examgroupes::find($id->id));
    }
    public function trashList($id)
    {
        $subgroupes = AcademicTimeTableInformation::with(['subgroupesForTimetable' => function ($e){
            $e->with(['subgroup'])->get();
        },'moduleName'])->find($id);
        $list = Examgroupes::where('deleted_at' ,'!=', null)->where('academic_timetable_information_id',$id)->get();
        return view('exam::exam-groupes.trash', Compact('list','id','subgroupes'));
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
