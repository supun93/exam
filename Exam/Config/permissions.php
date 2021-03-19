<?php
$groups = [];

$permGroup = [];
$permGroup["name"] = "Exam Type Manager";
$permGroup["slug"] = "exam_type";
$permGroup["permissions"][]=["action"=>"/exam/exam_type", "name"=>"List Exam Types"];
$permGroup["permissions"][]=["action"=>"/exam/exam_type/trash", "name"=>"List Exam Types in Trash"];
$permGroup["permissions"][]=["action"=>"/exam/exam_type/create", "name"=>"Add New Exam Type"];
$permGroup["permissions"][]=["action"=>"/exam/exam_type/edit", "name"=>"Edit Exam Type"];
$permGroup["permissions"][]=["action"=>"/exam/exam_type/view", "name"=>"View Exam Type"];
$permGroup["permissions"][]=["action"=>"/exam/exam_type/activate", "name"=>"Activate Exam Type"];
$permGroup["permissions"][]=["action"=>"/exam/exam_type/deactivate", "name"=>"Deactivate Exam Type"];
$permGroup["permissions"][]=["action"=>"/exam/exam_type/delete", "name"=>"Move To Exam Types Trash"];
$permGroup["permissions"][]=["action"=>"/exam/exam_type/restore", "name"=>"Restore From Exam Types Trash"];
$permGroup["permissions"][]=["action"=>"/exam/exam_type/change_status", "name"=>"Change Status Of Exam Types"];

$groups[]=$permGroup;

$permGroup = [];
$permGroup["name"] = "Exam Category Manager";
$permGroup["slug"] = "exam_category";
$permGroup["permissions"][]=["action"=>"/exam/exam_category", "name"=>"List Exam Categories"];
$permGroup["permissions"][]=["action"=>"/exam/exam_category/trash", "name"=>"List Exam Categories in Trash"];
$permGroup["permissions"][]=["action"=>"/exam/exam_category/create", "name"=>"Add New Exam Category"];
$permGroup["permissions"][]=["action"=>"/exam/exam_category/edit", "name"=>"Edit Exam Category"];
$permGroup["permissions"][]=["action"=>"/exam/exam_category/view", "name"=>"View Exam Category"];
$permGroup["permissions"][]=["action"=>"/exam/exam_category/activate", "name"=>"Activate Exam Category"];
$permGroup["permissions"][]=["action"=>"/exam/exam_category/deactivate", "name"=>"Deactivate Exam Category"];
$permGroup["permissions"][]=["action"=>"/exam/exam_category/delete", "name"=>"Move To Exam Categories Trash"];
$permGroup["permissions"][]=["action"=>"/exam/exam_category/restore", "name"=>"Restore From Exam Categories Trash"];
$permGroup["permissions"][]=["action"=>"/exam/exam_category/change_status", "name"=>"Change Status Of Exam Categories"];

$groups[]=$permGroup;

return [
    "slug" => "exam",
    "name" => "Exam Operations Manager",
    "groups" => $groups
];

