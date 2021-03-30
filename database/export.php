<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_POST['export'])){
    require_once 'config.php';
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB_Name);
    $date = $_POST['date'];
    $sql = "SELECT * FROM data WHERE date = '$date' ORDER BY date, time";
//    $sql = "SELECT * FROM data ORDER BY date, time";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)==0){
        exit;
    }
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Date', 'Time', 'Engine Speed (RPM)', 'Temperature (C)', 'Temperature (F)', 'Latitude', 'Longitude', 'ID'));
    while($row = mysqli_fetch_assoc($result)){
        fputcsv($output, $row);
    }
    mysqli_query($conn, $sql);
}
