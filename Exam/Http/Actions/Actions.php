<?php

namespace Modules\Exam\Http\Actions;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Carbon\Carbon;

class Actions extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    
    public static function trash($data){

        if($data->deleted_at != null){
            $msg = "Restored Successfully";
            $data->deleted_at = null;
        }else{
            $msg = "Trashed Successfully";
            $data->deleted_at = Carbon::now();
        }
        if($data->save()){
            return response()->json(array('msg'=> $msg), 200);
        }else{
            return response()->json(array('msg'=> 'Error'), 200);
        }
    }
    public static function store($model,$data)
    {
        $cols = [];
        foreach ($data->except('_token','id') as $key => $part) {
            $cols[] = $key;
        }
        foreach($cols as $cols){
            $model->$cols = $data->$cols;
        }
        if($model->save()){
            $msg = 'Successfully';
            $res = 1;
        }else{
            $msg = 'Error';
            $res = 2;
        }
        return [$msg,$res];
    }
}
