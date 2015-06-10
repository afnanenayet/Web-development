<?php
$Links = "<a href=index.html>Home";
if (!isset($_GET["WhichReport"])) {
  $Report = "No report was selected.  Please select a report by clicking on a link on the report selection page...";
} else {
  $MySQLCnxn = mysql_connect('localhost', 'aenayet', 'Aayet');
  if (!$MySQLCnxn) {
    print "Unable to connect to the MySQL server at this time...";
    exit;
  }
 $SelectedDB = mysql_select_db('aenayet', $MySQLCnxn);
  if (!$SelectedDB) {
    print "Unable to select the EBUS202 database at this time...";
    exit;
  }
 $WhichReport = $_GET["WhichReport"];
  if ($WhichReport == "final") {
    
    $SQLStmt = "SELECT * from Final order by SampleId asc;";
	   $RegionResults = mysql_query($SQLStmt) or die ("Unable to access database at this time...");
	 $Report = "<table><tr><th>SampleId</th><th>Type</th><th># Whip Eggs</th><td> # Round Eggs </td><td># Hook Eggs</td><td>Other</td><td>Created DT</td><td>Created By</td></tr>";
	     while ($ARow = mysql_fetch_assoc($RegionResults)) {
      extract($ARow);
      $Report .= "<tr><td>$SampleId</td><td>$Type</td><td>$WhipEggs</td><td>$RoundEggs</td><td>$HookEggs</td><td>$Other</td><td>$CreatedDT</td><td>$CreatedBY</td>";
    }
}

else if ($WhichReport == "Top10") {
	$SQLStmt = "SELECT MemberName, Amount FROM Donations ORDER BY Amount DESC LIMIT 10;";
	   $RegionResults = mysql_query($SQLStmt) or die ("Unable to access database at this time...");
	 $Report = "<h1>Top 10 Donors</h1><table><tr><th>Donor</th><th>Amount</th></tr>";
	     while ($ARow = mysql_fetch_assoc($RegionResults)) {
      extract($ARow);
      $Report .= "<tr><td>$MemberName</td><td>$$Amount</td>";
    }
}

else if ($WhichReport == "byRegion") {
	$SQLStmt = "SELECT Zip, SUM(Amount) as SUMAMOUNT FROM Donations group by Zip order by SUMAMOUNT desc;";
	   $RegionResults = mysql_query($SQLStmt) or die ("Unable to access database at this time...");
	 $Report = "<h1>Donations by Region</h1><table><tr><th>Zip</th><th>Amount</th></tr>";
	     while ($ARow = mysql_fetch_assoc($RegionResults)) {
      extract($ARow);
      $Report .= "<tr><td>$Zip</td><td>$$SUMAMOUNT</td>";
    }
}
//select Volunteers.EmailAddress FROM Volunteers inner join Donations where Volunteers.VolunteerName = Donations.MemberName;


else if ($WhichReport == "oneRegion") {
	$SQLStmt = "SELECT Zip, SUM(Amount) as SUMAMOUNT FROM Donations group by Zip order by SUMAMOUNT desc;";
	   $RegionResults = mysql_query($SQLStmt) or die ("Unable to access database at this time...");
	 $Report = "<h1>Donations by Region</h1><table><tr><th>Zip</th><th>Amount</th></tr>";
	     while ($ARow = mysql_fetch_assoc($RegionResults)) {
      extract($ARow);
      $Report .= "<tr><td>$Zip</td><td>$$SUMAMOUNT</td>";
    }
}
	
	else if ($WhichReport == "CCinfo") {
	$SQLStmt = "SELECT concat(FirstName, ' ', LastName) as fullname, CCType, CCNumber, CVV2 FROM Entities order by LastName limit 50;";
	   $RegionResults = mysql_query($SQLStmt) or die ("Unable to access database at this time...");
	 $Report = "<h1>Credit Card Information</h1><table><tr><th>Name</th><th>Credit Card Type</th><th>Credit Card Number</th><th>CVV2</th></tr>";
	     while ($ARow = mysql_fetch_assoc($RegionResults)) {
      extract($ARow);
      $Report .= "<tr><td>$fullname</td><td>$CCType</td><td>$CCNumber</td><td>$CVV2</td></tr>";
    }
}
	
	else if ($WhichReport == "fatty") {
	$SQLStmt = "select avg(WeightUSPounds) as weight, City, State from Entities where State = 'VA' group by City order by weight;";
	   $RegionResults = mysql_query($SQLStmt) or die ("Unable to access database at this time...");
	 $Report = "<h1>How Much Does Each City Weigh?</h1><table><tr><th>City</th><th>Avg Weight (lbs)</th>";
	     while ($ARow = mysql_fetch_assoc($RegionResults)) {
      extract($ARow);
      $Report .= "<tr><td>$City</td><td>$weight</td></tr>";
    }
}
	
	else if ($WhichReport == "efficacy") {
	$SQLStmt = "select coalesce(RegionName, 'Grand Tot') as Region1, coalesce(VolunteerName,'Region Tot') as Volunteer1, sum(Amount) as sumamount from Donations join Regions on RegionId=Regions.Id join Volunteers on VolunteerId=Volunteers.Id group by RegionName, VolunteerName order by sumamount desc;";
	   $RegionResults = mysql_query($SQLStmt) or die ("Unable to access database at this time...");
	 $Report = "<h1>Volunteer Information</h1><table><tr><th>Volunteer</th><th>Region</th><th>Amount</th></tr>";
	     while ($ARow = mysql_fetch_assoc($RegionResults)) {
      extract($ARow); 
      $Report .= "<tr><td>$Volunteer1</td><td>$Region1</td><td>$$sumamount</td></tr>";
    }
}
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
        <h1 id="h1special">Final Exam Question 9</h1>
        <p id="pspecial"><a href="index.html">Watches</a></p>
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

	
	