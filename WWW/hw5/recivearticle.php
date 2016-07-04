<?php
   
	$con = mysql_connect("localhost:49320","s604410097","s604410097");
	if(!$con){
		die("DB Error");
	}
	mysql_select_db("s604410097",$con);	
    if($_POST['opcode'] == '1')
    {
        $title=$_POST['title'];
        $id=$_POST['userid'];
        $content=$_POST['content'];
        $query="INSERT INTO article (author_id , title , content , created_time , last_update) values ('".$id."','".$title."','".$content."',NOW(),NOW())";
        mysql_query($query);
	}
    else if($_POST['opcode'] == '2')
    {
            $result=mysql_query('SELECT * FROM article WHERE id="'.$_POST['articleid'].'"');
            $row2 = @mysql_fetch_row($result);

			$Title = $row2[2];
            $Content =$row2[3];
            $articleid = $row2[0];
        echo json_encode(array('articleid' => $articleid, 'title' => $Title, 'content' => $Content));
        
    }
    else if($_POST['opcode'] == '3')
    {
			$Title = $_POST['title'];
			$Content = $_POST['content'];
            $aid=$_POST['articleid'];
            mysql_query("UPDATE article SET title='".$Title."' ,content='".$Content."',last_update=NOW()  WHERE id=".$aid.";");
           
        
    }
    

?>