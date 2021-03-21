<?php 
$pageTitle = "Exam Setup List";
$nav_slo = "active" ?>
@extends('exam::layouts.master')
@section('page_content')
<div class="container-fluid behind">
    <input type="hidden" name="id" id="id" value="{{$data->exam_group_id ?? ''}}">
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                    
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                            <div class="inner">
                                <h5>EXAM GROUPES</h5>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{route('exam-group.list',$id)}}" class="small-box-footer" target='_blank'>More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                            <div class="inner">
                                <h5>STUDENTS AND EXAM GROUPES</h5>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{route('students-assign.exam-group',$id)}}" class="small-box-footer" target='_blank'>More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                            <div class="inner">
                                <h5>INVIGILATORS FOR EXAM</h5>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{route('assign.invigilator',$id)}}" class="small-box-footer" target='_blank'>More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                            <div class="inner">
                                <h5>SPACES ASSIGN FOR EXAM</h5>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{route('exam-spaces.list',$id)}}" class="small-box-footer" target='_blank'>More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<script>
$(document).ready(function () {   
///////////////////////////////////

});
</script>
@endsection
