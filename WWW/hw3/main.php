<?php session_start(); 

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
       if(isset($_GET['articleid']))
    {
        $resultaid=mysql_query('SELECT * FROM article WHERE id="'.$_GET['articleid'].'"');
        $rowaid = @mysql_fetch_row($resultaid);
        $resultuid=mysql_query('SELECT * FROM user WHERE id="'.$rowaid['1'].'"');
        $rowuid = @mysql_fetch_row($resultuid);
    }
     if(isset($_POST['submitresponse']))
     {
         $Response = $_POST['Response'];
			
	        $query='INSERT INTO response (article_id ,user_id,message ,timestamp) values ("'.$_POST['article_id'].'","'.$id.'","'.$Response.'",NOW())';
			mysql_query($query);
			header('Location: /hw3/main.php?articleid='.$_POST['article_id']);	
         
     }
      else if(isset($_POST['submitdel']))
     {
         $aid = $_POST['article_id'];
			
	        mysql_query('DELETE from  article where id ='.$aid );
			mysql_query('DELETE from  response where article_id ='.$aid );
            
			header('Location: /hw3/main.php');	
         
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
	<script src="js/bootstrapValidator.min.js"></script>

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
					<li <?php if(!isset($_GET['articleid'])){echo 'class=active';}?>><a class="glyphicon glyphicon-home " href='/hw3/main.php'>Home</a></li>
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
	<?php  if(!isset($_GET['articleid'])){
    echo'
	<div>
		<div class="col-xs-8 col-md-10"></div>
		<a class="btn btn-info " href="/hw3/article.php"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>發表新主題</a> 
		<div class="col-xs-8 col-md-10"><h1 style="font-size:20px; color:#008800;"><i class="fa fa-bolt"></i>您近期更新/被留言的文章</h1></div>
        <table class="table table-striped ">
		<tr>
		<th>發表日期</th>
		<th>Author</th>
		<th>Title</th>
		<th>回覆</th>
		<th>最後更新/回覆</th>
		</tr>
		';
		
		mysql_query ('CREATE OR REPLACE VIEW last_response AS SELECT article_id,max(timestamp) AS last_time,count(timestamp) AS countreponse FROM response group by article_id');
		mysql_query ('CREATE OR REPLACE VIEW ajoined AS SELECT article.id AS article_id,author_id,title,created_time,last_update,Name FROM article,user  WHERE user.id=article.author_id');
		mysql_query ('CREATE OR REPLACE VIEW last_time AS SELECT ajoined.article_id AS article_id,author_id,title,created_time,IFNULL(countreponse,"0") AS countreponse,Name,IF(last_update>IFNULL(last_time,"0"),last_update,last_time) AS latest_time FROM ajoined LEFT JOIN last_response ON last_response.article_id=ajoined.article_id  ORDER BY latest_time desc');
		$result2= mysql_query("SELECT * FROM last_time where author_id=".$id);
		
		for($i=0;$lastupdate =  mysql_fetch_array($result2) and $i<5 ;$i++)
		{   
            
			echo '<tr/>';
			echo '<td>'.$lastupdate['created_time'].'</td>';
			echo '<td>'.$lastupdate['Name'].'</td>';
			echo '<td><a  href="/hw3/main.php?articleid='.$lastupdate['article_id'].'">'.$lastupdate['title'].'</a></td>';
			echo '<td>'.$lastupdate['countreponse'].'</td>';
			echo '<td>'.$lastupdate['latest_time'].'</td>';
			echo '</tr>';
			
		}
		echo'
        
		</table>
        <div class="col-xs-8 col-md-10"><h1 style="font-size:20px; color:#008800;"><i class="fa fa-th-list"></i>所有文章列表</h1></div>
        <table class="table table-striped ">
		<tr>
		<th>發表日期</th>
		<th>Author</th>
		<th>Title</th>
		<th>回覆</th>
		<th>最後更新/回覆</th>
		</tr>
		';
		
		
		$result2= mysql_query("SELECT * FROM last_time ");
		
        while($lastupdate =  mysql_fetch_array($result2))
		{   
            
			echo '<tr/>';
			echo '<td>'.$lastupdate['created_time'].'</td>';
			echo '<td>'.$lastupdate['Name'].'</td>';
			echo '<td><a  href="/hw3/main.php?articleid='.$lastupdate['article_id'].'">'.$lastupdate['title'].'</a></td>';
			echo '<td>'.$lastupdate['countreponse'].'</td>';
			echo '<td>'.$lastupdate['latest_time'].'</td>';
			echo '</tr>';
			
		}
		
		echo'</table>
	
	</div>
	
	
	
	
		
	
    ';}
   
    else {
        
         echo'
        <div class="row "  >
        
        <div class="col-xs-10 col-md-10">
        <div class="page-header"><h1 style="color:#008800;">'.$rowaid[2].'</h1>
        <footer>'.$rowuid[1].' (Update on'.$rowaid[5].') </footer>
         </div><br/>
         <div >
         <textarea class=" well well-lg col-xs-12 col-md-10" style="height:250px" disabled>'.$rowaid[3].'</textarea>
        </div></div>';
        
        if($rowuid[0]==$id){
          echo
        '
          <div class="col-xs-2 col-md-2">
          <form id="editform" class="form-inline row"  role="form" method="post"  action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'"   >
				
					
				<div class="form-group "  >
				
				<a class="btn btn-success" href="/hw3/article.php?articleid='.$_GET['articleid'].'">Edit</a> 
                <button type=submit class="btn btn-danger" name="submitdel">Delete</button>  
				</div>
				<input type="hidden"  value="'.$_GET['articleid'].'" name="article_id">
			</form>
          </div>
          ';  
            
        }
        echo
        '
        </div>
              <form  id="responseform"    role="form" method="post"  action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'"   >
            <label for="Response" class="control-label "><i class="fa fa-comment"></i>Response</label>
            <div class="  form-inline" >

			 <input type="text" placeholder="Response" class="form-control " id="Response" name="Response" style="width:40%"   >			 
			<button type="submit" class="btn btn-info " name="submitresponse">發表回覆</button>
            </div>
           <input type="hidden"  value="'.$_GET['articleid'].'" name="article_id">
             </form>
       
      ';

         $resultres=mysql_query('SELECT * FROM response WHERE article_id="'.$_GET['articleid'].'"');
        
          
                echo '<ul class="list-group">';
               while($rowres =  mysql_fetch_array($resultres))
                    {   
                        
                        
                        echo '<li class="list-group-item">';
                        
                        $resultures=mysql_query('SELECT * FROM user WHERE id="'.$rowres['user_id'].'"');
                        $rowures =  mysql_fetch_array($resultures);
                           echo $rowures['Name'];
                            echo ':';
                            echo $rowres['message'];
                             echo '<span class="badge">'.$rowres['timestamp'].'</span>';
                        echo '</li><br/>';
                        
                    }
                 echo '</ul>';
                
            
       
        
         }
    
      ?> 

              
	</div>
</body>
</html>