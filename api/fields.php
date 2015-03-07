<?php

$fields_arr = [
    'name',
    'fatherName',
    'motherName',
    'roll',
    'email',
    'dob',
    'gender',
    'religion',
    'medium',
    'village',
    'post',
    'upozilla',
    'district',
    'mobile',
    'trade',
    'nationality',
    'jscBoard',
    'jscYear',
    'jscRoll',
    'jscResult',
    'sscBoard',
    'sscYear',
    'sscRoll',
    'sscResult',
    'description',
    'picture'
];

$fields_str = implode(',', $fields_arr);
//echo "---" . $fields_str . '---';


//$fields_arr = require 'fields.php';
   $fields_val  = ":" . implode(',:', $fields_arr);
//echo "---" . $fields_val . '---';
   
$fields_update = implode(',', array_map("updateCB", $fields_arr));
//echo "---" . $fields_update . '---';
function updateCB($f) {
    return   $f . '=:' . $f;
}

//function updateCB2($f) {
//    return '`' . $f . '` varchar(45) DEFAULT NULL';
//}

//$fields_sql = implode(',\r\n', array_map("updateCB2", $fields_arr));
//echo "<br>" . $fields_sql ;

//function updateCB2($f) {
//    return '' . $f . ':""';
//}
//
//$fields_sql = implode(',<br >', array_map("updateCB2", $fields_arr));
//echo "<br>" . $fields_sql ;
