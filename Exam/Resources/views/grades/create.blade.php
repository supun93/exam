<?php 
$pageTitle = "Create Grades";
$nav_slo = "active" ?>
@extends('exam::layouts.master')
@section('page_content')
@if(isset($data))
<script>
$(document).ready(function () {
$("#grade_group_id").val(<?php echo $data->grade_group_id; ?>);
});
</script>
@endif
<?php
$pgName = "grades"
?>
<div class="container-fluid behind">
<form class="form-label-left input_mask needs-validation" method="post" action="" id="save{{$pgName}}" novalidate>
    @csrf
    <input type="hidden" name="id" id="id" value="{{$data->grade_id ?? ''}}">
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
                            <a href="{{route('grades.list')}}" class="btn btn-info"><span class="fa fa-list"></span> View List</a>
                            <a href="{{route('grades.trashlist')}}" class="btn btn-info"><span class="fa fa-trash"></span> View Trash</a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="loader" align="center" style="display:none"><br/><br/>
                <img src="{{ asset('/dist/img/circle-animation.gif') }}">
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="grade_group_name">Grade Groupes</label>
                                <select class="form-control" id="grade_group_id" name='grade_group_id' required>
                                <option value=''>Select a Grade Group</option>
                                @foreach($Gradegroupes as $Gradegroupes)
                                <option value='{{$Gradegroupes->grade_group_id}}'>{{$Gradegroupes->group_name}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="grade_name">Grade Name</label>
                                <input placeholder='Grade Name' type="text" class="form-control" name="grade_name" id="grade_name" required value='{{$data->grade_name ?? ""}}'>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gpa">GPA</label>
                                <input placeholder='GPA' type="number" class="form-control" name="gpa" id="gpa" required value='{{$data->gpa ?? ""}}'>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start">Percent From</label>
                                <input placeholder='Percent From' type="number" class="form-control" name="start" id="start" required value='{{$data->start ?? ""}}'>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end">Percent Upto</label>
                                <input placeholder='Percent Upto' type="number" class="form-control" name="end" id="end" required value='{{$data->end ?? ""}}'>
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
    var grade_group_id = $("#grade_group_id").val();
    var grade_name = $("#grade_name").val();
    var gpa = $("#gpa").val();
    var start = $("#start").val();
    var end = $("#end").val();
    if((grade_group_id == '') || (grade_name == '') || (gpa == '')
    || (start == '') || (end == '')){
        return;
    }
    var form_data = new FormData(this); //Creates new FormData object
    sendPostAjax("{{route('grades.store')}}",form_data);
  });
});
</script>
@endsection
