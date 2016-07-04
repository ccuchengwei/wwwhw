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
	$Email = $_POST['Email'];
	$pw = $_POST['pw'];
	$sql ='SELECT * FROM user where Email = "'.$Email.'"';
	
	$result = mysql_query($sql);
	$row = @mysql_fetch_row($result);
	
	if($row[2]==$email&&$row[3]==$pw)
	{
		   $_SESSION['Email'] = $Email;
		   $_SESSION['Username'] = $row[1];
			echo 'yes!';
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
	<link rel="icon" href="http://www.ccu.edu.tw/web_images/index/short_icon.png" type="image/x-icon">
 
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
	<script src="/hw3/js/bootstrapValidator.min.js"></script>



	<nav class="navbar navbar-inverse navbar-static-top" role=navigation >
		<div class=container>
			<div class=navbar-header>
				<button type=button class="navbar-toggle collapsed" data-toggle=collapse data-target=#navbar aria-expanded=false aria-controls=navbar> 
					<span class=sr-only>Toggle navigation</span> 
					<span class=icon-bar></span> 
					<span class=icon-bar></span> 
					
				</button> 
				<a class="navbar-brand fa fa-info" href=# style="font-size:20px;color:#00DD00;"><strong> YY Forum</strong></a>
			</div>
			<div id=navbar class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					<li ><a class="glyphicon glyphicon-home" href=#>Home</a></li>
					<li class=active><a class="glyphicon glyphicon-user" href=#Login>Login</a></li>
					
				</ul>
			</div>
		</div>
	</nav>
<form id="accountForm" method="post" class="form-horizontal">
    <div class="tab-content">
        <div class="tab-pane active" id="info-tab">
            <div class="form-group">
                <label class="col-lg-3 control-label">Full name</label>
                <div class="col-lg-5">
                    <input type="text" class="form-control" name="fullName" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Company</label>
                <div class="col-lg-5">
                    <input type="text" class="form-control" name="company" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Job title</label>
                <div class="col-lg-5">
                    <input type="text" class="form-control" name="jobTitle" />
                </div>
            </div>
        </div>

        <div class="tab-pane" id="address-tab">
            <div class="form-group">
                <label class="col-lg-3 control-label">Address</label>
                <div class="col-lg-5">
                    <input type="text" class="form-control" name="address" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">City</label>
                <div class="col-lg-5">
                    <input type="text" class="form-control" name="city" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Country</label>
                <div class="col-lg-5">
                    <select class="form-control" name="country">
                        <option value="">Select a country</option>
                        <option value="FR">France</option>
                        <option value="DE">Germany</option>
                        <option value="IT">Italy</option>
                        <option value="JP">Japan</option>
                        <option value="RU">Russian</option>
                        <option value="US">United State</option>
                        <option value="GB">United Kingdom</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-5 col-lg-offset-3">
            <button type="submit" class="btn btn-primary">Validate</button>
        </div>
    </div>
</form>

			
	
	
	<script>
$(document).ready(function() {
    $('#accountForm')
        .bootstrapValidator({
            // Only disabled elements are excluded
            // The invisible elements belonging to inactive tabs must be validated
            excluded: [':disabled'],
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                fullName: {
                    validators: {
                        notEmpty: {
                            message: 'The full name is required'
                        }
                    }
                },
                company: {
                    validators: {
                        notEmpty: {
                            message: 'The company name is required'
                        }
                    }
                },
                address: {
                    validators: {
                        notEmpty: {
                            message: 'The address is required'
                        }
                    }
                },
                city: {
                    validators: {
                        notEmpty: {
                            message: 'The city is required'
                        }
                    }
                }
            }
        });
});
</script>
		

	
</body>
</html>