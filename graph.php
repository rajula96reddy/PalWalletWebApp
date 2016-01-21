<?php
session_start();
include ('phpgraphlib.php');
$servername = "localhost";
$username = "root";
$password = "smitpatel1996";
$conn = mysqli_connect($servername, $username, $password);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
mysqli_select_db($conn,"finaldb");
$graph = new PHPGraphLib(1000,500);
$lenddata = array();
$borrowdata = array();
$all = array(array());
$sql = "SELECT LB, remote_ID, name, amount, transdate FROM firsttable";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0)
{
	while($row = mysqli_fetch_assoc($result))
	{
    	if($row['remote_ID'] == $_SERVER['REMOTE_ADDR'])
    	{
         if($row['name'] == $_SESSION["graphval"])
         {
            if($row['LB'] == 'L')
            {
               if(array_key_exists($row['transdate'], $lenddata))
               {
                  $lenddata[$row['transdate']] = $lenddata[$row['transdate']] + $row['amount'];
               }
               else
               {
                  $lenddata[$row['transdate']] = $row['amount'];   
               }   
               
            }   
            else
            {
               if(array_key_exists($row['transdate'], $borrowdata))
               {
                  $borrowdata[$row['transdate']] = $borrowdata[$row['transdate']] + $row['amount'];
               }
               else
               {
                  $borrowdata[$row['transdate']] = $row['amount'];   
               }
            }                  
         }   
	  	}	
  	}
}
$graph->addData($lenddata,$borrowdata);
$graph->setXValuesHorizontal(TRUE);
$graph->setTextColor('blue');
$graph->setBarColor('green','red');
$graph->setLegend(TRUE);
$graph->setLegendTitle('Lended','Borrowed');
$graph->createGraph();
?>