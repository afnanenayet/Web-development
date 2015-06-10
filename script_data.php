<?php
$Links = "<a href=link.html>Reports</a> | <a href=index.html>Home";
if (!isset($_GET["WhichReport"])) {
  $Report = "No report was selected.  Please select a report by clicking on a link on the report selection page...";
} else {
  $MySQLCnxn = mysql_connect('localhost', 'aenayet', 'Aayet');
  if (!$MySQLCnxn) {
    print "Unable to connect to the server at this time...";
    exit;
  }
 $SelectedDB = mysql_select_db('aenayet', $MySQLCnxn);
  if (!$SelectedDB) {
    print "Can't connect to aenayet database";
    exit;
  }
 $WhichReport = $_GET["WhichReport"];
  if ($WhichReport == "Sample1") {
    
    $SQLStmt = "SELECT * from Orders;";
	   $RegionResults = mysql_query($SQLStmt) or die ("Unable to access database at this time...");
	 $Report = "<h1>Orders</h1><table><tr><th>ID</th><th>Email Address</th><th>First Name</th><th>Last Name</th><th>Notes</th><th>Amount</th><th>Timestamp</th></tr>";
	     while ($ARow = mysql_fetch_assoc($RegionResults)) {
      extract($ARow);
      $Report .= "<tr><td>$SampleId</td><td>$EmailAddress</td><td>$FirstName</td><td>$LastName</td><td>$Notes</td><td>$$Amount</td><td>$DateTimeCreated</td>";
    }
  }
	
	/*else if($WhichReport == "FinalExam") {
		$SQLStmt = "SELECT * from Final;";
		$myQuery = mysql_query($SQLStmt) or die ("Unable to access database at this time...");
		$Report = "<h1>Final Exam Q9</h1><table><tr><th>SampleID</th><th># Whip Eggs</th><th># Round Eggs</th><th># Hook Eggs</th><th>Other</th><th>Created DT</th><th>Created By</th></tr>";
	     while ($ARow = mysql_fetch_assoc($myQuery)) {
      extract($ARow);
      $Report .= "<tr><td>$SampleId</td><td>$Type</td><td>$WhipEggs</td><td>$RoundEggs</td><td>$HookEggs</td><td>$Other</td><td>$CreatedDT</td><td>CreatedBY</td>";
	}*/
	
	/*else if ($WhichReport == "Final") {
    
    $SQLStmt = "SELECT * from Orders order by SampleId ASC;";
	   $RegionResults = mysql_query($SQLStmt) or die ("Unable to access database at this time...");
	 $Report = "<h1>Orders</h1><table><tr><th>SampleId</th><th>Type</th><th># Whip Eggs</th><th># Round Eggs</th><th># Hook Eggs</th><th>Other</th><th>CreatedDT</th><th>Created By</th></tr>";
	     while ($ARow = mysql_fetch_assoc($RegionResults)){
         extract($ARow);
         $Report .= "<tr><td>$SampleId</td><td>$Type</td><td>$WhipEggs</td><td>$RoundEggs</td><td>$HookEggs</td><td>$Other</td><td>$CreatedDT</td><td>CreatedBY</td>";
        }
    }*/
}

?>


<!DOCTYPE html>
<head>
<title> Customers </title>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="index.css" />

    <link rel="apple-touch-icon" sizes="57x57" href="apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="manifest" href="manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>
<body>
<div id="title">
        <h1 id="h1special">Donations</h1>
        <p id="pspecial"><a href="index.html">Watches</a> | <a href="link.html">Reports</a></p>
        <hr />
    </div>
    <div class="wrapper">
	
			
        <?php
		print "$Report";
		?> 
		</table>
    </div>
</body>
</html>

	
	