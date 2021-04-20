<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


if(isset($_POST['datatype'])){
    require_once 'config.php';
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB_Name);
    $headers = array(
        array('Date', 'Time', 'Engine Temperature (C)', 'ID'),
        array('Date', 'Time', 'Engine Speed (RPM)', 'ID'),
        array('Date', 'Time', 'Latitude', 'Longitude', 'Altitude (m)', 'Speed (m/s)', 'Fix Quality', 'Number of Satellites', 'ID')
    );
    $start = $_POST['start'];
    $end = $_POST['end'];
    $datatype = $_POST['datatype'];
    if ($datatype != 'all'){
        
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
            fputcsv($output, $headers[0]);  
        }
        elseif($datatype == 'engspeed'){
            fputcsv($output, $headers[1]);
        }
        elseif($datatype == 'gps'){
            fputcsv($output, $headers[2]);
        }
        while($row = mysqli_fetch_assoc($result)){
            fputcsv($output, $row);
        }
        mysqli_query($conn, $sql);
    }
    else{
        $data = array('engtemp', 'engspeed', 'gps');
        // create your zip file
        $zipname = $start.'-'.$end.'.zip';
        $zip = new ZipArchive;
        $zip->open($zipname, ZipArchive::CREATE);

        // loop to create 3 csv files
        for ($i = 0; $i < 3; $i++) {

            // create a temporary file
            $fd = fopen('php://temp/maxmemory:1048576', 'w');
            if (false === $fd) {
                die('Failed to create temporary file');
            }

            // select data from database
            $sql = "SELECT * FROM $data[$i] WHERE date BETWEEN '$start' AND '$end' ORDER BY date, time";
        //    $sql = "SELECT * FROM data ORDER BY date, time";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result)==0){
                break;
            }

            // write the data to csv
            fputcsv($fd, $headers[$i]);
            while($row = mysqli_fetch_assoc($result)){
                fputcsv($fd, $row);
            }

            // return to the start of the stream
            rewind($fd);

            // add the in-memory file to the archive, giving a name
            $zip->addFromString($data[$i].'_'.$start.'-'.$end.'.csv', stream_get_contents($fd) );
            //close the file
            fclose($fd);
        }
        // close the archive
        $zip->close();


        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename='.$zipname);
        header('Content-Length: ' . filesize($zipname));
        readfile($zipname);

        // remove the zip archive
        // you could also use the temp file method above for this.
        unlink($zipname);
    }
}