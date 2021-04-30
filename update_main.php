<?php

/* 
 * Database Update
 * PUP-1, 2021 ABE Capston
 * Agricultural and Biological Engineering Department, Purdue University
 * 
 * Read the TXT files and store new data into the database. 
 * Different types of data stored in differnt table.
 * Engine Temperature, Engine Speed, and GPS.
 */

// Connect Database
require_once 'database/config.php';
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB_Name);
if($conn){
    echo "Database Connected"."<br><br>";
}

updateTemp($conn);
updateSpeed($conn);
updateGPS($conn);
mysqli_close($conn);

// Update parameters related to engine temperature
function updateTemp($conn){
    $file = "data/temp_data.txt";
    $lines = file_get_contents($file);
    $line = explode("\n",$lines);
    $new = 0;
    $num = 0;
    $error = 0;
    foreach ($line as $li){
        $arr = explode(" ",$li);
        if(count($arr) == 4){ // Determine whether the data is complete
            if(!findDataByDateAndTime($arr[0], $arr[1], 'engtemp', $conn)){ // Determine if the data already exists in the database
                if($arr[2] >= 0 & $arr[2] <= 300){
                    $num += insertTemp($arr[0], $arr[1], $arr[2], 1, $conn);  // Set all id to 1
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

// Update parameters related to engine speed
function updateSpeed($conn){
    $file = "data/rpm_data.txt";
    $lines = file_get_contents($file);
    $line = explode("\n",$lines);
    $new = 0;
    $num = 0;
    $error = 0;
    foreach ($line as $li){
        $arr = explode(" ",$li);
        if(count($arr) == 4){ // Determine whether the data is complete
            if(!findDataByDateAndTime($arr[0], $arr[1], 'engspeed', $conn)){ // Determine if the data already exists in the database
                if($arr[2] >= 0 & $arr[2] <= 4000){
                    $num += insertSpeed($arr[0], $arr[1], $arr[2], 1, $conn);  // Set all id to 1
                }else{
                    $error ++;
                }
                $new ++;
            }
        }
    }
    echo "Update Engine Speed<br>";
    echo $new." new pieces of data<br>";
    echo $num." data added to Engine Speed<br>";
    echo $error." error(s)<br><br>";
}

// Update parameters related to gps
function updateGPS($conn){
    $file = "data/gps_data.txt";
    $lines = file_get_contents($file);
    $line = explode("\n",$lines);
    $new = 0;
    $num = 0;
    $error = 0;
    foreach ($line as $li){
        $arr = explode(" ",$li);
        if(count($arr) == 9){ // Determine whether the data is complete
            if(!findDataByDateAndTime($arr[0], $arr[1], 'gps', $conn)){ // Determine if the data already exists in the database
                if($arr[2] >= -90 & $arr[2] <= 90 & $arr[3] >= -180 & $arr[3] <= 180){
                    $num += insertGPS($arr[0], $arr[1], $arr[2], $arr[3], $arr[4], $arr[5], $arr[6], $arr[7], 1, $conn);  // Set all id to 1
                }else{
                    $error ++;
                }
                $new ++;
            }
        }
    }
    echo "Update GPS<br>";
    echo $new." new pieces of data<br>";
    echo $num." data added to GPS<br>";
    echo $num." data(s) added to GPS";
}

// Check if data already existed
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

// Insert temperature data into database
function insertTemp($date, $time, $temp, $id, $conn){
    $flag = 0;
    $sql = "INSERT INTO engtemp VALUES ('$date', '$time', '$temp', '$id')";
    if(mysqli_query($conn, $sql)){
        $flag = 1;
    }else{
        echo "Update Failed<br>";
    }
    return $flag;
}

// Insert speed data into database
function insertSpeed($date, $time, $speed, $id, $conn){
    $flag = 0;
    $sql = "INSERT INTO engspeed VALUES ('$date', '$time', '$speed', '$id')";
    if(mysqli_query($conn, $sql)){
        $flag = 1;
    }else{
        echo "Update Failed<br>";
    }
    return $flag;
}

// Insert gps data into database
function insertGPS($date, $time, $latitude, $longitude, $altitude, $speed, $fix_quality, $satellites, $id, $conn){
    $flag = 0;
    $sql = "INSERT INTO gps VALUES ('$date', '$time', '$latitude', '$longitude', '$altitude', '$speed', '$fix_quality', '$satellites', '$id')";
    if(mysqli_query($conn, $sql)){
        $flag = 1;
    }else{
        echo "Update Failed<br>";
    }
    return $flag;
}