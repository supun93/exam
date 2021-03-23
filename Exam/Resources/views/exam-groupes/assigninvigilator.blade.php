<?php 
$pageTitle = "Assign invigilator to Exam Groupes";
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
                        <div class="col-sm-9">
                            <h4 class="header-title">{{$pageTitle}} - {{$subgroupes->moduleName->module_code}} {{$subgroupes->moduleName->module_name}} - {{$subgroupes->tt_date}} - [{{$subgroupes->start_time}} to {{$subgroupes->end_time}}]</h4>
                        </div>
                        <div class="col-sm-3">
                            <div class="float-right">
                            <a href="{{route('exam-timetable.setup',$id)}}" class="btn btn-info"><span class="fa fa-list"></span> Setup Menu</a>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                Student: {{$studentsCount}} <br/>
                Exam Category : {{$subgroupes->examCategory->exam_category}}<br/>
                Invigilator Ratio : {{$subgroupes->examCategory->student_count}} : {{$subgroupes->examCategory->invigilator_ratio}}<br/>
                Maximum Invigilator : {{$invigilator + 1}}
                </div>
                </div>
                <div class='row'> <!-- sart row-->
                <div class='card col-md-6'> <!-- sart card-->
                <div class="card-header">Full Invigilator List</div>
                <div class="card-body"> <!-- sart card body-->
                <input type="hidden" name="info_id" id="info_id" value="{{$id ?? ''}}">
                    <table id="table2" class="table table-striped table-bordered dt-responsive nowrap">
                    <thead class="">
                    <tr>
                    <th>Full Name</th>
                    <th>Status</th>
                    <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $name)
                    <?php 
                    if($name->employee_id == null){
                        $check = Modules\Exam\Entities\InvigilatorForExam::where('academic_timetable_information_id',$id)
                                                                            ->where('from_table_name','lecturers')
                                                                            ->where('invigilator_id',$name->id)->get()->count();
                        if($check != 0){
                           ?> @continue <?php
                        }
                    }else{
                        $check = Modules\Exam\Entities\InvigilatorForExam::where('academic_timetable_information_id',$id)
                                                                            ->where('from_table_name','employees')
                                                                            ->where('invigilator_id',$name->id)->get()->count();
                        if($check != 0){
                           ?> @continue <?php
                        }
                    }
                    ?>
                    <tr>
                    <td>{{$name->name}}
                    @if($name->employee_id == null)
                    <input type='hidden' name='id' class='id' value='{{$name->id}}'> <input type='hidden' name='table' class='table' value='lecturers'>
                    @else
                    <input type='hidden' name='id' class='id' value='{{$name->id}}'> <input type='hidden' name='table' class='table' value='employees'>
                    @endif
                    <input type='hidden' name='info_id' class='info_id' value='{{$id}}'>
                    </td>
                    <td>
                    @if($name->employee_id == null)
                        Visiting
                    @else
                        Internal
                    @endif
                    </td>
                    <td>
                    <?php
                        $count = Modules\Exam\Entities\InvigilatorForExam::where('academic_timetable_information_id',$id)->get()->count();
                    ?>
                    @if($count < $invigilator + 1)
                    <button class='btn btn-success btn-sm assignBut'>Assign</button>
                    @else
                    <button class='btn btn-success btn-sm assignBut' disabled>Assign</button>
                    @endif
                    </td>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>
            </div> <!-- end  card body-->
        </div> <!-- end card-->
        <div class='card col-md-6'> <!-- sart card-->
        <div class="card-header">Assigned Invigilator List</div>
        <div class="card-body"> <!-- sart card body-->
                <input type="hidden" name="info_id" id="info_id" value="{{$id ?? ''}}">
                    <table id="table3" class="table table-striped table-bordered dt-responsive nowrap">
                    <thead class="">
                    <tr>
                    <th>Full Name</th>
                    <th>Action</th>
                    <th>Supervisor</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $name)
                    <?php 
                    if($name->employee_id == null){
                        $check = Modules\Exam\Entities\InvigilatorForExam::where('academic_timetable_information_id',$id)
                                                                            ->where('from_table_name','lecturers')->where('invigilator_id',$name->id)->get()->count();
                        $row_id = Modules\Exam\Entities\InvigilatorForExam::where('academic_timetable_information_id',$id)->where('from_table_name','lecturers') 
                                                                          ->where('invigilator_id',$name->id)->first();
                        if($check == 0){
                           ?> @continue <?php
                        }
                    }else{
                        $check = Modules\Exam\Entities\InvigilatorForExam::where('academic_timetable_information_id',$id)
                                                                            ->where('from_table_name','employees')->where('invigilator_id',$name->id)->get()->count();
                        $row_id = Modules\Exam\Entities\InvigilatorForExam::where('academic_timetable_information_id',$id)->where('from_table_name','employees') 
                                                                          ->where('invigilator_id',$name->id)->first();
                        if($check == 0){
                           ?> @continue <?php
                        }
                    }
                    ?>
                    <tr>
                    <td>{{$name->name}}
                    @if($name->employee_id == null)
                    <input type='hidden' name='id' class='id' value='{{$name->id}}'> <input type='hidden' name='table' class='table' value='lecturers'>
                    @else
                    <input type='hidden' name='id' class='id' value='{{$name->id}}'> <input type='hidden' name='table' class='table' value='employees'>
                    @endif 
                    <input type='hidden' name='info_id' class='info_id' value='{{$id}}'>
                    <input type='hidden' name='row_id' class='row_id' value='{{$row_id->row_id}}'>
                    </td>
                    <td><button class='btn btn-danger btn-sm removeBut'>Remove</button></td>
                    <?php
                        $count = Modules\Exam\Entities\InvigilatorForExam::where('academic_timetable_information_id',$id)->whereSupervisor(1)->get()->count();
                        $sup = Modules\Exam\Entities\InvigilatorForExam::where('academic_timetable_information_id',$id)->whereSupervisor(1)->where('invigilator_id',$name->id)->get()->count();
                    ?>
                    <td>
                    @if($sup == 1)
                    <button class='btn btn-success' disabled>Selected As Supervisor</button>
                    @elseif($count < 2)
                    <button class='btn btn-info setSupervisorBut'>Set As Supervisor</button>
                    @endif
                    </td>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>
            </div> <!-- end  card body-->
        </div> <!-- end card-->
        </div> <!-- end row-->
    </div>
