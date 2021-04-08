<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


if(isset($_POST['datatype'])){
    require_once 'config.php';
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB_Name);
    $start = $_POST['start'];
    $end = $_POST['end'];
    $datatype = $_POST['datatype'];
    $sql = "SELECT * FROM $datatype WHERE date BETWEEN '$start' AND '$end' ORDER BY date, time";
//    $sql = "SELECT * FROM data ORDER BY date, time";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)==0){
        ?>
        <script type="text/javascript">
            alert("No Data");
            window.history.go(-1);
        </script>
        <?php
        exit;
    }
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename='.$datatype.'_'.$start.'-'.$end.'.csv');
    $output = fopen("php://output", "w");
    if($datatype == 'engtemp'){
        fputcsv($output, array('Date', 'Time', 'Engine Temperature (C)', 'ID'));  
    }
    elseif($datatype == 'engspeed'){
        fputcsv($output, array('Date', 'Time', 'Engine Speed (RPM)', 'ID'));
    }
    elseif($datatype == 'gps'){
        fputcsv($output, array('Date', 'Time', 'Latitude', 'Longitude', 'ID'));
    }
    while($row = mysqli_fetch_assoc($result)){
        fputcsv($output, $row);
    }
    mysqli_query($conn, $sql);
}
