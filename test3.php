<?php
$json_responses = file_get_contents('http://127.0.0.1:8000/mitarbeiter/2');
$json_responses = json_decode($json_responses,false);
echo '<pre>'.print_r ($json_responses,true).'</pre>';

echo '<hr>';

$json_responses; //returns only one object of id 2
//attendences[0]; //its an array inside the object
//timesheets[0]; //it prints only one time checkin/out
//timesheets; //it prints all checkin/outs
$timesheets = $json_responses->attendences[0]->timesheets;//it prints all checkin/outs 
print_r($timesheets);//it prints all checkin/outs 
echo '<br>';
echo count($timesheets);//gets count of how many number of arrays inside the timesheet //3
echo '<br>';
$getStatus = $json_responses->attendences;
echo count($getStatus); // 20
echo '<br>';
                          




?>