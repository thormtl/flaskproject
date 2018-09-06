<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require_once("insert.php");
  $name = "";

  // form handler
  if($_POST && isset($_POST['name'], $_POST['RoundPieces'])) {
    $name = test_input($_POST['name']);
    $roundPieces = $_POST['RoundPieces'];

    if(!$name) {
      $errorMsg = "<b><ins>ATTENTION:</ins></b> Please enter your Name";
    } elseif(!preg_match("/^[a-zA-Z ]*$/", $name)) {
      $errorMsg = "<b><ins>ATTENTION:</ins></b> Please don't use symbols";
    } else {

      // Insert in DB
      insertdb($name, $roundPieces);
    }
  }
}
  function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
  }
?>
<!DOCTYPE html>
<html>
<body>
<head>
<title>Thors Playground</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="assets/css/main.css" />
</head>

<!-- Header -->
<!--
<header id="header">
<div class="inner">
<a class="logo"<strong>Version</strong> 0.0.1</a>
</div>
</header>
-->

<!-- Banner -->
<section id="banner">
	<div class="inner">
	<header>
	<h1>Round Piece Request Form</h1>
	<!--<h3> REMEMBER <br><br></h3>-->
	</header>

	<div class="flex ">

	<div>
	<span class="icon fa-pencil-square-o"></span>
	<h3>Order</h3>
	<p>Up to 3 rolls</p>
	</div>

	<div>
	<span class="icon fa-calendar"></span>
	<h3>Deadline</h3>
	<p>Submit before friday</p>
	</div>


	<div>
	<span class="icon fa-cutlery"></span>
	<h3>Breakfast</h3>
	<p>Enjoy the bread rolls</p>
	</div>
	</div>
	</div>
</section>

<br>
<br>
<br>

<!-- Middle Section -->
<div class="inner">

<center>
<?php
// Extracting weekday information
$today = getdate();
$y = $today['year'];
$m = $today['mon'];
$d = $today['mday'];
$ddate = "$y-$m-$d";
$date = new DateTime($ddate);
$week = $date->format("W");
$lastweek = $week-1;
echo "<h3>Week $week </h3>"
?> 
</center>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
<div class="row uniform">

<div class="12u$">
	<input type="text" name="name" placeholder="Name" value="<?php if(isset($_POST['name'])) echo htmlspecialchars($_POST['name']); ?>" required/>
	<span class="error"> <?php echo $errorMsg;?></span>
</div>

<div class="12u$">
	<div class="select-wrapper">
	<select name="RoundPieces" id="RoundPieces" required>
		<option value="">Bread Rolls Amount</option>
		<option value="0">0</option>
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
	</select>
	</div>
</div>

<div class="12u$">
<ul class="actions">
<center><li><input type="submit" value="Submit Bread Roll Request" /></li></center>
</ul>
</div>

</div>
</form>

<?php

$servername = <INSERT_SERVER_NAME>;
$username = <INSERT_USERNAME>;
$password = <INSERT_PASSWORD>;

// Creating Connection
$con = mysql_connect("$servername","$username","$password");
if (!$con) {
	die('Could not connect: ' . mysql_error());
  }

@mysql_select_db("votedb", $con) or die( "Unable to select database" );
$sumRoundPiecesQuery = "SELECT sum(RoundPieces) AS sum_value FROM vote WHERE Week=$week";
$sumRes = mysql_query($sumRoundPiecesQuery,$con);
$row = mysql_fetch_assoc($sumRes);
$sumRP = $row['sum_value'];

//$summaryQuery = "SELECT Week AS week, FirstName AS name, Roundpieces AS pieces FROM vote WHERE Week=$week"; 
$summaryQuery = "SELECT * FROM vote WHERE Week in ($week,$lastweek)"; 
$summaryRes = mysql_query($summaryQuery,$con);

?>

<section id="three" class="wrapper align-center">
<table align="left" border="2" style= "background-color: #d2def2; color: #000000; margin: 0 auto;" >
<caption><h2> Overview of the last 2 weeks </h2></caption>
<tr>
<th>
<center><font face="Arial, Helvetica, sans-serif">Week</font></center>
</th>
<th>
<center><font face="Arial, Helvetica, sans-serif">Name</font></center>
</th>
<th>
<center><font face="Arial, Helvetica, sans-serif">Rolls</font></center>
</th>
</tr>

<?php

while($row = mysql_fetch_assoc($summaryRes)){
echo "<tr>";
echo "<td>" . $row['Week'] . "</td>";
echo "<td>" . $row['FirstName'] . "</td>";
echo "<td>" . $row['RoundPieces'] ."</td>";
echo "</tr>\n";
	}
echo "</table>";
?>

</section>

<br>
<br>
<div class="row">
<div class="12u$">
<?php
if ($sumRP != 0) {
	echo "<br><br><center>The '<ins>round piece responsible</ins>' must buy <font size='6'><ins><b>$sumRP</b></ins></font> round piece(s) this week</center>"; 
} else {
	echo "<br><center><ins><b>No One</b></ins> has submitted a round piece request this week<center>";
}
?>
</div>
	<div class="12u$">
		<p><center><img src="blandet-rundstykker.jpg" alt="rundstykker.jpg" width="50%"></center></p>
	</div>
</div>
<br>
<br>
<br>
<br>

<footer id="footer">
<div class="inner">
<div>
<span class="fa fa-wheelchair-alt" style="font-size:50px"></span>
<h1>DISCLAIMER</h1>
<p>Use this website at own risk <i class="fa fa-smile-o" style="font-size:24px"></i> </p>
</div>
</div>
</footer>

<?php 
// Remember to close connection again
mysql_close($con);?>
</body>
</html>
