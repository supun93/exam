<?php 
$pageTitle = "Create Exam Types";
$nav_slo = "active" ?>
@extends('exam::layouts.master')
@section('page_content')
<?php
$pgName = "examtypes"
?>
<div class="container-fluid behind">
<form class="form-label-left input_mask needs-validation" method="post" action="" id="save{{$pgName}}" novalidate>
    @csrf
    <input type="hidden" name="id" id="id" value="{{$data->exam_type_id ?? ''}}">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="header-title">{{$pageTitle}}</h4>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-right">
                            <a href="{{route('exam-type.list')}}" class="btn btn-info"><span class="fa fa-list"></span> View List</a>
                            <a href="{{route('exam-type.trashlist')}}" class="btn btn-info"><span class="fa fa-trash"></span> View Trash</a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="loader" align="center" style="display:none"><br/><br/>
                <img src="{{ asset('/dist/img/circle-animation.gif') }}">
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="grade_group_name">Exam Type Name</label>
                                <input placeholder='Exam Type Name' type="text" class="form-control" name="exam_type" id="exam_type" required value='{{$data->exam_type ?? ""}}'>
                            </div>
                        </div>
                    </div>
                    <hr class="mt-1 mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-add-row">Save</button>
                            <button class="btn btn-dark" type="reset">Reset</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>
</div>
<script>
$(document).ready(function () {
      
///////////////// Add Batch Types /////
$("#save{{$pgName}}").submit(function(event){
    event.preventDefault(); //prevent default action 
    var exam_type_name = $("#exam_type_name").val();
    if(exam_type_name == ''){
        return;
    }
    var form_data = new FormData(this); //Creates new FormData object
    sendPostAjax("{{route('exam-type.store')}}",form_data);
  });
});
</script>
@endsection
