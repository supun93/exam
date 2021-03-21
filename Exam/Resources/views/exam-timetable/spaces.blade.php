<?php 
$pageTitle = "Spaces For Exam";
$nav_slo = "active" ?>
@extends('exam::layouts.master')
@section('page_content')
<div class="container-fluid behind">
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="header-title">{{$pageTitle}} - {{$info->moduleName->module_code}} {{$info->moduleName->module_name}} - {{$info->tt_date}} - [{{$info->start_time}} to {{$info->end_time}}]</h4>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-right">
                            </div>
                        </div>
                    </div>
                </div>
                <form class="form-label-left input_mask needs-validation" method="post" action="#" id="form" novalidate>
                @csrf
                <input type="hidden" name="id" id="id" value="{{$id}}">
                <input type="hidden" name="studentsCount" id="studentsCount" value="{{$studentsCount}}">
                <div class="card-body row">
                    <div class="form-group col-md-12">
                        <h6>Students Count: {{$studentsCount}} | 
                         Invigilatos Count: {{$invigilatos->count()}} | 
                        Exam Category: {{$info->examCategory->exam_category}}</h6>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="grade_group_name">Space Category Names</label>
                        <div class="input-group mb-3">
                        <select name='space_category_name_id[]' id="space_category_name_id" class="form-control" multiple required='true'>
                            @foreach($spacename as $spacename)
                            <option value="{{$spacename->id}}">{{$spacename->spacecategory->category_name}} - {{$spacename->name}}</option>
                            @endforeach
                        </select><button class="btn btn-primary input-group-append" type="submit">Check Availability</button>
                        </div>
                    </div>
                    
                </div>
                <div class="card-body" id='response'>

                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>
<script>
$(document).ready(function () {   
///////////////////////////////////
    $("#space_category_name_id").select2({
        placeholder: 'Select Space Category Names',
    });
    
    $("#form").submit(function(event){
        event.preventDefault(); //prevent default action
        var reqlength = $('[required="true"]').length;
        var value = $('[required="true"]').filter(function () {
            return this.value != '';
        });
        if (value.length>=0 && (value.length !== reqlength)) {
            masterAlert(2,'','Please make sure all required fields are filled out correctly');
            return;
        }
        $("#response").html('');
        var form_data = new FormData(this); //Creates new FormData object
        sendPostAjax("{{route('exam-spaces.availability-check')}}",form_data,'');
    });
});
function successAjaxFunction(data){
    var spacecategory_name,category_name,type_name,available_ids;
    if(data.availability == 2){
        masterAlert(2,'','Not Availability');
    }else{
        for(var x=0;x<data.available_ids.length;x++){
            available_ids = data.available_ids[x];
            spacecategory_name = data.available_ids_category_name[x];
            category_name = data.available_ids_category[x];
            type_name = data.available_ids_type[x];
            $("#response").append(spacecategory_name+" - "+category_name+" - "+type_name+" | ");
        }
    }
}
</script>
@endsection
