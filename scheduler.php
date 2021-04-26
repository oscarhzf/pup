<?php

$command = escapeshellcmd('/opt/bitnami/apache/htdocs/vms/scheduler.py');
$output = shell_exec($command);

echo "<pre>$output</pre>";

?>
