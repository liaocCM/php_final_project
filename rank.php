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
	$sql="SELECT account,coin FROM `members_info` ORDER BY `members_info`.`coin` DESC";
	$result=mysqli_query($conn,$sql);
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
	<div class="container">
		<div class="row"> 
            <div class="col-md-8 col-xs-3">
                <h1><a href="prediction.php" style="text-decoration:none">ChenLW.com</a></h1>
                <h2>Ranking</h2>
                <table class="table table-hover" align="l">
                    <thead>
                        <tr>
                            <th>account</th>
                            <th>coin <span id="icon" class="glyphicon glyphicon-chevron-up"></span></th>
                        </tr>
                    </thead>
                    <tbody style="color:red">
                        <?php
                        while($res = mysqli_fetch_assoc($result)){
                            echo "<tr><td>".$res['account']."</td>";
                            echo "<td>".$res['coin']."</td></tr>";
                        }
                        echo"</tbody>";
                        ?>
                    </table>
            </div>
            <div class="col-md-2 col-xs-1">
            </div>
            <div class="col-md-2 col-xs-1">
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
