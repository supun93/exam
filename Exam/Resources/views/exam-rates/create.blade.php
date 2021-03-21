<?php 
$pageTitle = "Change Exam Rates";
$nav_slo = "active" ?>
@extends('exam::layouts.master')
@section('page_content')
<?php
$pgName = "examRates"
?>
<div class="container-fluid behind">
<form class="form-label-left input_mask needs-validation" method="post" action="" id="save{{$pgName}}" novalidate>
    @csrf
    <input type="hidden" name="id" id="id" value="{{$examRates->exam_rate_id ?? ''}}">
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
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="grade_group_name">Paper Marking Amount</label>
                                <input placeholder='Exam Category Name' type="number" class="form-control" name="paper_marking_amount" id="paper_marking_amount" required value='{{$examRates->paper_marking_amount ?? ""}}'>
                            </div>
                            <div class="form-group">
                                <label for="grade_group_name">Paper Preparation Amount</label>
                                <input placeholder='Student Count' type="number" class="form-control" name="paper_preparation_amount" id="paper_preparation_amount" required='true' value='{{$examRates->paper_preparation_amount ?? ""}}'>
                            </div>
                            <div class="form-group">
                                <label for="grade_group_name">Paper Typing Amount</label>
                                <input placeholder='Invigilator Ratio' type="number" class="form-control" name="paper_typing_amount" id="paper_typing_amount" required='true' value='{{$examRates->paper_typing_amount ?? ""}}'>
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
    var reqlength = $('[required="true"]').length;
    var value = $('[required="true"]').filter(function () {
        return this.value != '';
    });
    if (value.length>=0 && (value.length !== reqlength)) {
        masterAlert(2,'','Please make sure all required fields are filled out correctly');
        return;
    }
    var form_data = new FormData(this); //Creates new FormData object
    sendPostAjax("{{route('exam-rates.update')}}",form_data);
  });
});
</script>
@endsection
