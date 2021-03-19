<?php 
$pageTitle = "Grade Groupes Trashed List";
$nav_slo = "active" ?>
@extends('exam::layouts.master')
@section('page_content')
<?php
$pgName = "gradegroupes"
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
                <a href="{{route('exam-type.create')}}" class="btn btn-info"><span class="fa fa-plus"></span> Add New</a>
                <a href="{{route('exam-type.list')}}" class="btn btn-info"><span class="fa fa-list"></span> View List</a>
            </div>
        </div>
    </div>
</div>
<div class="card-body">
<table id="table" class="table table-striped table-bordered dt-responsive nowrap">
    <thead class="thead">
    <tr>
    <th>ID</th>
    <th>Exam Type Name</th>
    <th>Status</th>
    <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($list as $list)
    <tr>
    <td>{{$list->exam_type_id}}</td>
    <td>{{$list->exam_type}}</td>
    <td>
    <?php
    if($list->type_status == 0){
        echo '<span class="badge badge-danger">In Active</span>';
    }else{
        echo '<span class="badge badge-success">Active</span>';
    }
    ?>
    </td>
    <td>
      <input type="hidden" class="id" id="id" value="{{$list->exam_type_id}}">
      <a href="{{route('exam-type.create')}}/{{$list->exam_type_id}}"><div class="btn btn-xs"><span class="fa fa-edit"></span> Edit</div></a>
      <div class="btn btn-xs trashBut" ><span class="fa fa-window-restore"></span> Restore</div></div>
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
                trashFunction("{{route('exam-type.trash')}}",id,'restore'); 
        });
    });
</script>

@endsection
