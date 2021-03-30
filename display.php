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
    </head>
    <body>
<!--        <script type="text/javascript">
        function viewdata(){
            document.myForm.action="display.php";
            document.myForm.submit();
        }
        function exportdata(){
            document.myForm.action="database/export.php";
            document.myForm.submit();
        }
        </script>
        <form method="POST" name="myForm">
            <div>
                <input type="date" name="date" value="<?php echo isset($_POST['date'])? $_POST['date'] : date('Y-m-d');?>" max="<?php echo date('Y-m-d'); ?>"/>
                <input type="button" name="submit" value="Submit" onClick="viewdata();"/>
                <input type="button" name="export" value="CSV Export" onClick="exportdata();"/>
            </div>
        </form>-->
        <form method="POST" action="">
            <div>
                <input type="date" name="date" value="<?php echo isset($_POST['date'])? $_POST['date'] : date('Y-m-d');?>" max="<?php echo date('Y-m-d'); ?>"/>
                <input type="submit" name="submit" value="Submit"/>
            </div>
        </form>
        <form method="post" action="database/export.php">
            <input type="date" name="date" value="<?php echo isset($_POST['date'])? $_POST['date'] : date('Y-m-d');?>" max="<?php echo date('Y-m-d'); ?>"/>
            <input type="submit" name="export" value="CSV Export"/>
        </form>
        <?php
        // put your code here
        require_once 'config.php';
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB_Name);
        if(isset($_POST['date'])){
            $date = $_POST['date'];
        }
        else{
            $date = date('Y-m-d');
        }
        $sql = "SELECT * FROM data WHERE date = '$date' ORDER BY date, time";
        $result = mysqli_query($conn, $sql);
        if(!mysqli_num_rows($result)==0){
        ?>
            <div>
                <table>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Speed (RPM)</th>
                        <th>Temperature (C)</th>
                        <th>Temperature (F)</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>ID</th>
                    </tr>
                <?php
                while($row = mysqli_fetch_array($result)){
                ?>
                    <tr>
                        <td><?php echo $row["date"];?></td>
                        <td><?php echo $row["time"];?></td>
                        <td><?php echo $row["speed"];?></td>
                        <td><?php echo $row["tempC"];?></td>
                        <td><?php echo $row["tempF"];?></td>
                        <td><?php echo $row["latitude"];?></td>
                        <td><?php echo $row["longitude"];?></td>
                        <td><?php echo $row["id"];?></td>
                    </tr>
                <?php
                }
                ?>
                </table>
            </div>
        <?php    
        }
        ?>
    </body>
</html>
