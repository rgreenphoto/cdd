<?php
include $_SERVER['DOCUMENT_ROOT']."sessions.php";
if($session->logged_in){ 

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="eyebum" >
    <link rel="icon" href="../favicon.ico">
    	<script type="text/javascript" src="../js/jquery-ui-1.10.4/jquery-1.10.2.js">
		</script>
		<script type="text/javascript" src="../js/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js">
		</script>		
		<script type="text/javascript" src="../js/jquery.min.js">
		</script>		
		<script type="text/javascript" src="../js/jmath.js">
		</script>
		<script type="text/javascript" src="../js/scoreCore.js">
		</script>

    <title>UFO Scoring System-Tablet Edition</title>

    <!-- Bootstrap core CSS -->
    <link href="../bootstrap-3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
     <!-- <link href="../css/starter-template.css" rel="stylesheet">
        Custom styles for this template -->
    <link href="../css/theme.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">UFO Tablet Scoring</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><?php include "homelink.php" ?></li>
            <li  class="nav-item">
&nbsp;&nbsp;event_id:&nbsp;
<?php echo $event_id; ?>
&nbsp;|&nbsp;Event:&nbsp;
<?php echo $Event; ?>
&nbsp;|&nbsp;Session_ID:&nbsp;
<?php echo $_SESSION['username']; ?>
</li>
            <li><a href ="http://tablet.ufoworldcup.org/login/process.php">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container">
      <div class="starter-template">
      
			<?php
require "db_connect.php";
$database = 'd60577000';
$table = 'Registration';

$rowid=$_GET["row_id"];
$div=$_GET["division"];
//Note-this division is not necessarily the division of the competitor: it is the division selected to get into the score entry module.
//It is either FS or TC. Any combined teams will have and FS or a TC as their division RIGHT here-not because it is in the database, but because
//it was passed from the dropdown selector on the 'enter scores' tab. It is passed from this page to rowupdate.php so that when a user 
//selects 'enter another team in this division' it will now have the correct division. Bottom line-don't fuck with it. It is not the real division.

$conn = mysql_connect($db_host, $db_user, $db_pwd) or die('Could not connect to mysql server.');
mysql_select_db($database) or die("Could not select database.");
mysql_set_charset('utf8',$conn); //THIS IS THE IMPORTANT PART

$sql = "SELECT * FROM {$table} WHERE row_id=$rowid";
$result = mysql_query($sql);
$myrow = mysql_fetch_array($result);
$type = $myrow[EventType];
$event = $myrow[Event];
?>

			<form action="rowupdate.php" method="post" accept-charset="UTF-8">
				<div align="center">
					<br>
					Competitor Info:<br>
					<!-- Name: <b><?php echo $myrow[Handler];?></b>-->
					<button type="button" class="btn btn-warning"><?php echo $myrow[Handler];?></button>
					<input type="hidden" name="Handler" value="<?php echo $myrow[Handler];?>">
					<button type="button" class="btn btn-info"><?php echo $myrow[Dog];?></button> 
					<!--Dog: <b><?php echo $myrow[Dog];?></b>-->
					<input type="hidden" name="Dog" value="<?php echo $myrow[Dog];?>">
					<button type="button" class="btn btn-default"><?php echo $myrow[Division];?> - <?php echo $myrow[row_id];?></button>
					<!--Division is currently <b><?php echo $myrow[Division];?></b><br> -->
					<!--Sheet #: <b><?php echo $myrow[row_id];?></b><br> -->
<p>

<?php include "../russ/tc.php";?>

					<input type="hidden" name="Event" value="<?php echo $Event;?>"> 
					<input type="hidden" name="row_id" value="<?php echo $rowid;?>">
					<input type="hidden" name="Division" value="<?php echo $div;?>"><br>
					<input type="submit" value="Update Scores"></div>
			</form>

<br>
<form action="dbedit.php" method="post" target="_self" accept-charset="UTF-8">
<input type="hidden" name="Year" value="<?php echo date("Y") ?>" />
<input type="hidden" name="Division" value="<?php echo $div ?>" />
<input type="hidden" name="Event" value="<?php echo $event ?>" />
Click here to go back to team selection (No score changes)<br>
<input type="submit" value="Go Back">
</form>				
      </div>
    </div> <!-- /.container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../bootstrap-3.3.7/assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>
  </body>
</html>
<?php 
}
else {
    echo "Not logged in";
}
?>