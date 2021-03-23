<div class="card">
<div class="card-body">
<table id="table" class="table table-striped table-bordered dt-responsive nowrap">
    <thead class="thead">
    <tr>
    <th>ID</th>
    <th>Student Name</th>
    <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($students as $list)
    <tr>
    <td>{{$list->gen_id}}</td>
    <td>{{$list->full_name}}</td>
    <td>
    <?php
    $info = Modules\Exam\Entities\AcademicTimeTableInformation::with(['moduleName' => function($b){
        $b->with(['course:course_id'])->get();
    }])->find($info_id);
    $model = new Modules\Slo\Entities\Student;
    $data = $model->getStudentStatus($list->range_id,$info->moduleName->course->course_id);
    $status = $data->batchStudent->student_status;
    ?>
    @if($status == 0)
    <b style="color: green">Active</b> 
    @elseif($status == 1)
    <b style="color: red">Inactive</b> 
    @elseif($status == 2)
    <b style="color: red">Temporary Drop</b> 
    @elseif($status == 3)
    <b style="color: red">Permenant Suspend</b> 
    @elseif($status == 4)
    <b style="color: red">Temporary Suspend</b> 
    @elseif($status == 5)
    <b style="color: green">Completed</b> 
    @endif
    </td>
    </tr>
    @endforeach
    </tbody>
</table>
<form action='' method='' id='assign_but'>
<?php  $i=0; ?>
@foreach($sg as $sg)
<?php
$check = Modules\Exam\Entities\ExamgroupsStudents::where('subgroup_id','=',$sg)->where('exam_group_id','=',$exam_group_id)->get()->count();
if($check !=0){
?> @continue <?php
}
$i++;
?>
<input type='hidden' name='sg[]' value='{{$sg}}'>
<input type='hidden' name='exam_group_id' value='{{$exam_group_id}}'>
<input type="hidden" name="info_id" id="info_id" value="{{$info_id}}">
@endforeach
@if($i != 0)
<center><button class="btn btn-primary input-group-append" id="" type='submit'>Assign</button></center>
@else
<center><button class="btn btn-primary input-group-append" disabled type='submit'>Allready assigned</button></center>
@endif
</form>
</div>
</div>
<script>
$(document).ready(function () {   
///////////////// Add Batch Types /////
$("#assign_but").submit(function(event){
    event.preventDefault(); //prevent default action 
    var exam_group_id = $("#exam_group_id").val();
    if(exam_group_id == ''){
        return;
    }
    var form_data = new FormData(this); //Creates new FormData object
    sendPostAjax("{{route('students-exam-group.assign')}}",form_data,'');
    loadSpin.toggle();
  });
});
    
$('#table').DataTable({
    "oLanguage": {
    "sEmptyTable": "",
    "sInfoEmpty": "",
    },
    
    "pagingType": "full_numbers",
    "responsive": true,
    "paging": true,
    "searching": true,
    "ordering": true,

    "columnDefs": [{
        //"targets": 2,
        "orderTable": false
    }],
});
</script>