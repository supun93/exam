<div class="card">
<div class="card-body">
<form action='' method='' id='assign_but'>
<table id="table" class="table table-striped table-bordered dt-responsive nowrap">
    <thead class="thead">
    <tr>
    <th></th>
    <th>ID</th>
    <th>Student Name</th>
    <th>Special Note</th>
    <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php $x=0; ?>
    @foreach($students as $list)
    
    <?php
    $check = Modules\Exam\Entities\ExamgroupsStudents::where('student_id','=',$list->student->range_id)->where('exam_group_id','=',$exam_group_id)->get()->count();
    if($check != 0){
       ?> @continue <?php 
    }
    $check = Modules\Exam\Entities\ExamgroupsStudents::where('academic_timetable_information_id','=',$info_id)->where('exam_group_id','=',$exam_group_id)->where('student_id','=',0)->get();
    ?>
    @foreach($check as $check)
    <?php
        $sg_id = $check->subgroup_id;
        $check2 = Modules\Exam\Entities\Subgroupesstd::where('sg_id','=',$sg_id)->where('std_id','=',$list->student->range_id)->get()->count();
    ?>
    @if($check2 == 1)
    <?php continue 2; ?>
    @endif  
    @endforeach
    <tr>
    <td>
    <input type="hidden" name="student[]" value="{{$list->student->range_id}}">
    <input type="checkbox" name="select_{{$x}}" class="form-control myDropdown">
    </td>
    <td>
    {{$list->student->gen_id}}
    </td>
    <td>{{$list->student->full_name}}</td>
    <td>
    <textarea class="form-control" name="sp_note_{{$x}}" style='height:40px !important' placeholder="Special Note"></textarea>
    </td>
    <td>
    <?php
    $info = Modules\Exam\Entities\AcademicTimeTableInformation::with(['moduleName' => function($b){
        $b->with(['course:course_id'])->get();
    }])->find($info_id);
    $model = new Modules\Slo\Entities\Student;
    $data = $model->getStudentStatus($list->student->range_id,$info->moduleName->course->course_id);
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
    <?php $x++; ?>
    @endforeach
    </tbody>
</table>
<input type='hidden' name='exam_group_id' value='{{$exam_group_id}}'>
<input type="hidden" name="info_id" id="info_id" value="{{$info_id}}">
<center><button class="btn btn-primary input-group-append" id="" type='submit'>Assign</button></center>
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
    sendPostAjax("{{route('students-exam-group-manual.assign')}}",form_data,'');
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