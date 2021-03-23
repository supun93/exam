<?php 
$pageTitle = "Assign students to Exam Groupes Manual";
$nav_slo = "active" ?>
@extends('exam::layouts.master')
@section('page_content')
<?php
$pgName = "assign"
?>
<div class="container-fluid behind">
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
                            <a href="{{route('students-assign.exam-group',$id)}}" class="btn btn-info"><span class="fa fa-list"></span> Normal Assign</a>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="selection" value="0">
                <div class="card-body">
                <form action='' id="save{{$pgName}}" method='post'>
                @csrf
                <input type="hidden" name="info_id" id="info_id" value="{{$id ?? ''}}">
                <input type="hidden" name="course_id" id="course_id" value="{{$course_id ?? ''}}">
                <div class="row">
                    <div class="col-md-4">
                        <select class=" form-control" name='exam_group_id' required>
                        <option value=''>Select Exam Groupes</option>
                        @foreach($examgroupes as $examgroupes)
                        <option value='{{$examgroupes->exam_group_id}}'>{{$examgroupes->exam_group_name}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class=" form-control" name='batch_id' id='batch_id' required>
                        <option value=''>Select a batch</option>
                        @foreach($batches->batches as $batches)
                        <option value='{{$batches->batch_id}}'>{{$batches->batch_name}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                    <button class="btn btn-primary input-group-append" id="">Load</button>
                    </div>
                </div>
                </form>
                </div>
            </div>
            <div id="loadTableFull"></div>
        </div>
    </div>
</div>
<script> 
$(document).ready(function () {   
$(".select2").width("100%");  $("#loadBut").hide();
///////////////// Add Batch Types /////
$("#save{{$pgName}}").submit(function(event){
    event.preventDefault(); //prevent default action 
    var exam_group_id = $("#exam_group_id").val();
    var batch_id = $("#batch_id").val();
    if(exam_group_id == '' || batch_id == ''){
        return;
    }
    $("#loadTableFull").hide();
    var form_data = new FormData(this); //Creates new FormData object
    loadSpin.toggle();
    sendPostAjax("{{route('students-exam-group-manual.list')}}",form_data,'');
  });
});
function successAjaxFunction(data){
    if(data.msg==2){
        toastr.error('already assigned');
    }else if(data.msg == 3){
        toastr.success('successfully');
        var route = "{{ route('students-assign-manual.list','') }}/subgroupstdsm";
        $("#loadTableFull").load(route, function() {
            loadSpin.toggle();
        });
    }else{
        $("#loadTableFull").show();
        var route = "{{ route('students-assign-manual.list','') }}/subgroupstdsm";
        $("#loadTableFull").load(route, function() {
            loadSpin.toggle();
        });
    }
}
</script>
@endsection