</div>
<script>
$(document).ready(function () {
    //////////////// set as supervisor ///////////////
    $(".setSupervisorBut").click(function(){
        var row = $(this).closest("tr"),       // Finds the closest row <tr> 
                tds = row.find("td");
                id = tds.find(".id").val();
                table = tds.find(".table").val();
                info_id = tds.find(".info_id").val();
                row_id = tds.find(".row_id").val();
                var form_data = new FormData(); //Creates new FormData object
        form_data.append( 'table', table );
        form_data.append( 'id', id );
        form_data.append( 'info_id', info_id );
        form_data.append( 'row_id', row_id );
        sendPostAjaxWithConfirm("{{route('assign.invigilator-supervisor')}}",form_data,'set');
    });
    //////////////// remove //////////////////////
    $(".removeBut").click(function(){
        var row = $(this).closest("tr"),       // Finds the closest row <tr> 
                tds = row.find("td");
                id = tds.find(".id").val();
                table = tds.find(".table").val();
                info_id = tds.find(".info_id").val();
                row_id = tds.find(".row_id").val();
        var form_data = new FormData(); //Creates new FormData object
        form_data.append( 'table', table );
        form_data.append( 'id', id );
        form_data.append( 'info_id', info_id );
        form_data.append( 'row_id', row_id );
        sendPostAjaxWithConfirm("{{route('assign.invigilator-remove')}}",form_data,'remove');
    });
    $(".assignBut").click(function(){
        var row = $(this).closest("tr"),       // Finds the closest row <tr> 
                tds = row.find("td");
                id = tds.find(".id").val();
                table = tds.find(".table").val();
                info_id = tds.find(".info_id").val();
        var form_data = new FormData(); //Creates new FormData object
        form_data.append( 'table', table );
        form_data.append( 'id', id );
        form_data.append( 'info_id', info_id );
        sendPostAjaxWithConfirm("{{route('assign.invigilator-assign')}}",form_data,'assign');
    });
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
    
});
</script>
@endsection
