<?php

include 'SQL_query_oop.php';

$obj = new Database();

// $obj->insert('sec_a',['Name'=>'emon','Gender'=>'1','Phone_Number'=>'01638849306','Blood_group'=>'5']);
// echo "Insert result : ";
// echo "<pre>";
// print_r($obj->getResult());
// echo "</pre>";


// $obj->update('sec_a',['Name'=>'Adhora','Gender'=>'2','Phone_Number'=>'01638849306','Blood_group'=>'3'], 'Roll="18056"');
// echo "Update result : ";
// echo "<pre>";
// print_r($obj->getResult());
// echo "</pre>";


// $obj->delete('sec_a','Roll="18056"');
// echo "Delete result : ";
// echo "<pre>";
// print_r($obj->getResult());
// echo "</pre>";

// $obj->get_sql('SELECT * FROM sec_a');
// echo "SQL result : ";
// echo "<pre>";
// print_r($obj->getResult());
// echo "</pre>";





$obj->select('sec_a','Roll, Name, gender_name, blood_name, Phone_Number','gender ON sec_a.Gender=gender.gender_id LEFT JOIN blood_group ON sec_a.Blood_group=blood_group.blood_id',null,'Roll ASC',3);
echo "Select result : ";
echo "<pre>";
print_r($obj->getResult());
echo "</pre>";


$obj->pagination('sec_a','gender ON sec_a.Gender=gender.gender_id LEFT JOIN blood_group ON sec_a.Blood_group=blood_group.blood_id',null,3);

// $row = $obj->getResult();

// while($row){
// echo $row['Roll'];

// }

?>