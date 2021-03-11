<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'config.php';
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB_Name);
if(!$conn){
    die("Database Connection Failed " . mysqli_connect_error()."<br><br>");
}
function extractTemp($conn, $id){
    $sql = "SELECT * From engtemp WHERE id = '$id' ORDER BY date, time";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        $content = array();
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
        return $content;
    }
}
function extractSpeed($conn, $id){
    $sql = "SELECT * From engspeed WHERE id = '$id' ORDER BY date, time";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        $content = array();
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
        return $content;
    }
}
function stringToFloat($arr){
    foreach($arr as $k => $n){
        $arr[$k] = (float)$n;
    }
    return $arr;
}