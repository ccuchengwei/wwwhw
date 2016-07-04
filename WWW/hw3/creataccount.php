<?php session_start(); ?>
<?php
 $check=0;

	if(!@mysql_connect('localhost:49320', 's604410097', 's604410097'))
	{
		die("無法對資料庫連線");
	}
	
	if(!@mysql_select_db('s604410097'))
	{
		die("無法對資料庫連線");
	}
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$Name =	$_POST['name'];
		$Email = $_POST['Email'];
		$pw = $_POST['pw'];
		$sql ='SELECT * FROM user where Email = "'.$Email.'"';
		$result = mysql_query($sql);
		$row = @mysql_fetch_row($result);
	if(mysql_num_rows($result)==0)
        {
						$query="INSERT INTO user (name,email,password) values ('".$Name."','".$Email."','".$pw."')";
						mysql_query($query);
						$_SESSION['Email']=$Email;
                        $_SESSION['Username'] = $Name;
						header('Location: /hw3/main.php');
				}
	else 
	{
		   $check_email=1;
	}

	}
	?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<title>Creat New Account</title>
	<link rel="icon" href="icon.png" type="image/x-icon">
 
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<body <?php if($check_email==1){echo 'onLoad="document.getElementById('."'Email'".').focus();"';}?>>
	
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
				<a class="navbar-brand fa fa-info" href='/hw3/main.php'style="font-size:20px;color:#00DD00;"><strong> YY Forum</strong></a>
			</div>
			<div id=navbar class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					<li ><a class="glyphicon glyphicon-home" href='/hw3/main.php'>Home</a></li>
					<li ><a class="glyphicon glyphicon-user" href='/hw3/sign-in.php'>Login</a></li>
					
				</ul>
			</div>
		</div>
	</nav>
	<div class="container"  role="main" >
		<div class="row " >
			<div class="col-md-4"></div>
			
			<form  id="registform" class="col-md-4" role="form" method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" data-toggle="validator"  >
				<h2><i class="fa fa-user-plus"></i>Create a new account</h2><br/>
				<div class="form-group "  >
					<label for="name" class="control-label">暱稱</label>
					<input type="text" placeholder="User name" class=form-control id="name" name="name" required >
					<div class="help-block with-errors"></div>
					
				</div>	
				
				<div class="form-group <?php if($check_email==1){echo'has-error';}?>" >
					<label for="Email" class="control-label">電子信箱</label>
					<input type="email" placeholder="Use this as login account" class=form-control id="Email" name="Email" onblur="dohide()" onkeydown="dohide()" <?php if($check_email==1){echo 'value="'.$Email.'"';}?> required >
				<div class="help-block with-errors"><?php if($check_email==1):?><span style="color:#AA0000" id="mailerror">信箱已被註冊!</span><?php endif?></div>
				</div>	
				
				
				<div class="form-group " >
					<label for="pw" class="control-label">密碼</label>
					<input type=password  placeholder=Password class=form-control id="pw" name="pw" data-minlength="7" data-minlength-error="密碼至少7個字!" required>
					<div class="help-block with-errors"></div>
					
				</div>
				<div class="form-group " >
					<label for="pw" class="control-label">密碼確認</label>
					<input type=password  placeholder="Enter password again" class="form-control" data-match="#pw" data-match-error="密碼確認錯誤!" id="agpw" name="agpw" required>
					<div class="help-block with-errors"></div>
					
				</div>
				<br/>
				<div class="form-group text-center"  >
				
						
				<a class="btn btn-default"  onclick="history.back()" >Cancel</a>  
				<button type=submit class="btn  btn-success ">Create&Login!</button> 
				<?php if($check_email==1){echo '<input type="hidden"  value="'.$Email.'" name="repeatmail">';}?>
				</div>
				
			</form>
			<div class="col-md-4"></div>            
			
		</div>
		
	</div>
		<script>
	function dohide()
	{
		
		$('#mailerror').addClass('hidden');
	
	}

	</script>

	
</body>
</html>