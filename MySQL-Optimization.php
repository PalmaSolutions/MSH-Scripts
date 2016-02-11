<?php
echo '<form method="post" enctype="multipart/form-data"><br /><hr>';
echo '<b>MySQL Hostname/IP:</b></td><td><input name="host" id="host" type="text" size="50">';
echo '<b>MySQL Username:</b></td><td><input name="usr" id="usr" type="text" size="50">';
echo '<b>MySQL Password:</b></td><td><input name="pwd" id="pwd" type="text" size="50">';
echo '<input name="submit" type="submit" value="Go"><br /><br />';
    if(($_POST['submit']) == "Go") {
    $host = ($_POST["host"]);
    $user = ($_POST["usr"]);
    $pass = ($_POST["pwd"]);

echo "".date('H:i:s').": Connecting to MySQL Server .... <br />";
$link = mysql_connect($host, $user, $pass) or die(mysql_error());

$result = mysql_list_dbs($link);
while($raw = mysql_fetch_object($result)){
foreach($raw as $name){
$tables = mysql_list_tables($name);

echo 'optimizing database '.$name.'<br />';
if($name == 'information_schema')
{
echo 'skipping information_schema<br />';
}
else
{
echo "".date('H:i:s').": Get tables from database $name .... <br />";
while ($row = mysql_fetch_row($tables)) {
       echo "".date('H:i:s').": Optimize table $row[0] ....<br />";
        mysql_query('optimize table '.$row[0].' ') or die(mysql_error());

}
}
echo "".date('H:i:s').": Table of Database ".$name." Optimized <br />";
}
}
mysql_free_result($result);

mysql_close($link);
}
?>
