<?php session_start(); ?>
<?php
	if($_SESSION['Email']){

	if (isset($_GET['logout'])){ //logout
		session_destroy();
		header('Location: /hw3/sign-in.php');
	}

	if(!@mysql_connect('localhost:49320', 's604410097', 's604410097'))
	{
		die("無法對資料庫連線");
	}
	
	if(!@mysql_select_db('s604410097'))
	{
		die("無法對資料庫連線");
	}
	$Email = $_SESSION['Email'];
	$result=mysql_query('SELECT * FROM user WHERE email="'.$Email.'"');
	$row = @mysql_fetch_row($result);
	$id=$row[0];
   
    
	if (isset($_POST['submit'])&&!isset($_GET['articleid'])&&!isset($_POST['article_id'])){//creat new article
			$Title = $_POST['Title'];
			$Content = $_POST['Content'];
	        $query='INSERT INTO article (author_id , title , content , created_time , last_update) values ("'.$id.'","'.$Title.'","'.$Content.'",NOW(),NOW())';
			mysql_query($query);
			header('Location: /hw3/main.php');	
		
	}
    else if (isset($_GET['articleid'])){
			
			 
            $result=mysql_query('SELECT * FROM article WHERE id="'.$_GET['articleid'].'" and author_id="'.$id.'"');
            $row2 = @mysql_fetch_row($result);
            if($row2==null)
            {
               header('Location: /hw3/article.php');
            }
			$Title = $row2[2];
            $Content =$row2[3];
            $articleid = $row2[0];
		
	}
     else if (isset($_POST['article_id'])){
			
			 $Title = $_POST['Title'];
			$Content = $_POST['Content'];
            $aid=$_POST['article_id'];
            mysql_query('UPDATE article SET title="'.$Title.'" ,content="'.$Content.'",last_update=NOW()  WHERE id='.$aid.';');
            header('Location: /hw3/main.php?articleid='.$aid);
		
	}
	}
else {header('Location: /hw3/sign-in.php?login');}//login

?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<title>YY Forum</title>
	<link rel="icon" href="icon.png" type="image/x-icon">
 
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<body >
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
					<li ><a class="glyphicon glyphicon-home" href='/hw3/main.php'>Home</a></li>
					<li ><a class="glyphicon glyphicon-user" href='<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?logout'>Logout</a></li>
					
				</ul>
			</div>
		</div>
	</nav>
	<div class="container" role="main">
		<div class="row ">
			<div class="col-xs-6 col-md-6">
			<p style="font-size:15px"><em>Welcome back,<?php echo $_SESSION['Username'];?></em><p/>
			</div>
		</div>
	<br/><br/>
		<div class="col-md-3 col-xs-2"></div>
		<div class="col-md-6 col-xs-8">
		<form  id="articleform" class="form-horizontal"  role="form" method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" data-toggle="validator"  >
			<div class="form-group text-center">
			<?php if (!isset($_GET['articleid'])){echo '<h2><i class="fa fa-pencil-square-o" aria-hidden="true"></i><strong> 發表新文章</strong><h2>';}
                   else if (isset($_GET['articleid'])){echo '<h2><i class="fa fa-pencil-square-o" aria-hidden="true"></i><strong> 修改文章</strong><h2>';}
            ?>
			</div>
			<div class="form-group " >
			 <label for="Title" class="control-label col-sm-2">標題</label>
			 <div class="col-sm-10">
			 <input type="text" placeholder="Title" class="form-control " id="Title" data-error="The title is required!" name="Title" <?php if (isset($_GET['articleid'])){echo 'value="'.$Title.'"'; }?>  required>			 
			<div class="help-block with-errors"></div>
            </div>
			</div>
						<div class="form-group " >
			 <label for="Title" class="control-label col-sm-2">內容</label>
			 <div class="col-sm-10">
			 <textarea class="form-control" placeholder="Content" rows="6" id="Content" data-error="The content is required!"  name="Content" required><?php if (isset($_GET['articleid'])){echo $Content; }?></textarea>		 
			<div class="help-block with-errors"></div>
            </div>
			</div>
				<div class="form-group text-center"  style="height:50px">
				<?php if (!isset($_GET['articleid'])){echo '<button type="submit" class="btn btn-info " name="submit">發表主題</button>';}
                       else if (isset($_GET['articleid'])){echo '<button type="submit" class="btn btn-info " name="submit">儲存</button>';}
                ?>  | 
				<a class="btn btn-default" href='/hw3/main.php'><i class="fa fa-home" aria-hidden="true"></i>Home</a> <br/>
				</div>
                <?php if (isset($_GET['articleid'])){echo '<input type="hidden"  value="'.$articleid.'" name="article_id">';}?>
		
		</form>
		</div>
	
	</div>


	
</body>
</html>