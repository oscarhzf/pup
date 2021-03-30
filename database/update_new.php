<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'config.php';
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB_Name);
if($conn){
    echo "Database Connected"."<br><br>";
}

update($conn);
mysqli_close($conn);

function update($conn){
    $file = "data.txt";
    $lines = file_get_contents($file);
    $line = explode("\n",$lines);
    $new = 0;
    $num = 0;
    $error = 0;
    foreach ($line as $li){
        $arr = explode(" ",$li);
        if(count($arr) >= 4){
            if(!findDataByDateAndTime($arr[0], $arr[1], 'data', $conn)){
                if(dataValid($arr[2], $arr[3], $arr[5], $arr[6])){
                    var_dump($arr);
                    $num += insert($arr[0], $arr[1], $arr[2], $arr[3], $arr[4], $arr[5], $arr[6], $conn);  
                }else{
                    $error ++;
                }
                $new ++;
            }
        }
    }
    echo "Update Engine Temperature<br>";
    echo $new." new pieces of data<br>";
    echo $num." added to Engine Temperature<br>";
    echo $error." error(s)<br><br>";
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
function insert($date, $time, $speed, $tempC, $tempF, $latitude, $longitude, $conn){
    $flag = 0;
    $id = 0;
    $sql = "INSERT INTO data VALUES ('$date', '$time', '$speed', '$tempC', '$tempF', '$latitude', '$longitude', '$id')";
    if(mysqli_query($conn, $sql)){
        $flag = 1;
    }else{
        echo "Update Failed<br>";
    }
    return $flag;
}
function dataValid($speed, $temp, $latitude, $longitude){
    $flag = 1;
    if(!($speed >= 0 & $speed <= 4000)){
        $flag = $flag * 0;
    }
    if(!($temp >= 0 & $temp <= 300)){
        $flag = $flag * 0;
    }
    if(!($latitude >= -90 & $latitude <= 90 )){
        $flag = $flag * 0;
    }
    if(!($longitude >= -180 & $longitude <= 180)){
        $flag = $flag * 0;
    }
    return $flag;
}