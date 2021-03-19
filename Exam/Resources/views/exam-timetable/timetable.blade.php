<?php
$pageTitle = "Exam Timetable";
$nav_slo = "active" ?>
@extends('exam::layouts.master')
@section('page_content')
    <form action="javascript:;" id="create_form">
        @csrf
        <input type='hidden' id='selection' value='1'>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row m-0">
                            <div class="col-sm-12">
                                <h4 class="header-title">{{$pageTitle}}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Faculty</label>
                                    <hr class="mt-1 mb-2">
                                    <input type="text" class="form-control" name="faculty_id" placeholder="Select Faculty">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Department</label>
                                    <hr class="mt-1 mb-2">
                                    <input type="text" class="form-control" name="dept_id" placeholder="Select Department">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Course</label>
                                    <hr class="mt-1 mb-2">
                                    <input type="text" class="form-control" name="course_id" placeholder="Select Course">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Select Academic Year</label>
                                    <hr class="mt-1 mb-2">
                                    <input type="text" class="form-control" name="academic_year_id" placeholder="Select Academic Year">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Select Semester</label>
                                    <hr class="mt-1 mb-2">
                                    <input type="text" class="form-control" name="semester_id" placeholder="Select Semester">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Select Batch</label>
                                    <hr class="mt-1 mb-2">
                                    <input type="text" class="form-control" name="batch_id" placeholder="Select Batch">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Select Group</label>
                                    <hr class="mt-1 mb-2">
                                    <input type="text" class="form-control" name="group_id" placeholder="Select Group">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Select Delivery Mode</label>
                                    <hr class="mt-1 mb-2">
                                    <input type="text" class="form-control" name="delivery_mode_id" placeholder="Select Delivery Mode">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Select Subject Group</label>
                                    <hr class="mt-1 mb-2">
                                    <input type="text" class="form-control" name="subgroup_id" placeholder="Select Subject Group">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date From</label>
                                            <hr class="mt-1 mb-2">
                                            <input type="text" class="form-control date-picker" name="date_from" value="{{date("Y-m-d", time())}}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date Till</label>
                                            <hr class="mt-1 mb-2">
                                            <input type="text" class="form-control date-picker" name="date_till" value="{{date("Y-m-d", strtotime("+90 day"))}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6 align-items-center d-flex justify-content-center">
                                <div class="form-group display-flex justify-content-center">
                                    <button type="submit" class="btn btn-success btn-add-row">Filter Timetable</button>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="timetable_type" value="academic">
        <input type="hidden" name="exam_only" value="no">
        <input type="hidden" name="with_attendance" value="yes">
    </form>

    <div id="timetable-form">
        <main-component ref="comp"></main-component>
    </div>




    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            ...ssss
            </div>
        </div>
    </div>



    <?php
    $ttButtons = [];
    $ttButton = [];
    $ttButton["class"]="btn btn-sm btn-success";
    $ttButton["iconClass"]="fa fa-marker";
    $ttButton["label"]="Create Exam Group";
    $ttButton["callBack"]="loadAttendancePage";

    $ttButtons[]=$ttButton;

    $viewData = [];
    $viewData["timetable"] = $record["timetable"];
    $viewData["buttons"] = $ttButtons;
    ?>
    <script src="/academic/js/academic.js"></script>
    <script>
        let faculty_id_ms=null;
        let dept_id_ms=null;
        let dept_id_ms_init=false;
        let course_id_ms=null;
        let course_id_ms_init=false;
        let academic_year_id_ms=null;
        let semester_id_ms=null;
        let batch_id_ms=null;
        let batch_id_ms_init=false;
        let group_id_ms=null;
        let group_id_ms_init=false;
        let subgroup_id_ms=null;
        let subgroup_id_ms_init=false;
        let delivery_mode_id_ms=null;
        let delivery_mode_id_ms_init=false;

        let wd_ms=null;
        let data = <?php echo json_encode($viewData); ?>;
        let vueApp = new Vue({
            components:{"main-component":Timetable}
        }).$mount('#timetable-form');

        $(document).ready(function () {

            pushData(data);
        })

        function pushData(data)
        {
            vueApp.$refs.comp.pushData(data)
        }

        $(document).ready(function () {
            submitCreateForm();

            $(".date-picker").datepicker({
                format	: "yyyy-mm-dd",
                orientation: 'top'
            });

            faculty_id_ms = $("input[name='faculty_id']").magicSuggest({
                allowFreeEntries: false,
                maxSelection:1,
                data: "/academic/faculty/search_data",
                dataUrlParams:{"_token":"{{ csrf_token() }}"},
            });

            dept_id_ms = $("input[name='dept_id']").magicSuggest({
                allowFreeEntries: false,
                maxSelection:1,
                data: "/academic/department/search_data",
                dataUrlParams:{"_token":"{{ csrf_token() }}"},
            });

            course_id_ms = $("input[name='course_id']").magicSuggest({
                allowFreeEntries: false,
                maxSelection:1,
                data: "/academic/course/search_data",
                dataUrlParams:{"_token":"{{ csrf_token() }}"},
            });

            academic_year_id_ms = $("input[name='academic_year_id']").magicSuggest({
                allowFreeEntries: false,
                maxSelection:1,
                data: "/academic/academic_year/search_data",
                dataUrlParams:{"_token":"{{ csrf_token() }}"},
            });

            semester_id_ms = $("input[name='semester_id']").magicSuggest({
                allowFreeEntries: false,
                maxSelection:1,
                data: "/academic/academic_semester/search_data",
                dataUrlParams:{"_token":"{{ csrf_token() }}"},
            });

            batch_id_ms = $("input[name='batch_id']").magicSuggest({
                allowFreeEntries: false,
                maxSelection:1,
                data: "/academic/batch/search_data",
                dataUrlParams:{"_token":"{{ csrf_token() }}"},
            });

            group_id_ms = $("input[name='group_id']").magicSuggest({
                allowFreeEntries: false,
                maxSelection:1,
                data: "/academic/group/search_data",
                dataUrlParams:{"_token":"{{ csrf_token() }}"},
            });

            delivery_mode_id_ms = $("input[name='delivery_mode_id']").magicSuggest({
                allowFreeEntries: false,
                maxSelection:1,
                data: "/academic/module_delivery_mode/search_data",
                dataUrlParams:{"_token":"{{ csrf_token() }}"},
            });

            subgroup_id_ms = $("input[name='subgroup_id']").magicSuggest({
                allowFreeEntries: false,
                maxSelection:1,
                data: "/academic/subgroup/search_data",
                dataUrlParams:{"_token":"{{ csrf_token() }}"},
            });
        });

        function submitCreateForm()
        {
            $('#create_form').ajaxForm({
                url			: "/academic/academic_timetable/filter_timetables",
                type		: "POST",
                dataType	: "json",
                beforeSubmit: validateForm,
                success		: serverResponse,
                error		: onError
            });
        }

        function validateForm()
        {
            //show preloader
            showPreloader($('#create_form'), true);

            //disable form submit
            $('#create_form button[type="submit"]').attr("disabled", "disabled");

            return true;
        }

        function serverResponse(responseText)
        {
            //Hide preloader
            hidePreloader($('#create_form'));
            $('#create_form button[type="submit"]').removeAttr("disabled");

            if(responseText.notify.status && responseText.notify.status === "success")
            {
                if(responseText.data)
                {
                    pushData(responseText.data);
                    $("#timetable-form").fadeIn(300);
                }
            }
            else
            {
                showNotifications(responseText.notify)
            }
        }

        function onError()
        {
            //Hide preloader
            hidePreloader($("#create_form"));
            $('#create_form button[type="submit"]').removeAttr("disabled");

            let errorText=[];
            let errorData=[];

            errorText.push('Something went wrong. Please try again.');

            errorData.status="warning";
            errorData.notify=errorText;

            showNotifications(errorData)
        }

        function loadAttendancePage(slot)
        {
            let slotId = slot.id;

            window.location.href = "{{ route('exam-timetable.setup','') }}/"+slotId;
            //$(".bd-example-modal-lg").modal('toggle');
        }
    </script>
@endsection
