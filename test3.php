<?php
$json_responses = file_get_contents('http://127.0.0.1:8000/mitarbeiter');
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
//it works only when there are all objects of mitarbeiters printed
// we have to tell explicitly object position
//$getStatus = $json_responses->attendences; //20 //when mitarbeiter id is 2 //bcz only one object
$getStatus = $json_responses[0]->attendences;
echo count($getStatus); // 20
echo '<hr>';

//foreach($json_responses as $json_response){
//    echo $json_response->attendences.'<br>';
//}
echo '<hr>';
                            
                            echo '<table border="1">';
                            echo '<tr>';
                            echo '<th>';
                            $i = 1;
                            while($i < 5){
                            echo '<div>';
                            
                            echo 'KW'.$i;
                            
                            echo '</div>';
                            echo '<div>';
                            
                            echo '<label class="label label-success">Mo</label>';
                            echo '<label class="label label-success">Di</label>';
                            echo '<label class="label label-success">Mi</label>';
                            echo '<label class="label label-success">Do</label>';
                            echo '<label class="label label-success">Fr</label>';
                            echo '</div>';
                            $i++;
                            }
                            echo '</th>';
                            echo '</tr>';


                            echo '</table>';
                           
                          




?>