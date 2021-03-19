<?php

namespace Modules\Exam\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Exam\Entities\ExamCategory;
use Carbon\Carbon;
use DB;
use Modules\Exam\Http\Filter\FilterData;
use Modules\Exam\Http\Actions\Actions;
class ExamCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $list = Examcategory::where('deleted_at','=',null)->get();
        return view('exam::exam-category.index')->with(array('list'=>$list));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('exam::exam-category.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        
        if($request->id == ''){
            $model = new Examcategory;
        }else{
            $model = Examcategory::find($request->id);
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
        $data = Examcategory::find($id);
        return view('exam::exam-category.create')->with(array('data'=>$data));
    }
    public function trash(Request $id)
    {
        return Actions::trash(ExamCategory::find($id->id));
    }
    public function trashList()
    {
        $list = Examcategory::where('deleted_at' ,'!=', null)->get();
        return view('exam::exam-category.trash')->with(array('list'=>$list));
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
