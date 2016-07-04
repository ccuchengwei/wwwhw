<?php
if($_POST['cEmail']){
	$con = mysql_connect("localhost:49320","s604410097","s604410097");
	if(!$con){
		die("DB Error");
	}
	mysql_select_db("s604410097",$con);	
	$email=$_POST['cEmail'];
	$querystr = 'SELECT * FROM user WHERE email="'.$email.'"';
	$result=mysql_query($querystr);
	if(mysql_num_rows($result)!=0){
		echo 'exist';
	}
	else{
		echo 'not exist';
	}
}
?>