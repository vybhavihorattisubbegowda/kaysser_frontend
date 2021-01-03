<?php
$jsonresponses = file_get_contents('http://127.0.0.1:8000/mitarbeiter');
$jsonresponses = json_decode($jsonresponses, false); 
 
foreach($jsonresponses as $jsonresponse){
    echo '<br>';
    echo $jsonresponse->nachname."   ";
    echo $jsonresponse->vorname."   ";
    //echo $jsonresponse->attendences[0]->timesheets[0]->checkIn."   ";
    //echo $jsonresponse->attendences[0]->timesheets[0]->checkOut."   ";

    foreach($jsonresponse->attendences as $attendence)
    {    
        $date = strtotime($attendence->date);
        echo  "KW ".date("W", $date);
        echo  date("D", $date);
    }
     
}