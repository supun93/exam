<?php 
$pageTitle = "Spaces For Exam";
$nav_slo = "active" ?> 
@extends('exam::layouts.master')
@section('page_content')
<div class="container-fluid behind">
<script src="https://seatchart.js.org/seatchart/js/seatchart.js"></script>
<link rel="stylesheet" href="https://seatchart.js.org/seatchart/css/seatchart.css">

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
                <div class="card-body row">
                    <div class="form-group col-md-12">
                        <h6>Supervisors Count: {{$supervisors->count()}} | Invigilatos Count: {{$invigilatos->count()}} | 
                        Exam Category: {{$info->examCategory->exam_category}}</h6>
                    </div>
                    <div class="form-group col-md-12" align='center'>
                        <h4>Students Pending to Assign: <span id='limit'>{{$studentsCount - $assignedStudentsCount}}</span></h4>
                    </div>
                    <div class="form-group col-md-6">
                        <form class="" method="post" action="#" id="form" novalidate>
                        @csrf
                        <label for="grade_group_name">Space Category Names</label>
                        <div class="input-group mb-3">
                        <input type="hidden" name="id" id="id" value="{{$id}}">
                        <input type="hidden" name="studentsCount" id="studentsCount" value="{{$studentsCount}}">
                        <select name='space_category_name_id[]' id="space_category_name_id" class="form-control" multiple required='true'>
                            @foreach($spacename as $spacename)
                            <option value="{{$spacename->id}}">{{$spacename->spacecategory->category_name}} - {{$spacename->name}}</option>
                            @endforeach
                        </select><button class="btn btn-primary input-group-append" type="submit" id='abc'>Check Availability</button>
                        </div>
                        </form>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <form class="" method="post" action="#" id="assignSpaces">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{$id}}">
                        <input type="hidden" name="studentsCount" id="studentsCount" value="{{$studentsCount}}">
                        <label for="grade_group_name">Available Spaces</label>
                        <div class="input-group mb-3">
                        <select name='space_id[]' id="space_id" class="form-control" multiple required>
                        </select><button class="btn btn-primary input-group-append" type='submit'>Assign</button>
                        </div>
                        </form>
                    </div>
                </div>                
            </div>
            <?php
            if(count($assignedSpaces) !=0){
            ?>
            <div class="card">
            <div class='card-body'>

            <div class='float-right'>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter">
            Change Assigned Spaces
            </button>
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Change Spaces</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <select class='form-control select2' id='old_space_id' name='old_space_id'>
                    @foreach($assignedSpaces as $assignedSpace)
                    <option value='{{$assignedSpace->space_id}}'>{{$assignedSpace->spaces->spaceCategoryName->name}} - {{$assignedSpace->spaces->spaceCategoryName->spacecategory->category_name}} {{$assignedSpace->spaces->spaceType->type_name}}</option>
                    @endforeach
                    </select>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
            </div>
            </div>

            <h6 style='margin-bottom:20px'><b><u>ASSIGNED  SUPERVISORS</u></b></h6>
            @foreach($supervisors as $supervisor)
            <?php
                $inv = Modules\Exam\Entities\InvigilatorForExam::find($supervisor->invigilator_id);
                if($inv->from_table_name == "lecturers"){
                    $invigi = Modules\Exam\Entities\Lectures::find($inv->invigilator_id);
                }else{
                    $invigi = Modules\Exam\Entities\Employees::find($inv->invigilator_id);
                }
            ?>
            {{$invigi->name_in_full}} | 
            @endforeach
            </div>
            </div>
            <?php
            }
            ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                        <h6 style='margin-bottom:20px'><b><u>ASSIGNED STUDENTS</u></b></h6>
                            <table id="table2" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead class="">
                            <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Location</th>
                            <th>Seet Number</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($assignedStudentsList as $student)
                                <tr>
                                    <td>{{$student->student->range_id}}</td>
                                    <td>{{$student->student->full_name}}</td>
                                    <td>{{$student->spaces->spaceCategoryName->name}} - {{$student->spaces->spaceCategoryName->spacecategory->category_name}} - {{$student->spaces->spaceType->type_name}}</td>
                                    <td>{{$student->sheet_number}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                        <h6 style='margin-bottom:20px'><b><u>ASSIGNED INVIGILATORS</u></b></h6>
                            <table id="table3" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead class="">
                            <tr>
                            <th>Full Name</th>
                            <th>Location</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($assignedInvigilatorsList as $invigilator)
                            <?php
                                $inv = Modules\Exam\Entities\InvigilatorForExam::find($invigilator->invigilator_id);
                                if($inv->from_table_name == "lecturers"){
                                    $invigi = Modules\Exam\Entities\Lectures::find($inv->invigilator_id);
                                }else{
                                    $invigi = Modules\Exam\Entities\Employees::find($inv->invigilator_id);
                                }
                            ?>
                                <tr>
                                    <td>{{$invigi->name_in_full}}</td>
                                    <td>{{$invigilator->spaces->spaceCategoryName->name}} - {{$invigilator->spaces->spaceCategoryName->spacecategory->category_name}} - {{$invigilator->spaces->spaceType->type_name}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="card">
                <div class='card-body'>
                    <div id="map-container" class="col-md-4 float-left"></div>
                </div>
            </div>



        </div>
    </div>
    </div>
</div>
<script>
    var options = {
        // Reserved and disabled seats are indexed
        // from left to right by starting from 0.
        // Given the seatmap as a 2D array and an index [R, C]
        // the following values can obtained as follow:
        // I = columns * R + C
        map: {
            id: 'map-container',
            rows: 9,
            columns: 9,
            // e.g. Reserved Seat [Row: 1, Col: 2] = 7 * 1 + 2 = 9
            reserved: {
                seats: [],
                rows: [],
                columns: []
            },
            disabled: {
                seats: [],
                rows: [],
                columns: []
            }
        },
        types: [
            { type: "regular", backgroundColor: "#006c80", price: 10, selected: [23, 24] },
            { type: "reduced", backgroundColor: "#287233", price: 7.5, selected: [25, 26] }
        ],
 
        assets: {
            path: "./assets",
        }
    };

    var sc = new Seatchart(options);
</script>
<script>
$('#table2').DataTable({
        "pagingType": "full_numbers",
        "responsive": true,
        "paging": true,
        "searching": true,
        "ordering": true,
});
$('#table3').DataTable({
        "pagingType": "full_numbers",
        "responsive": true,
        "paging": true,
        "searching": true,
        "ordering": true,
});
$(document).ready(function () {
    
///////////////////////////////////
    $("#space_category_name_id").select2({
        placeholder: 'Select Space Category Names',
    });
    $("#space_id").select2({
        placeholder: 'Select Spaces',
    });
    $("#assignSpaces").submit(function(event){
        event.preventDefault(); //prevent default action
        var reqlength = $('[required="true"]').length;
        var value = $('[required="true"]').filter(function () {
            return this.value != '';
        });
        if(value.length>=0 && (value.length !== reqlength)){
            masterAlert(2,'','Please make sure all required fields are filled out correctly');
            return;
        }
        var form_data = new FormData(this); //Creates new FormData object
        sendPostAjax("{{route('exam-spaces.assign')}}",form_data);

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
        $("#space_id").html('').trigger('change'); 
        var form_data = new FormData(this); //Creates new FormData object
        sendPostAjax("{{route('exam-spaces.availability-check')}}",form_data,'');
    });


    $("#space_id").change(function(){
        var space_id = $(this).val();
        var stdCount = $("#limit").html();
        var studentsCount = $("#studentsCount").val();
        var a = studentsCount;
        var newCount,selectedCount,bb;
        if(space_id !="" && space_id !=null){
            var limit = $(this).find(':selected');
            $.each(limit, function(){
                if(studentsCount <= 0){
                    $(this).val(bb).trigger("change");
                }else{
                    bb = space_id;
                    selectedCount = $(this).data("limit");
                    newCount = studentsCount - selectedCount;
                    if(newCount <0){
                        $("#limit").html('0');
                    }else{
                        $("#limit").html(newCount);
                    }
                    studentsCount = newCount;
                }
            });
        }else{
            $("#limit").html(a);
        }
    });
    <?php
    if(count($assignedSpaces) !=0){
        foreach($assignedSpaces as $assignedSpace){
    ?>
        $("#space_category_name_id").val("{{$assignedSpace->spaces->cn_id}}").trigger('change'); 
    <?php
        }
    ?> 
    $('#abc').trigger('click');
    $('#abc').attr('disabled', 'disabled');
    <?php
    }
    ?>
});
function successAjaxFunction(data){
    var spacecategory_name,category_name,type_name,available_ids,limit;
    if(data.availability == 2){
        masterAlert(2,'','Not Availability');
    }else{
        for(var x=0;x<data.available_ids.length;x++){
            available_ids = data.available_ids[x];
            spacecategory_name = data.available_ids_category_name[x];
            category_name = data.available_ids_category[x];
            type_name = data.available_ids_type[x];
            limit = data.students_limit[x];
            if(limit !=0){
                var option = "<option value='"+available_ids+"' data-limit="+limit+">"+spacecategory_name+" - "+category_name+"  "+type_name+" - Students Limit = "+limit+"</option>";
                $("#space_id").append(option).val(null);
            }
        }
        $("#space_id").trigger('change'); 
    }
    var xxx = [];
    <?php
    if(count($assignedSpaces) !=0){
        foreach($assignedSpaces as $assignedSpace){
    ?>
        xxx.push("{{$assignedSpace->space_id}}");
    <?php
        }
        ?>
        $("#space_id").val(xxx).trigger('change'); 
        $('#space_id option:not(:selected)').attr('disabled', 'disabled').trigger('change');
        <?php
    }
    ?>
}
</script>
@endsection
