<?php 
$pageTitle = "Grades List";
$nav_slo = "active" ?>
@extends('exam::layouts.master')
@section('page_content')
<?php
$pgName = "grades"
?>
<div class="container-fluid behind">
<div class="card">
<div class="card-header">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="header-title">{{$pageTitle}}</h4>
        </div>
        <div class="col-sm-6">
            <div class="float-right">
                <a href="{{route('grades.create')}}" class="btn btn-info"><span class="fa fa-plus"></span> Add New</a>
                <a href="{{route('grades.trashlist')}}" class="btn btn-info"><span class="fa fa-trash"></span> View Trash</a>
            </div>
        </div>
    </div>
</div>
<div class="card-body">
    <table id="table" class="table table-striped table-bordered dt-responsive nowrap">
    <thead class="thead">
    <tr>
    <th>ID</th>
    <th>Grade Name</th>
    <th>GPA</th>
    <th>Percent From</th>
    <th>Percent Upto</th>
    <th>Status</th>
    <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($list as $list)
    <tr>
    <td>{{$list->grade_id}}</td>
    <td>{{$list->grade_name}}</td>
    <td>{{$list->gpa}}</td>
    <td>{{$list->start}}</td>
    <td>{{$list->end}}</td>
    <td>
    <?php
    if($list->status == 0){
        echo '<span class="badge badge-danger">In Active</span>';
    }else{
        echo '<span class="badge badge-success">Active</span>';
    }
    ?>
    </td>
    <td>
      <input type="hidden" class="id" id="id" value="{{$list->grade_id}}">
      <a href="{{route('grades.create')}}/{{$list->grade_id}}"><div class="btn btn-xs"><span class="fa fa-edit"></span> Edit</div></a>
      <div class="btn btn-xs trashBut" ><span class="fa fa-trash"></span> Trash</div></div>
    </td>
    </tr>
    @endforeach
    </tbody>
    </table>
</div>
</div>
</div>
<script>
$(document).ready(function () {
    $(".trashBut").click(function() {
        var row = $(this).closest("tr"),       // Finds the closest row <tr> 
            tds = row.find("td");
            id = tds.find(".id").val();  
            trashFunction("{{route('grades.trash')}}",id,'trash');   
    });
});
</script>

@endsection
