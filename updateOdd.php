<?php session_start();
	if (!$_SESSION['loginCheck']) {
		header("Location:deny.html");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="refresh" content="30">
	<style type="text/css">
	body {
    	margin: 0;
    	height: 100%;
		background-image:url(img/animal.gif);
		/*background-size:cover;*/
	}
	</style>
</head>
<body>
	<?php 
	//sql connect
	require_once('connect.php');

	//updateOdd
	$sql="SELECT * FROM event";
	$result=mysqli_query($conn,$sql);
	while($row=mysqli_fetch_row($result)){
		$totalCoin=0;
		$coin1=0;
		$coin2=0;
		$odd1;
		$odd2;
		$eventId=$row[0];
		$sql2="SELECT * FROM transaction WHERE `event_id` = ".$eventId;
		$result2=mysqli_query($conn,$sql2);

		while($row2=mysqli_fetch_assoc($result2)){
			if($row2["event_option"] == 1){
				$coin1 += $row2["coin"];
				$totalCoin += $row2["coin"];
			}
			else if($row2["event_option"] == 2){
				$coin2 += $row2["coin"];
				$totalCoin += $row2["coin"];
			}
		}
		
		if ($totalCoin == 0 or $coin1 == 0 or $coin2 == 0){
			$odd1 = 2;
			$odd2 = 2;
		}
		else{
			$odd1 = $totalCoin/$coin1;
			$odd2 = $totalCoin/$coin2;
		}
		
		$sql3="UPDATE `event` SET `event_id`=$row[0],`date`='$row[1]',`category`='$row[2]',`contestant1`='$row[3]',`odds1`=$odd1,`contestant2`='$row[5]',`odds2`=$odd2 WHERE `event_id`=$row[0]" ;
		mysqli_query($conn,$sql3);
	}	

	//give me money

	$sql4="SELECT * FROM `result` NATURAL JOIN `event` WHERE `pay` = False";
	$result4=mysqli_query($conn,$sql4);
	while($row4=mysqli_fetch_assoc($result4)){
		if (gettingDate($row4["date"]) == gettingDate(date("Y-m-d"))){
			$sql5="SELECT * FROM `transaction` WHERE `event_id` = ".(int)$row4["event_id"]." AND `event_option` = ".(int)$row4["winner"];
			$result5=mysqli_query($conn,$sql5);
			while($row5=mysqli_fetch_assoc($result5)){
				$sql6="SELECT `coin` FROM `members_info` WHERE `account` = '".$row5["account"]."'";
				$coin=(int)mysqli_fetch_assoc(mysqli_query($conn,$sql6))["coin"];
				$earn=(int)$row5["earn"];
				$totalcoin=$coin+$earn;
				$sql7="UPDATE `members_info` SET `coin`= ".$totalcoin." WHERE `account` = '".$row5["account"]."'";
				mysqli_query($conn,$sql7);
			}
			$sql8="UPDATE `result` SET `pay`= 1 WHERE `pay`= 0 AND `event_id` = ".(int)$row4["event_id"];
			mysqli_query($conn,$sql8);
		}
	}

	function gettingDate($string){
			$date = split("[-]",$string);
			$y=$date[0];
			$m=$date[1];
			$d=$date[2];
			if ($string == date("Y-m-d")){
				return $y."-".$m."-".((int)$d);
			}
			else{
				return $y."-".$m."-".((int)$d+1);
			}
			
	}
?>
</body>
</html>


