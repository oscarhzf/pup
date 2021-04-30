<?php

/* 
 * Extract Data
 * PUP-1, 2021 ABE Capston
 * Agricultural and Biological Engineering Department, Purdue University
 * 
 * Extract require data from database.
 */

// Connect database
require_once 'config.php';
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB_Name);
if(!$conn){
    die("Database Connection Failed " . mysqli_connect_error()."<br><br>");
}

// Extract temperature data
function extractTemp($conn, $id, $date){
    $sql = "SELECT * From engtemp WHERE id = '$id' AND date = '$date' ORDER BY date, time";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        $content = array();
//        Organize the data into the required format
        while($row = mysqli_fetch_assoc($result)){
            $value = array_values($row);
            $date = explode('-', $value[0]);
            $time = explode(':', $value[1]);
            $temp = $value[2];
            $svalue = array_merge($date, $time);
            $svalue[] = $temp;
            $num = stringToFloat($svalue);
            $content[] = $num;
        }
        echo "engtempdata=".json_encode($content);
    }
}
function extractSpeed($conn, $id, $date){
    $sql = "SELECT * From engspeed WHERE id = '$id' AND date = '$date' ORDER BY date, time";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        $content = array();
//        Organize the data into the required format
        while($row = mysqli_fetch_assoc($result)){
            $value = array_values($row);
            $date = explode('-', $value[0]);
            $time = explode(':', $value[1]);
            $speed = $value[2];
            $svalue = array_merge($date, $time);
            $svalue[] = $speed;
            $num = stringToFloat($svalue);
            $content[] = $num;
        }
        echo "engspeeddata=".json_encode($content);
    }
}
function extractGPS($conn, $id, $date){
    $sql = "SELECT * From gps WHERE id = '$id' AND date = '$date' ORDER BY date, time";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        $content = array();
//        Organize the data into the required format
        while($row = mysqli_fetch_assoc($result)){
            $value = array_values($row);
            $date = explode('-', $value[0]);
            $time = explode(':', $value[1]);
            $latitude = $value[2];
            $longitude = $value[3];
            $altitude = $value[4];
            $speed = $value[5];
            $fix_quality = $value[6];
            $satellites = $value[7];
            $svalue = array_merge($date, $time);
            $svalue[] = $latitude;
            $svalue[] = $longitude;
            $svalue[] = $altitude;
            $svalue[] = $speed;
            $svalue[] = $fix_quality;
            $svalue[] = $satellites;
            $num = stringToFloat($svalue);
            $content[] = $num;
        }
        echo "gps=".json_encode($content);
    }
}

// Converts a string to a floating point number
function stringToFloat($arr){
    foreach($arr as $k => $n){
        $arr[$k] = (float)$n;
    }
    return $arr;
}