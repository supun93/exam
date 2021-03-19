<?php 
$pageTitle = "Assign students to Exam Groupes";
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
                            <h4 class="header-title">{{$pageTitle}} - 
                            @foreach($subgroupes->subgroupesForTimetable as $subgroupes)
                            {{$subgroupes->subgroup->sg_name ?? ''}} / 
                            @endforeach</h4>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-right">
                            <a href="{{route('students-assign-exam-group.manual',$id)}}" class="btn btn-info"><span class="fa fa-list"></span> Manual Assign</a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                <form action='' id="save{{$pgName}}" method='post'>
                @csrf
                <input type="hidden" name="info_id" id="info_id" value="{{$id ?? ''}}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group input-group">
                            <select class="select2 form-control" name='exam_group_id' required>
                            <option value=''>Select Exam Groupes</option>
                            @foreach($examgroupes as $examgroupes)
                            <option value='{{$examgroupes->exam_group_id}}'>{{$examgroupes->exam_group_name}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                    <button class="btn btn-primary input-group-append" id="loadBut">Load</button>
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
///////////////// Add Batch Types /////
$("#save{{$pgName}}").submit(function(event){
    event.preventDefault(); //prevent default action 
    var exam_group_id = $("#exam_group_id").val();
    if(exam_group_id == ''){
        return;
    }
    $("#loadTableFull").hide();
    var form_data = new FormData(this); //Creates new FormData object
    sendPostAjax("{{route('students-exam-group.list')}}",form_data,'kk');
  });
});
function successAjaxFunction(data){
    if(data.msg==2){
        toastr.error('already assigned');
    }else if(data.msg == 3){
        toastr.success('successfully');
        var route = "{{ route('students-assign.list','') }}/subgroupstds";
        $("#loadTableFull").load(route, function() {
            loadSpin.toggle();
        });
    }else{
        $("#loadTableFull").show();
        var route = "{{ route('students-assign.list','') }}/subgroupstds";
        $("#loadTableFull").load(route, function() {
            loadSpin.toggle();
        });
    }
}
</script>
@endsection
