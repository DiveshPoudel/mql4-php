<?php

$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, "ticks");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
	} 
 $sql = "select date,bid,ask,open from data";
 $result = $conn->query($sql);
 
 if($result->num_rows>0)//output data of each row
 {
	 while($row=$result->fetch_assoc())
	 {
		 echo "date:" .$row["date"]. "bid:" .$row["bid"]. "ask:" .$row["ask"]. "open:" .$row["open"]. "<br>" ;
	 }
 }
 else
 {
	 echo "0 results";
 }
$conn->close();

?>
