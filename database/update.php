<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$host = "localhost";
$user = "root";
$database = "pup";
$password = "";
$conn = mysqli_connect($host, $user, $password, $database);
if($conn){
    echo "Database Connected"."<br><br>";
}
updateTemp($conn);
updateSpeed($conn);
function updateTemp($conn){
    $file = "data/engtemp.txt";
    $lines = file_get_contents($file);
    $line = explode("\n",$lines);
    $new = 0;
    $num = 0;
    $error = 0;
    foreach ($line as $li){
        $arr = explode(" ",$li);
        if(!findDataByDateAndTime($arr[0], $arr[1], 'engtemp', $conn)){
            if($arr[2] >= 0 & $arr[2] <= 300){
                $num += insertTemp($arr[0], $arr[1], $arr[2], $conn);  
            }else{
                $error ++;
            }
            $new ++;
        }
    }
    echo "Update Engine Temperature<br>";
    echo $new." new pieces of data<br>";
    echo $num." added to Engine Temperature<br>";
    echo $error." error(s)<br><br>";
}
function updateSpeed($conn){
    $file = "data/engspeed.txt";
    $lines = file_get_contents($file);
    $line = explode("\n",$lines);
    $new = 0;
    $num = 0;
    $error = 0;
    foreach ($line as $li){
        $arr = explode(" ",$li);
        if(!findDataByDateAndTime($arr[0], $arr[1], 'engspeed', $conn)){
            if($arr[2] >= 0 & $arr[2] <= 4000){
                $num += insertSpeed($arr[0], $arr[1], $arr[2], $conn);  
            }else{
                $error ++;
            }
            $new ++;
        }
    }
    echo "Update Engine Speed<br>";
    echo $new." new pieces of data<br>";
    echo $num." data added to Engine Speed<br>";
    echo $error." error(s)<br><br>";
}
function updateGPS($conn){
    $file = "data/gps.txt";
    $lines = file_get_contents($file);
    $line = explode("\n",$lines);
    $num = 0;
    foreach ($line as $li){
        $arr = explode(" ",$li);
        if(!findDataByDateAndTime($arr[0], $arr[1], 'gps', $conn)){
            $num += insertGPS($arr[0], $arr[1], $arr[2], $arr[3], $conn);
        }
    }
    echo $num." data(s) added to GPS";
}
function findDataByDateAndTime ($date, $time, $table, $conn){
    $flag = 0;
    $sql = "SELECT * FROM $table WHERE date = '$date' AND time = '$time'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_fetch_row($result);
    if($count){
        $flag = 1;
    }
    return $flag;
}
function insertTemp($date, $time, $temp, $conn){
    $flag = 0;
    $sql = "INSERT INTO engtemp VALUES ('$date', '$time', '$temp')";
    if(mysqli_query($conn, $sql)){
        $flag = 1;
    }else{
        echo "Update Failed<br>";
    }
    return $flag;
}
function insertSpeed($date, $time, $speed, $conn){
    $flag = 0;
    $sql = "INSERT INTO engspeed VALUES ('$date', '$time', '$speed')";
    if(mysqli_query($conn, $sql)){
        $flag = 1;
    }else{
        echo "Update Failed<br>";
    }
    return $flag;
}
function insertGPS($date, $time, $latitude, $longitude, $conn){
    $flag = 0;
    $sql = "INSERT INTO gps VALUES ('$date', '$time', '$latitude', '$longitude')";
    if(mysqli_query($conn, $sql)){
        $flag = 1;
    }else{
        echo "Update Failed<br>";
    }
    return $flag;
}