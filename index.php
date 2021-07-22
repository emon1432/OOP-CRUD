<?php

include 'SQL_query_oop.php';

$obj = new Database();

$obj->insert('sec_a',['Name'=>'emon','Gender'=>'1','Phone_Number'=>'01638849306','Blood_group'=>'5']);

// echo "Insert result : ";
// echo "<pre>";
// print_r($obj->getResult());
// echo "</pre>";

?>