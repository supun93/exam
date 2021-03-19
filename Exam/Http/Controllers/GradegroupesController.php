<?php

namespace Modules\Exam\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Exam\Entities\Gradegroupes;
use Modules\Exam\Http\Actions\Actions;
use Carbon\Carbon;
use DB;

class GradegroupesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $list = Gradegroupes::where('deleted_at' ,'=', null)->get();
        return view('exam::gradegroupes.index')->with(array('list'=>$list));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('exam::gradegroupes.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        if($request->id == ''){
            $model = new Gradegroupes;
        }else{
            $model = Gradegroupes::find($request->id);
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
        $data = Gradegroupes::find($id);
        return view('exam::gradegroupes.create')->with(array('data'=>$data));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function trash(Request $id)
    {
        return Actions::trash(Gradegroupes::find($id->id));
        
    }
    public function trashList()
    {
        $list = Gradegroupes::where('deleted_at' ,'!=', null)->get();
        return view('exam::gradegroupes.trash')->with(array('list'=>$list));
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
