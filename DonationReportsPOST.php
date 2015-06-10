<?php
//DonationReportsPOST.php demonstrates HTML Forms and use of POST data
//
$Links = "<a href=link.html>Report selection page</a>";
if (!isset($_GET["View"])  and !isset($_POST["View"])) {
  $Report = "No report was selected.  Please select a report by clicking on a link on the report selection page...";
} else {
  //Connect to MySQL and select database EBUS202
  $MySQLCnxn = mysql_connect('localhost', 'EBUS202', 'EBUS202');
  if (!$MySQLCnxn) {
    print "Unable to connect to the MySQL server at this time...";
    exit;
  }
  $SelectedDB = mysql_select_db('EBUS202', $MySQLCnxn);
  if (!$SelectedDB) {
    print "Unable to select the EBUS202 database at this time...";
    exit;
  }
  //Make $UI or $Report as needed
  $UI = "";  
  $Report = "";
  //$View will be in GET if it's in a link or in POST data if it's from an HTML FORM
  if (isset($_GET["View"])) {
    $View = $_GET["View"];
  } else {
    $View = $_POST["View"];
  }
  if ($View == "SelectRegion") {
    $UI .= "Select a Region and click DetailsForRegion to see the report:<br><br>\r\n";
    //Construct a select named WhichRegion
    $SQLStmt = "select Id, RegionName from Regions order by RegionName";  
    $RegionResults = mysql_query($SQLStmt) or die ("Unable to do $SQLStmt at this time...");
    $UI .= "<select name=WhichRegion size=10>\r\n";
    while ($ARegion = mysql_fetch_assoc($RegionResults)) {
      extract($ARegion);
      $UI .= "<option value=$Id>$RegionName\r\n";
    }
    $UI .= "</select>";
    $UI .= "<br><br>Click <input type=submit name=View value=DetailsForRegion> to report the selected region...\r\n";
    $UI .= "<br><br><input type=submit name=View value='Show Form Data'> <br><br>\r\n";

  } elseif ($View == "DetailsForRegion") {
    //Make sure WhichRegion has been supplied
    if (!isset($_POST["WhichRegion"]) or $_POST["WhichRegion"] == "") {
      $Report = "<font color=red>* </font>Please select a Region before clicking the DetailsForRegion button...";
    } else {
      //Make the SQL Statement
      $WhichRegion = $_POST["WhichRegion"];
      $SQLStmt = "select VolunteerName, MemberName, Amount, AccountingDate from Donations, Volunteers
                  where RegionId='$WhichRegion' and Volunteers.Id=VolunteerId 
		  order by VolunteerName, MemberName";
      //Use SQLStmt in a query to get RegionResults
      $RegionResults = mysql_query($SQLStmt) or die ("Unable to access database at this time...");
      //Setup $Report's header
      $Report = "<table><tr><th>Volunteer</th><th>Donor</th><th>Amount</th></tr>\r\n";
      $TotalForRegion = 0;
      //Concatenate each ARow onto Results 
      while ($ARow = mysql_fetch_assoc($RegionResults)) {
        extract($ARow);
	$AmountFormatted = number_format($Amount,2);
	$TotalForRegion += $Amount;
	$Report .= "<tr><td>$VolunteerName</td><td>$MemberName</td><td>$Amount</td></tr>";
        //$Report .= "$VolunteerName - $MemberName - $Amount = $AccountingDate<br>";
      }
      $Report .= "</table><br><br>\r\n";
      $TotalFormatted = number_format($TotalForRegion,2);
      $Report = "Total donations for Region #$WhichRegion: \$$TotalFormatted<br><br>\r\n" . $Report;
    }
  } elseif ($View == "Select3DigitZip") {
    $UI .= "Select a 3-digit Zip and click CalcZipStats to see the stats:<br><br>\r\n";
    //Construct a select named WhichRegion
    $SQLStmt = "select distinct left(Zip,3) as Zip3 from Donations order by Zip3";  
    $ZipResults = mysql_query($SQLStmt) or die ("Unable to do $SQLStmt at this time...");
    $UI .= "<select name=Which3Digits size=20>\r\n";
    while ($AZip = mysql_fetch_assoc($ZipResults)) {
      extract($AZip);
      $UI .= "<option value=$Zip3>$Zip3</option>\r\n";
    }
    $UI .= "</select>";
    $UI .= "<br><br>Click <input type=submit name=View value=CalcZipStats> to calc stats for selected zip...\r\n";
    $UI .= "<br><br><input type=submit name=View value='Show Form Data'> <br><br>\r\n";

  } elseif ($View == "CalcZipStats") {
    //Make sure WhichRegion has been supplied
    if (!isset($_POST["Which3Digits"]) or $_POST["Which3Digits"] == "") {
      $Report = "<font color=red>* </font>Please select a 3Digits before clicking the DetailsFor3Digits button...";
    } else {
      //Make the SQL Statement
      $Which3Digits = $_POST["Which3Digits"];
      $SQLStmt = "select VolunteerName, MemberName, Amount, AccountingDate from Donations, Volunteers
                  where left(Zip,3)='$Which3Digits' and Volunteers.Id=VolunteerId 
		  order by VolunteerName, MemberName";
      //Use SQLStmt in a query to get RegionResults
      $DigitsResults = mysql_query($SQLStmt) or die("Unable to get 3digitresults using '$SQLStmt'...");
      //Setup $Report's header
      $Report = "<table><tr><th>Volunteer</th><th>Donor</th><th>Amount</th></tr>\r\n";
      $TotalFor3Digits = 0;
      $CountFor3Digits = 0;
      //Concatenate each ARow onto Results 
      while ($ARow = mysql_fetch_assoc($DigitsResults)) {
        extract($ARow);
	$AmountFormatted = number_format($Amount,2);
	$TotalFor3Digits += $Amount;
	$CountFor3Digits ++;
	$Report .= "<tr><td>$VolunteerName</td><td>$MemberName</td><td>$Amount</td></tr>";
        //$Report .= "$VolunteerName - $MemberName - $Amount = $AccountingDate<br>";
      }
      $Report .= "</table><br><br>\r\n";
      $TotalFormatted = number_format($TotalFor3Digits,2);
      $TheAverage = $TotalFor3Digits / $CountFor3Digits;
      $AvgFormatted = number_format($TheAverage,2);
      $Report = "<p>Stats for 3-digit Zip $Which3Digits:</p>
                    <p>Count: $CountFor3Digits</p>
                    <p>Total \$: $TotalFormatted</p>
                    <p>Average \$: $AvgFormatted</p>
                    
                    \r\n" . $Report;
      //$Report = "<p>Total donations for 3-digit Zip $Which3Digits: \$$TotalFormatted<br><br>\r\n" . $Report;
    }
  } elseif ($View == "Show Form Data") {
    $Report = "GET Data:<br>";
    while ($AVar = each($_GET)) {
        $Report .= "$AVar[0] = '$AVar[1]'<br>";
    }
    $Report .= "POST Data:<br>";
    while ($AVar = each($_POST)) {
        $Report .= "$AVar[0] = '$AVar[1]'<br>";
    }
    $Report .= "SERVER Data:<br>";
    while ($AVar = each($_SERVER)) {
        $Report .= "$AVar[0] = '$AVar[1]'<br>";
    }

  } else {
    //Somehow they got here without a valid report in $WhichReport
    $Report = "No valid report was selected...";  
  }
}
?>
<!DOCTYPE html>
 <head>
	<title>POST Data from Server</title>
	<link rel="stylesheet" href="index.css" />
	 <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <meta name="theme-color" content="#ffffff"> </head>
 <body><form method=POST action="<?php print $_SERVER['PHP_SELF']; ?>">
	<div id = title>
	<h1 id="h1special">PHP/POST</h1>
        <a href="index.html"><p id="pspecial">Home</p></a>
        <hr />
		</div>
		
	<div class="wrapper">

  <?php 
   print "$Report";
   print "$UI";  
   print "<br><br>$Links";
  ?>
  </div>
 </form>
 
 </body>
</html>