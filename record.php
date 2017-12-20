<?php session_start();
	//authentic check
	if (!$_SESSION['loginCheck']) {
		header("Location:deny.html");
	}
	if (!isset($_SESSION['account'])) {
		header("Location:deny.html");
	}
	//sql connect
	require_once('connect.php');
	$sql="SELECT event_id,event_option,time,coin,earn,category,contestant1,contestant2 FROM `transaction` NATURAL JOIN `event` WHERE transaction.event_id = event.event_id AND `account`='".$_SESSION['account']."' ORDER BY `time` DESC";
	$result=mysqli_query($conn,$sql);

    $sqlcoin="SELECT coin FROM `members_info` where account = '".$_SESSION['account']."'";
    $accoin = mysqli_query($conn,$sqlcoin);
    $money = mysqli_fetch_row($accoin); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="prediction.css" rel="stylesheet">
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span> 
				</button>
				<a id="links" class="navbar-brand" href="prediction.php">Chenlw.com</a>
			</div>
				
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav navbar-right">
					<li ><a id="account" class="prevent" href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['account']?></a></li>	
					<li ><a class="prevent pulse" href="#" id="userCoin">$<?php echo $money[0]?></a><li>
					<li ><a id="links" href="record.php">Record</a></li>
					<li ><a id="links" href="logOut.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container" style="margin-top:50px">
		<div class="row"> 
            <div class="col-md-9 col-xs-12">
                <h2>MyRecord</h2>
                <table class="table table-hover" align="l">
                    <thead>
                        <tr>
                            <th>Event id</th>
                            <th>category</th>
							<th>event_option</th>
                            <th>bet time</th>
							<th>coin</th>
							<th>earn</th>
                            <th>result</th>
                        </tr>
                    </thead>
                    <tbody style="color:red">
                        <?php
                        while($res = mysqli_fetch_assoc($result)){
                            $sql2="SELECT * FROM `result` NATURAL JOIN `event` WHERE `event_id`=".(int)$res['event_id'];
                            $result2=mysqli_query($conn,$sql2);
                            $res2 = mysqli_fetch_assoc($result2);
                            $resultStr = "";
                            if($res2 != false){
                                if($res2['pay'] == 1 && $res2['winner'] == $res['event_option']){
                                    $resultStr = "You Win";
                                    echo "<tr bgcolor='#70C1B3'><td>".$res['event_id']."</td>";
                                }
                                else if ($res2['pay'] == 1 && $res2['winner'] != $res['event_option']){
                                    $resultStr = "You Lose";
                                    echo "<tr bgcolor='#F25F5C'><td>".$res['event_id']."</td>";
                                }
                                else{
                                    echo "<tr><td>".$res['event_id']."</td>";
                                }
                            }
                            else{
                                echo "<tr><td>".$res['event_id']."</td>";
                            }
                            echo "<td>".$res['category']."</td>";
							if($res['event_option']=='1'){
								echo "<td>".$res['contestant1']."</td>";
							}else{
								echo "<td>".$res['contestant2']."</td>";
							}
							echo "<td>".$res['time']."</td>";
							echo "<td>".$res['coin']."</td>";
                            echo "<td>".$res['earn']."</td>";
                            echo "<td>".$resultStr."</td></tr>";
                        }
                        echo"</tbody>";
                        ?>
                    </table>
            </div>
            <div class="col-md-2 col-md-offset-1 col-xs-12">
                <h2><span class="glyphicon glyphicon-user"></span><?php echo $_SESSION['account'] ?></h2>
                <h3><?php echo $_SESSION['email']?></h3>
                <h3>$<?php echo $_SESSION['coin']?><h3>
                <div><a href="logOut.php"><div class="btn btn-danger">Log out</div></a></div>
                <div style="margin-top:20px"><a href="prediction.php"><div class="btn btn-success">home</div></a></div>
            </div>
        </div>
	</div>
    <script>
    $(document).ready(function(){
        $("#icon").click(function(){  
            $(this).toggleClass("glyphicon-chevron-down");
            $('tbody').each(function(){
                var list = $(this).children('tr');
                $(this).html(list.get().reverse())
            })
        });
    });
    </script>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>