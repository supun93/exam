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
                Maximum Invigilator : {{$invigilator}}
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
                    <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $name)
                    <tr>
                    <td>{{$name->name}}</td>
                    <td><button class='btn btn-success btn-sm'>Assign</button></td>
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
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $name)
                    <tr>
                    <td>{{$name->name}}</td>
                    <td><button class='btn btn-danger btn-sm'>Remove</button></td>
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
function aa(){
    
}
$(document).ready(function () {
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
    $("#type").select2({ width: '200px' });
    $("#type").change(function(){
        if($(this).val() == 0){
            $('.postName').select2({
                minimumInputLength : 3,
                placeholder: 'Student ID / NIC / OLD ID / Email / Full Name / Mobile Number / KIU Email',
                ajax: {
                    type: "POST",
                    dataType: 'json',
                    url: "{{route('students.searching')}}",		// jsfiddle simulate ajax
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    delay: 250,
                    processResults: function (data) {
                    return {
                        results: data
                    };
                    },
                    data: function (data) {
                        return {
                            searchTerm: data.term, // search term
                            type: $("#type").val()
                        };
                    }     
                }
            });
        }else{
            $('.postName').select2({
                minimumInputLength : 3,
                placeholder: "Type here...",
                ajax: {
                    type: "POST",
                    dataType: 'json',
                    url: "{{route('students.searching')}}",		// jsfiddle simulate ajax
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    delay: 250,
                    processResults: function (data) {
                    return {
                        results: data
                    };
                    },
                    data: function (data) {
                        return {
                            searchTerm: data.term, // search term
                            type: $("#type").val()
                        };
                    }     
                }
            });
        }
    }); 
    $('.postName').select2({
        minimumInputLength : 3,
        placeholder: 'Student ID / NIC / OLD ID / Email / Full Name / Mobile Number / KIU Email',
        ajax: {
            type: "POST",
            dataType: 'json',
            url: "{{route('students.searching')}}",		// jsfiddle simulate ajax
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            delay: 250,
            processResults: function (data) {
            return {
                results: data
            };
            },
            data: function (data) {
                return {
                    searchTerm: data.term, // search term
                    type: $("#type").val()
                };
            }     
        }
    });
    $('.postName').on('select2:select', function (e) {
        var stId = $(this).val();
        var data = {stId:stId,'X-CSRF-Token':$('meta[name="csrf-token"]').attr('content')};
        $.post("{{ route('students.profile') }}", function (data) {
            var w = window.open('about:blank');
            w.document.open();
            w.document.write(data);
            w.document.close();
        });
    });
});
</script>
@endsection
