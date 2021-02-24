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
        <?php
        $file = "test.txt";
        $lines = file_get_contents($file);
        $line = explode("\n",$lines);
        $host = "localhost";
        $user = "root";
        $database = "pup";
        $conn = mysqli_connect($host, $user);
        $sql = "INSERT INTO test VALUES";
        $check = "SELECT * FROM test WHERE ";
        if($conn){
            echo "连接成功"."<br>";
        }
        if(mysqli_select_db($conn, $database)){
            echo "选择成功"."<br>";
        }
        foreach ($line as $li){
            $arr = explode(" ",$li);
            var_dump($arr);
            echo '<br>';
                $insert = $sql."('$arr[0]', '$arr[1]', '$arr[2]')";
                if($insert){
                    echo "插入成功"."<br>";
                    mysqli_query($conn, $insert);
            }
        }
        print_r($line);
        echo '<br>';
        $data = (bool)mysqli_query($conn,$check."date = '$arr[0]'");
        var_dump($data)."<br>";
        echo $check."date = '$arr[0]'";
        ?>
    </body>
</html>
