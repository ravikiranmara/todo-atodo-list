<?php

echo "Today is " . date("y-m-d")."\n";
$sometime = mktime(0,0,0, 12, 1, 2016);
echo "someday is " . date("Y-m-d", $sometime);
echo null;

echo $_SERVER['DOCUMENT_ROOT'];

?>
