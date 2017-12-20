<?php session_start();
    if (!$_SESSION['loginCheck']) {
		header("Location:deny.html");
	}
?>
<!DOCTYPE html>
<html lang="en">
        <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Forbidden</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
        <?php
	        require_once('connect.php');

	        $account=$_SESSION['account'];

            $eventId= $_POST['tid'];
            $eventOp= $_POST['tchoice'];
            $coin = $_POST['tcoin'];

            $sql = "select * from transaction";
            $re1 = mysqli_query($conn,$sql);
            $num = mysqli_num_rows($re1);

            date_default_timezone_set("Asia/Taipei");
            $date = date('Y/m/d h:i:s', time());
         
            if ($eventOp=='1') {
                $sqlQuery="SELECT odds1 FROM event WHERE `event_id`= ".$eventId;
                $result = mysqli_query($conn,$sqlQuery);
                $row = mysqli_fetch_assoc($result);
                $earn = (float)$coin * $row['odds1'];
                $odd = $row['odds1'];
            }
            else {
                $sqlQuery="SELECT odds2 FROM event WHERE `event_id`= ".$eventId;
                $result = mysqli_query($conn,$sqlQuery);
                $row = mysqli_fetch_assoc($result);
                $earn = (float)$coin * $row['odds2'];
                $odd = $row['odds2'];
            }
			$findCoin = "SELECT coin FROM members_info WHERE `account`='".$account."'";
            $ownCoin = mysqli_query($conn,$findCoin);
			$rowCoin = mysqli_fetch_assoc($ownCoin);
			$finalCoin = (int)$rowCoin['coin'] - (int)$coin;
			$_SESSION['coin'] = $finalCoin;
			$minusCoin_sql = "UPDATE `members_info` SET `coin` = ".$finalCoin."  WHERE `account`='".$account."'";
            $insert_sql = "INSERT INTO `transaction` (`account`, `event_id`, `event_option`, `time`, `coin`, `earn`) 
                        VALUES ('$account', '$eventId', '$eventOp', '$date', '$coin', '$earn');";
            mysqli_query($conn,$insert_sql);
			mysqli_query($conn,$minusCoin_sql);
        ?>
        <div class = "container">
            <div class = "row">
                <div class = "col-sm-12">
                    <h1><strong>This is your transaction info.</strong></h1>
                    <h3>Please check carefully.</h3>
                    <h2>Account: <?php echo $account?></h2>
                    <h2>Event: <?php echo $eventId?></h2>
                    <h2>Option: <?php echo $eventOp?></h2>
                    <h2>Time: <?php echo $date?></h2>
                    <h2>Coin: <?php echo $coin?> X <?php echo $odd?>(Odd) = Money will earn: <?php echo $earn?></h2>
                    <h2>
					<?php
						if ($_SESSION['adminCheck']) {
							echo "<a href=\"administrator.php\">";
						}
						else{
							echo "<a href=\"prediction.php\">";
						}
					?>
					<div class="btn btn-lg btn-success">Back</div></a> to prediction page.</h2>
                </div>
            </div>
        </div>    
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        </body>
</html>