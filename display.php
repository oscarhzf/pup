<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            .red{
                color:red;
            }
            .blue{
                color:blue;
            }
        </style>
    </head>
    <body>
        <script type="text/javascript">
        function viewdata(){
            document.myForm.action="display.php";
            document.myForm.submit();
        }
        function exportdata(){
            document.myForm.action="database/export_range.php";
            document.myForm.submit();
        }
        </script>
        <form method="POST" name="myForm">
            <div>
                From:<input type="date" name="start" value="<?php echo isset($_POST['start'])? $_POST['start'] : date('Y-m-d');?>" max="<?php echo date('Y-m-d'); ?>"/>
                To:<input type="date" name="end" value="<?php echo isset($_POST['end'])? $_POST['end'] : date('Y-m-d');?>" max="<?php echo date('Y-m-d'); ?>"/>
                <select name="datatype" size="1">
                    <option value="engtemp" <?php if(@$_POST[datatype] == "engtemp"){echo 'selected="selected"';}?>>Engine Temperature</option>
                    <option value="engspeed" <?php if(@$_POST[datatype] == "engspeed"){echo 'selected="selected"';}?>>Engine Speed</option>
                    <option value="gps" <?php if(@$_POST[datatype] == "gps"){echo 'selected="selected"';}?>>GPS</option>
                    <option value="all" <?php if(@$_POST[datatype] == "all"){echo 'selected="selected"';}?>>All</option>
                </select>
                <input type="button" value="View" onClick="viewdata();"/>
                <input type="button" name="export" value="CSV Export" onClick="exportdata();"/>
            </div>
        </form>
        <?php
        // put your code here
        require_once 'config.php';
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB_Name);
        if(isset($_POST['start'])){
            $start = $_POST['start'];
        }
        else{
            $start = date('Y-m-d');
        }
        if(isset($_POST['end'])){
            $end = $_POST['end'];
        }
        else{
            $start = date('Y-m-d');
        }
        if(isset($_POST['datatype'])){
            $datatype = $_POST['datatype'];
            $sql = "SELECT * FROM $datatype WHERE date BETWEEN '$start' AND '$end' ORDER BY date, time";
            $result = mysqli_query($conn, $sql);
            if(!mysqli_num_rows($result)==0){
                if($datatype == 'engtemp'){
                ?>
                    <div>
                        <table>
                            <tr>
                                <th width="100px">Date</th>
                                <th width="100px">Time</th>
                                <th width="200px">Engine Temperature (C)</th>
                                <th width="50px">ID</th>
                            </tr>
                        <?php
                        while($row = mysqli_fetch_array($result)){
                        ?>
                            <tr class='<?php echo $row["temp"]>200?"red":($row["temp"]<20?"blue":"");?>'>
                                <th><?php echo $row["date"];?></th>
                                <th><?php echo $row["time"];?></th>
                                <th><?php echo $row["temp"];?></th>
                                <th><?php echo $row["id"];?></th>
                            </tr>
                        <?php
                        }
                        ?>
                        </table>
                    </div>
                <?php
                }
                elseif($datatype == 'engspeed'){
                ?>
                    <div>
                        <table>
                            <tr>
                                <th width="100px">Date</th>
                                <th width="100px">Time</th>
                                <th width="200px">Engine Speed (RPM)</th>
                                <th width="50px">ID</th>
                            </tr>
                        <?php
                        while($row = mysqli_fetch_array($result)){
                        ?>
                            <tr class='<?php echo $row["engspeed"]>3999?"red":($row["engspeed"]<20?"blue":"");?>'>
                                <th><?php echo $row["date"];?></th>
                                <th><?php echo $row["time"];?></th>
                                <th><?php echo $row["speed"];?></th>
                                <th><?php echo $row["id"];?></th>
                            </tr>
                        <?php
                        }
                        ?>
                        </table>
                    </div>
                <?php
                }
                elseif($datatype == 'gps'){
                ?>
                    <div>
                        <table>
                            <tr>
                                <th width="100px">Date</th>
                                <th width="100px">Time</th>
                                <th width="100px">Latitude</th>
                                <th width="100px">Longitude</th>
                                <th width="100px">Altitude (m)</th>
                                <th width="100px">Speed (m/s)</th>
                                <th width="100px">Fix Quality</th>
                                <th width="100px">Number of Satellites</th>
                                <th width="50px">ID</th>
                            </tr>
                        <?php
                        while($row = mysqli_fetch_array($result)){
                        ?>
                            <tr>
                                <th><?php echo $row["date"];?></th>
                                <th><?php echo $row["time"];?></th>
                                <th><?php echo $row["latitude"];?></th>
                                <th><?php echo $row["longitude"];?></th>
                                <th><?php echo $row["altitude"];?></th>
                                <th><?php echo $row["speed"];?></th>
                                <th><?php echo $row["fix_quality"];?></th>
                                <th><?php echo $row["satellites"];?></th>
                                <th><?php echo $row["id"];?></th>
                            </tr>
                        <?php
                        }
                        ?>
                        </table>
                    </div>
                <?php
                }
            }else{
                echo "No Data";
            }
        }
        ?>
    </body>
</html>
