<?php session_start(); ?>
<?php
 $check=0;
 if($_SESSION['Email']){
	 
	 header('Location: /hw3/main.php');
 }

	if(!@mysql_connect('localhost:49320', 's604410097', 's604410097'))
	{
		die("無法對資料庫連線");
	}
	
	if(!@mysql_select_db('s604410097'))
	{
		die("無法對資料庫連線");
	}
	if($_SERVER["REQUEST_METHOD"] == "POST"){
	$Email = $_POST['Email'];
	$pw = $_POST['pw'];
	$sql ='SELECT * FROM user where Email = "'.$Email.'"';
	
	$result = mysql_query($sql);
	$row = @mysql_fetch_row($result);
	
	if($row[2]==$Email&&$row[3]==$pw)
	{
		   $_SESSION['Email'] = $Email;
		   $_SESSION['Username'] = $row[1];
			header('Location: /hw3/main.php');
	}
	else if($row==null)
	{
		  
			$check=1;

	}
	else if($row[3]!=$pw)
	{
		  
			$check=2;
	}
	}
	?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<title>login</title>
	<link rel="icon" href="icon.png" type="image/x-icon">
 
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<body <?php if($check==1||isset($_GET['login'])){echo 'onLoad="document.getElementById('."'Email'".').focus();"';} else if($check==2){echo 'onLoad="document.getElementById('."'pw'".').focus();"';} ?>>
	
	<script src="http://code.jquery.com/jquery-2.2.3.js" integrity="sha256-laXWtGydpwqJ8JA+X9x2miwmaiKhn8tVmOVEigRNtP4=" crossorigin="anonymous"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src="js/validator.min.js"></script>
	
	<nav class="navbar navbar-inverse navbar-static-top" role=navigation >
		<div class=container>
			<div class=navbar-header>
				<button type=button class="navbar-toggle collapsed" data-toggle=collapse data-target=#navbar aria-expanded=false aria-controls=navbar> 
					<span class=sr-only>Toggle navigation</span> 
					<span class=icon-bar></span> 
					<span class=icon-bar></span> 
					
				</button> 
				<a class="navbar-brand fa fa-info" href='/hw3/main.php' style="font-size:20px;color:#00DD00;"><strong> YY Forum</strong></a>
			</div>
			<div id=navbar class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					<li ><a class="glyphicon glyphicon-home " href='/hw3/main.php'>Home</a></li>
					<li class=active><a class="glyphicon glyphicon-user" href='/hw3/sign-in.php'>Login</a></li>
					
				</ul>
			</div>
		</div>
	</nav>
	<div class="container"  role="main" >
		<div class="jumbotron" style="line-height: 20px;">
			<h2>Welcome to YY Forum</h2>
			<p >Login and have fun!<br/>If you don't have any account, please register one right now!</p>
			<form id="checkform" class="form-inline row"  role="form" method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" data-toggle="validator"   >
				
				<div class="form-group <?php if($check==1){echo'has-error';}?>" id="mailinput" style="height:50px">
					<input type="email" placeholder=Email class="form-control" data-error="信箱格式錯誤" id="Email" name="Email" onblur="dohide()" onkeydown="dohide()" <?php if($check==1||$check==2){echo 'value="'.$Email.'"';}?> required>
					<div class="help-block with-errors "><?php if($check==1):?><span style="color:#AA0000" id="mailerror">信箱錯誤!</span><?php endif?></div>
					
				</div>	
				<div class="form-group <?php if($check==2){echo'has-error';}?>" style="height:50px">
					<input type=password  placeholder=Password class=form-control id="pw" name="pw" onkeydown="dohide2()"  onblur="dohide2()" required>
					<div class="help-block with-errors"><?php if($check==2):?><span style="color:#AA0000" id="pwerror">密碼錯誤!</span><?php endif?></div>
				</div>
				<div class="form-group "  style="height:50px">
				<button type=submit class="btn btn-info btn-primary ">Sign in</button>  | 
				<a class="btn btn-success" href='/hw3/creataccount.php'>Create new account</a> <br/>
				</div>
				
			</form>
			<?php if(isset($_GET['login'])){ echo '
			<div class="alert alert-danger alert-dismissible fade in col-md-5" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<strong>你必須先登入!</strong> 
			</div>';
			}
			?>
			
		</div>
	</div>

	<script>
	function dohide()
	{
		
		$('#mailerror').addClass('hidden');
	
	}
		function dohide2()
	{
		
		$('#pwerror').addClass('hidden');
	
	}
	</script>
	
</body>
</html>