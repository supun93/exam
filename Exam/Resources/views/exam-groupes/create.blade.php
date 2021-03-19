<?php 
$pageTitle = "Create Exam Groupes";
$nav_slo = "active" ?>
@extends('exam::layouts.master')
@section('page_content')
<?php
$pgName = "examgroupes"
?>
<div class="container-fluid behind">
<form class="form-label-left input_mask needs-validation" method="post" action="" id="save{{$pgName}}" novalidate>
    @csrf
    <input type="hidden" name="id" id="id" value="{{$data->exam_group_id ?? ''}}">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="header-title">{{$pageTitle}} - {{$subgroupes->moduleName->module_code}} {{$subgroupes->moduleName->module_name}} - {{$subgroupes->tt_date}} - [{{$subgroupes->start_time}} to {{$subgroupes->end_time}}]</h4>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-right">
                            <a href="{{route('exam-group.list',$id)}}" class="btn btn-info"><span class="fa fa-list"></span> View List</a>
                            <a href="{{route('exam-group.trashlist',$id)}}" class="btn btn-info"><span class="fa fa-trash"></span> View Trash</a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="grade_group_name">Exam Group Name</label>
                                <input placeholder='Exam Group Name' type="text" class="form-control" name="exam_group_name" id="exam_group_name" required='true' value='{{$data->exam_group_name ?? ""}}'>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="academic_timetable_information_id" value="{{$id}}">
                    <hr class="mt-1 mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                        <?php
                            $count = Modules\Exam\Entities\Examgroupes::where('academic_timetable_information_id', '=' , $id)->get()->count();
                        ?>
                        @if($count == 0)
                            <button type="submit" class="btn btn-success btn-add-row">Save</button>
                            <button class="btn btn-dark" type="reset">Reset</button>
                        @else
                        Already created a exam group for this timetable id
                        @endif
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
    var reqlength = $('[required="true"]').length;
    var value = $('[required="true"]').filter(function () {
        return this.value != '';
    });

    if (value.length>=0 && (value.length !== reqlength)) {
        masterAlert(2,'','Please make sure all required fields are filled out correctly');
        return;
    }
    var form_data = new FormData(this); //Creates new FormData object
    sendPostAjax("{{route('exam-group.store')}}",form_data);
  });
});
/* function successAjaxFunction(data){
      alert(data.msg);
} */
</script>
@endsection
