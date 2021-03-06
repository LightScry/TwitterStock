<?php

/*
		1) Query for all Moods --> order by date
		2) Calculate averages for each day
		3) Format JSON
		4) Return JSON
*/

// Parameters
$symbol = $_GET['symbol'];
$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];

try 
{
  // Open the database
  $db = new PDO('sqlite:actualdata.sqlite');
  $sql = "SELECT Mood,Weight,DateBin FROM Tweets WHERE (Date>='$startDate' AND Date<='$endDate' AND Keyword=='$symbol')" ;

  // Perform the query
  $statement = $db->prepare($sql);
  $statement->execute();
  $results=$statement->fetchAll(PDO::FETCH_ASSOC);

  // Sum the Mood values for each DateBin in the range
  $totals = array();
  $weights = array();
  foreach($results as $row){
    if (!array_key_exists($row["DateBin"],$totals)){
      $totals[$row["DateBin"]]=$row["Mood"]*$row["Weight"];
      weights[$row["DateBin"]]=$row["Weight"];
    }
    else {
      $totals[$row["DateBin"]]+=$row["Mood"]*$row["Weight"];
      weights[$row["DateBin"]]+=$row["Weight"];
    }
  }

  // Calculate the average Mood for each DateBin in the range
  $averages = array();
  foreach($totals as $datebin => $val){
    $averages[$datebin]=$val/$weights[$datebin];
  }

  // Format & output results
  $json=json_encode($averages);
  echo $json;
}
catch(Exception $e) 
{
  die($error);
}

?>
    