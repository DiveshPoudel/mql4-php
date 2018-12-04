<?php

$rawdata = file_get_contents('php://input');
//$rawdata = "2017.04.12 09:53,1.06092,1.06095,4205,232323,2323,32323,2323,2323, 2017.04.13 10:22,29292,2323,2323,2323";

$servername = "localhost";
$username = "root";
$password = "";
// Create connection
$conn = new mysqli($servername, $username, $password, "ticks");
// Check connection
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";
$posted_data = explode(",", trim($rawdata));
$datetime = date(str_replace(".", "-", $posted_data[0]));
$bid = floatval($posted_data[1]);
$ask = floatval($posted_data[2]);
$open = floatval($posted_data[3]);

if (sizeof($posted_data) > 4) 
{
	// bar data pani cha
	$bar_array = array();
	for($i=0; $i < 20; $i++) 
	{
		$bar_array[$i] = array();
		$bar_array[$i]["time"] = date(str_replace(".", "-", $posted_data[4 + 5*$i]));
		$bar_array[$i]["open"] = $posted_data[4+5*$i + 1];
		$bar_array[$i]["high"] = $posted_data[4+5*$i + 2];
		$bar_array[$i]["low"] = $posted_data[4+5*$i + 3];
		$bar_array[$i]["close"] = $posted_data[4+5*$i + 4];
		
		$check_select = $conn->query("SELECT  id FROM timedata WHERE time = '" . mysql_real_escape_string($bar_array[$i]["time"]) . "'");
		 if($check_select->num_rows == 0)
		{
			$sql2 = "Insert into timedata(time,open,high,low,close) VALUES ('".mysql_real_escape_string($bar_array[$i]["time"])."', '".mysql_real_escape_string($bar_array[$i]["open"])."','".mysql_real_escape_string($bar_array[$i]["high"])."','".mysql_real_escape_string($bar_array[$i] ["low"])."','".mysql_real_escape_string($bar_array[$i] ["close"])."')";
			if($conn->query($sql2) === true)
			{
			echo "inserted";
			} 
		}
		else 
		{
			echo "Duplicate. skipping...";
		}
	}
}
else {
	echo "no new bar";
}

$sql1 = "INSERT INTO data (date, ask, bid, open) VALUES ('$datetime', '$ask', '$bid', '$open')";
$sql3 = "DELETE FROM `data` WHERE id NOT IN ( SELECT id FROM ( SELECT id FROM `data` ORDER BY id DESC LIMIT 50 ) foo )";
$sql4 = "Select time from timedata order by timestamp ASC";
if ($conn->query($sql4) === true)
{
	echo "timely data arranged ";
}
if($conn->query($sql1) === true)
{
   echo "inserted";
} 

if($conn->query($sql3) === true)
{
   echo "inserted";
} 

?>
