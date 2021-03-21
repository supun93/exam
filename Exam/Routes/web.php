<?php
Route::middleware(["auth.admin:admin", "admin.permissions:admin"])->group(function() {
Route::prefix('exams')->group(function() {
    Route::get('/', 'ExamController@index');
    Route::get('grade-groupes/list', 'GradegroupesController@index')->name('grade-groupes.list');
    Route::get('grade-groupes/create', 'GradegroupesController@create')->name('grade-groupes.create');
    Route::get('grade-groupes/create/{id}', 'GradegroupesController@show');
    Route::post('grade-groupes/store', 'GradegroupesController@store')->name('grade-groupes.store');
    Route::get('grade-groupes/trash', 'GradegroupesController@trash')->name('grade-groupes.trash');
    Route::get('grade-groupes/trash-list', 'GradegroupesController@trashList')->name('grade-groupes.trashlist');

    Route::get('grades/list', 'GradesController@index')->name('grades.list');
    Route::get('grades/create', 'GradesController@create')->name('grades.create');
    Route::get('grades/create/{id}', 'GradesController@show');
    Route::post('grades/store', 'GradesController@store')->name('grades.store');
    Route::get('grades/trash', 'GradesController@trash')->name('grades.trash');
    Route::get('grades/trash-list', 'GradesController@trashList')->name('grades.trashlist');
    
    Route::get('exam-type/list', 'ExamtypesController@index')->name('exam-type.list');
    Route::get('exam-type/create', 'ExamtypesController@create')->name('exam-type.create');
    Route::get('exam-type/create/{id}', 'ExamtypesController@show');
    Route::post('exam-type/store', 'ExamtypesController@store')->name('exam-type.store');
    Route::get('exam-type/trash', 'ExamtypesController@trash')->name('exam-type.trash');
    Route::get('exam-type/trash-list', 'ExamtypesController@trashList')->name('exam-type.trashlist');

    Route::get('exam-categories/list', 'ExamCategoryController@index')->name('exam-categories.list');
    Route::get('exam-categories/create', 'ExamCategoryController@create')->name('exam-categories.create');
    Route::get('exam-categories/create/{id}', 'ExamCategoryController@show');
    Route::post('exam-categories/store', 'ExamCategoryController@store')->name('exam-categories.store');
    Route::get('exam-categories/trash', 'ExamCategoryController@trash')->name('exam-categories.trash');
    Route::get('exam-categories/trash-list', 'ExamCategoryController@trashList')->name('exam-categories.trashlist');

    Route::get('timetable', 'LoadDataController@timetable')->name('exam.timetable');
    Route::get('timetable/exam/setup/menu/{id}', 'LoadDataController@setpumenu')->name('exam-timetable.setup');
    Route::get('exam-group/list/{id}', 'ExamgroupesController@index')->name('exam-group.list');
    Route::get('exam-group/create/{id}', 'ExamgroupesController@create')->name('exam-group.create');
    Route::get('exam-group/show/{groupid}/{id}', 'ExamgroupesController@show')->name('exam-group.show');
    Route::post('exam-group/store', 'ExamgroupesController@store')->name('exam-group.store');
    Route::get('exam-group/trash', 'ExamgroupesController@trash')->name('exam-group.trash');
    Route::get('exam-group/trash-list/{id}', 'ExamgroupesController@trashList')->name('exam-group.trashlist');
    Route::get('assign/invigilator/exam/{id}', 'AssignController@assignLecturesForExam')->name('assign.invigilator');
    Route::post('assign/invigilator/exam/save', 'AssignController@assignLecturesForExamStore')->name('assign.invigilator-assign');
    Route::post('assign/invigilator/exam/remove', 'AssignController@assignLecturesForExamRemove')->name('assign.invigilator-remove');

    Route::get('exam/rates/form', 'ExamController@examRatesForm')->name('exam-rates.form');
    Route::post('exam/rates/update', 'ExamController@examRatesUpdate')->name('exam-rates.update');

    Route::get('exam/spaces/list/{id}', 'ExamController@spacesList')->name('exam-spaces.list');
    Route::post('exam/spaces/availability/check', 'ExamController@availabilityCheck')->name('exam-spaces.availability-check');

    Route::get('reports/students/list/requirements/all', 'ReportsController@studentsListReqAll')->name('exam-reports-students.req-all');
    Route::get('data/gen/table/filter/final/results/{action}', 'ReportsController@finalRes')->name('report-full-custom.list');
    
    Route::get('assign/students/exam-groupes/{id}', 'AssignController@assignStudentsExamGroupes')->name('students-assign.exam-group');
    Route::post('assign/students/exam-groupes/list', 'AssignController@assignStudentsExamGroupesList')->name('students-exam-group.list');
    Route::get('assign/subgroups/students/{action}', 'AssignController@studentsAssignList')->name('students-assign.list');
    Route::post('assign/students/exam-groupes/assign', 'AssignController@assignStudentsExamGroupesAssign')->name('students-exam-group.assign');
    Route::get('assign/students/exam-groupes/manual/{id}', 'AssignController@assignStudentsExamGroupesManual')->name('students-assign-exam-group.manual');
    Route::post('assign/students/exam-groupes/list/manual', 'AssignController@assignStudentsExamGroupesListManual')->name('students-exam-group-manual.list');
    Route::get('assign/subgroups/students/manual/{action}', 'AssignController@studentsAssignListManual')->name('students-assign-manual.list');
    Route::post('assign/students/exam-groupes/assign/manual', 'AssignController@assignStudentsExamGroupesAssignManual')->name('students-exam-group-manual.assign');

    Route::prefix('filter')->group(function() {
        Route::get('data/{type}/{id}', 'LoadDataController@filterData')->name('filter-selects.tags');
    });
    

});
});