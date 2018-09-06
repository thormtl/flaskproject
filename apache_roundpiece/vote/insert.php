<?php

function insertdb($name, $roundPieces){
	$servername = <SERVER_NAME>;
	$username = <USERNAME>;
	$password = <PASSWORD>;

	// Getting weekday
	$today = getdate();
	$y = $today['year'];
	$m = $today['mon'];
	$d = $today['mday'];
	$ddate = "$y-$m-$d";
	$date = new DateTime($ddate);
	$week = $date->format("W");
	$lastweek = 44; // Only used when debugging

	// Creating Connection
	$con = mysql_connect("$servername","$username","$password");
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }
	 
	mysql_select_db("votedb", $con);

	// Filtering Special Characters From Name
//	$name_filtered = preg_replace('/[^A-Za-z0-9\-]/', '', $name);
	 
	$sqlIns="INSERT INTO vote (Week, FirstName, RoundPieces) VALUES ('$week','$name','$roundPieces')";
	 
	if (!mysql_query($sqlIns,$con))
	  {
	  die('Error: ' . mysql_error());
	  }
	//echo "1 record added <br><br>";
	/* 
	$sumRoundPieces = "SELECT sum(RoundPieces) AS sum_value FROM vote WHERE Week=$week";
	$sumRes = mysql_query($sumRoundPieces,$con);
	$row = mysql_fetch_assoc($sumRes);
	$sumRP = $row['sum_value'];
	*/
	// Message on website
	//print_r("Weeknumber: $week <br>");
	//echo "<br>Count so far: <br> $sumRP <br>";

	// Remember to close connection again
	mysql_close($con);


	/* Redirect browser */
	//echo "Redirecting in 3 seconds - Please don't refresh";
	//header(Refresh: 3; 'URL=http://ec2-52-57-92-95.eu-central-1.compute.amazonaws.com/');
	header("Location: http://ec2-52-57-92-95.eu-central-1.compute.amazonaws.com/ ");
	/* Make sure that code below does not get executed when we redirect. */
	return 0;
	//exit;
}
?>
