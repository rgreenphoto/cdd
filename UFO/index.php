<div class="row">
    <div class="col-lg-9 col-md-9 col-sm-9">
        <div class="btn-toolbar">
                <div class="btn-group btn-group-lg">
                    <button class="btn btn-success btn-lg tc_btn" data-value="1.0"><h3><span>1</span> <i class="icon-plus-sign"></i></h3></button>
                </div>

        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3">
        <div class="well pull-right">
            <h1><small>Last</small><br /> <span class="label label-info" id="last_throw_badge">&nbsp;</span></h1>
            <h1><small>Total</small><br /> <span class="label label-primary" id="total_badge">0</span></h1>
        </div>
    </div>
</div>








<?php
include $_SERVER['DOCUMENT_ROOT']."sessions.php";
?>
	<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<title>UFO World Cup Frisbee Dog Series</title>
	<!-- #BeginHeadLocked "" --><!-- InstanceBegin template="../../../web-data/Templates/template.php" -->
			<link href="http://<?php echo $_SERVER['SERVER_NAME'] ?>/css/main.css?v=3" rel="stylesheet" type="text/css" media="all">
			<link rel="stylesheet" href="http://<?php echo $_SERVER['SERVER_NAME'] ?>/css/menucss.css?v=3" type="text/css" media="all" charset="utf-8">
			<link rel="stylesheet" href="http://<?php echo $_SERVER['SERVER_NAME'] ?>/css/tabs.css?v=3" type="text/css" media="all" charset="utf-8">
			<link rel="image_src" href="http://<?php echo $_SERVER['SERVER_NAME'] ?>/images/UFOLogo_Color.png" >
			<script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME'] ?>/js/jquery-1.3.2.min.js"></script>
			<script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME'] ?>/js/tabs.js"></script>
			<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
  		{parsetags: 'explicit'}
</script>
		<!-- InstanceEnd --><!-- #EndHeadLocked -->
</head>
<body>
<div id="maincontainer">
	<div id="social">
	<?php include $_SERVER['DOCUMENT_ROOT']."content/sociallinks.php"; ?>
	</div>
<div id="topsection"><div class="innertube">
<img src="http://<?php echo $_SERVER['SERVER_NAME'] ?>/images/topbar/topbar1.png" alt="" height="80" width="800" border="0">
	<div id="menubar">
	<?php include $_SERVER['DOCUMENT_ROOT']."menu.php"; ?>		  
	</div>
</div></div>
<div id="contentwrapper">
<!-- InstanceBeginEditable name="Body content" --><?php
require "../db_connect.php";
$database = 'd60577000';
$table = 'Events';
$table2 = 'Menu';
$year = date("Y");
$language=$_SESSION['Lang'];

$beforelink = '<a href="IndividualEvent.php?id=';
$afterlink = '" target = "_self">';

$conn = mysql_connect($db_host, $db_user, $db_pwd) or die('Could not connect to mysql server.');
mysql_select_db($database) or die("Could not select database.");
mysql_set_charset('utf8',$conn); //THIS IS THE IMPORTANT PART

$query = "SELECT * FROM {$table2} WHERE language=\"$language\" ";
$result1 = mysql_query($query);
if (!$result1) {
    die("Query to show fields from table failed");
}
$row1 = mysql_fetch_array($result1);
$title = $row1['local_schedule'];
$countrytitle = $row1['country'];
$datetitle = $row1['date'];
$locationtitle = $row1['location'];
$eventtitle = $row1['event'];

$result = mysql_query("SELECT id, Name, Date, City, Region, Location, Country, HostClub, website, Contact, phone, year, info, type FROM {$table} WHERE year=$year && type='Local' ORDER BY Date ASC");
if (!$result) {
    die("Query to show fields from table failed");
}

echo "<center><table border=0 cellspacing=0 cellpadding=0 width='650' bgcolor='black'><tr>";
// row 1
echo "<td colspan='4' bgcolor='black' align=\"center\" class=\"futura_white_12pt\"><b>$year $title</b></td></tr>";
// printing table headers
echo '<tr>';
echo '<td align="center" class="futura_white_12pt" border-bottom-style: solid;>'.$countrytitle.'</span>
<td align="center" class="futura_white_12pt" border-bottom-style: solid;>'.$datetitle.'</span>
<td align="center" class="futura_white_12pt" border-bottom-style: solid;>'.$locationtitle.'</span>
<td align="center" class="futura_white_12pt" border-bottom-style: solid;>'.$eventtitle.'</span>';
echo '</b></tr>'; 
echo "<tr>";
echo "<td height= 4></td><td></td><td></td>";
echo "</tr>";

// printing table rows
$counter = 1;
$xmasdate = $year."-12-25";

while($row = mysql_fetch_array($result)){ 
$date = $row['Date'];
$checkdate = $date;
$eventid=$row['id'];

//if the event date is unknown, you can put it in as dec 25 of that year, and it will show up as TBA.
if ($checkdate == $xmasdate){
$date = "TBA";
}
else{
list($year, $month, $day) = split("-", $date);
    $date = date('F jS, Y', mktime(0, 0, 0, $month, $day, $year));
}

echo '<tr align="center">';
echo '<td width = 23 align = "center"><img src="http://'.$_SERVER['SERVER_NAME'].'/images/countryflags/square/'.$row['Country'].'.png" height = "21" width = "30"></td>';
echo '<td class="green10pt">'.$beforelink.$eventid.$afterlink.''.$date.'</a></td>
<td class="green10pt">'.$beforelink.$eventid.$afterlink.''.$row['City'].", ".$row['Region'].", ".$row['Country'].'</a></td>
<td class="green10pt">'.$beforelink.$eventid.$afterlink.''.$row['Name'].'</a></td>';
echo "</tr>";
echo "<tr>";
echo "<td height= 8></td><td></td><td></td>";
echo "</tr>";
$counter++;
} 

echo ("</table>\n"); 

mysql_free_result($result);
?><!-- InstanceEndEditable -->
<div id="footer">
<?php include $_SERVER['DOCUMENT_ROOT']."content/footer.php"; ?>
</div>
</div>
</body>

</html>