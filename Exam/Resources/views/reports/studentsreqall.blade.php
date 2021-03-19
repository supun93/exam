<?php $pageTitle = "Students List - Course Requirements"; ?>
@extends('exam::layouts.master')
@section('page_content')
<div class="container-fluid behind">
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
<form class="form-label-left input_mask needs-validation" method="post" action="#" id="generate1" novalidate>
@include ('slo::selectblades.batch')
<div class='row'>
<div class='col-md-3'>
<select class="form-control select3" name="main_req_input_id[]" id="main_req_input_id" required multiple="multiple">
    <option value="Title" >Title</option>
    <option value="Name with Initials" >Name with Initials</option>
    <option value="Full Name" >Full Name</option>
    <option value="NIC / Passport" >NIC / Passport</option>
    <option value="Mobile Number" >Mobile Number</option>
    <option value="Work Telephone" >Work Telephone</option>
    <option value="Resident Telephone" >Resident Telephone</option>
    <option value="Email" >Email</option>
    <option value="KIU Email" >KIU Email</option>
    <option value="KIU Register Date" >KIU Register Date</option>
    <option value="OLD ID" >OLD ID</option>
    <option value="Country" >Country</option>
    <option value="Province" >Province</option>
    <option value="District" >District</option>
    <option value="City" >City</option>
    <option value="Postal Code" >Postal Code</option>
    <option value="Address" >Address</option>

    <option value="Postal Country" >Postal Country</option>
    <option value="Postal Province" >Postal Province</option>
    <option value="Postal District" >Postal District</option>
    <option value="Postal City" >Postal City</option>
    <option value="Postal Address" >Postal Address</option>

</select>
</div>
<div class='col-md-3'>
<select class="form-control select3" name="general_req_inputf_id[]" id="general_req_inputf_id" required multiple="multiple">
    <?php
    $general_req =  Modules\Slo\Entities\Inputf::where("course_id" , "=" , 0)->get();
    ?>
    @foreach($general_req as $general_req)
    <option value="{{$general_req->fname}}" data-inputf='{{$general_req->fid}}'>{{$general_req->fname}}</option>
    @endforeach
</select>
</div>
<div class='col-md-3'>
<select class="form-control select3" name="course_req_inputf_id[]" id="course_req_inputf_id" required multiple="multiple">
</select>
</div>
<div class='col-md-2'>
<select class="form-control select3" name="groupes[]" id="groupes" required multiple="multiple">
<option value='Faculty'>Faculty</option>
<option value='Departments'>Department</option>
<option value='Courses'>Course</option>
<option value='Batches'>Batch</option>
<option value='Groupes'>Group</option>
</select>
</div>
<div class='col-md-1'>
<button class='btn btn-info btn-sm' type='submit'>GENERATE</button>
</div>
</div>
</form>
<div id="loadTable">

</div>
<div id="loadTableFull">

</div>
</div>
</div>
</div>
<input type='hidden' id='selection' value='1'>
<script>
$(document).ready(function () {
    

    $("#loadBut").hide();
    
    $("#main_req_input_id").select2({
        placeholder: "Select Main Req"
    });
    $("#general_req_inputf_id").select2({
        placeholder: "Select General Req"
    });
    $("#course_req_inputf_id").select2({
        placeholder: "Select Course Req"
    });
    $("#groupes").select2({
        placeholder: "Select Groupes"
    });
    $("#faculty_id").change(function(){
        $("#loadTableFull").html('');
        $("#course_req_inputf_id").html('');
    });
    $("#dept_id").change(function(){
        $("#loadTableFull").html('');
        $("#course_req_inputf_id").html('');
    });
    $("#course_id").change(function(){
        $("#loadTableFull").html('')
        $("#course_req_inputf_id").html('');
        var course_id = $('#course_id').val();
        if(course_id !='' && course_id !=null){
            $.ajax({
                type: 'GET',
                url: '/slo/filter/data/coursereqs/' + course_id
            }).then(function (data) {
                for(var i=0;i<=data.length;i++){
                    var val_id = data[i].id;
                    var val_text = data[i].text;
                    var option = new Option(val_text, val_text, true, true);
                    $("#course_req_inputf_id").append(option).val(null).trigger('change');
                }            
            });
        }else{
            $("#course_req_inputf_id").html('');
        }
    });
    $("#batch_id").change(function(){
        $("#loadTableFull").html('')
    });
    $("#generate1").submit(function(event){
    event.preventDefault(); //prevent default action
    $("#loadTableFull").html('')
    if(selectValid()[0] != 'batch' && selectValid()[0] != 'course' ){
        toastr.error("Select Batch or Course");
        return;
    }   
    
    var form_data = new FormData(this); //Creates new FormData object
    $.ajax({
      type:'POST',
      url:"{{ route('report-fields.gen') }}",
      data : form_data,
      contentType: false,
      cache: false,
      processData:false,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      beforeSend: function() {
        loadSpin.toggle();
      },
      success:function(data){
        if(selectValid()[0] == 'batch'){ var batch_id = selectValid()[1]; }else{ var batch_id = ''}
        var url1 = "{{route('report-fields-table.gen')}}?lastUrl=finalreportstudentslist&batch_id="+batch_id+"&";
        var mainurl = '';
        var c = 0;
        for(var x=0;x<data.main.length;x++){
            c++;
            mainurl = mainurl + 'field_'+[c] + '=' + data.main[x] + '&';
        }
        for(var x=0;x<data.gen.length;x++){
            c++;
            mainurl = mainurl + 'field_'+[c] + '=' + data.gen[x] + '&';
        }
        for(var x=0;x<data.course.length;x++){
            c++;
            mainurl = mainurl + 'field_'+[c] + '=' + data.course[x] + '&';
        }
        for(var x=0;x<data.groupes.length;x++){
            c++;
            mainurl = mainurl + 'field_'+[c] + '=' + data.groupes[x] + '&';
        }
        $("#loadTable").load(url1+mainurl, function() {
            loadSpin.toggle();
        });
        
      },
        error: function(xhr, status, error) 
            {
                loadSpin.toggle();
                masterAlert(2,'',error);
            }
      });
  });
    
});
</script>

@endsection
