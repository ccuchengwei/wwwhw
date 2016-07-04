<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <title>Gugug</title>
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<script src="/js/validator.min.js"></script>
		<script>
				function dcheck(a){
						return false;
						// pw=$('#pw').val();
						// dpw=$('#dpw').val();
						// if(pw!=dpw){
						// 		$('#errorinfo').show();
						// 		return false;
						// }
						// else return true;
				}
		</script>
</head>
<body>
		<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
				<div class="container">
						<div class="navbar-header">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
										<span class="sr-only">Toggle navigation</span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
								</button>
								<a href="" class="navbar-brand">Gugug Forum</a>
						</div>
						<div id="navbar" class="navbar-collapse collapse" style="height:1px;">
								<ul class="nav navbar-nav navbar-right">
												<li><a href="#"></span><span class="glyphicon glyphicon-home">Home</a></li>
												<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
								</ul>
						</div>
				</div>
		</nav>
		<div class="container" role="main">
				<div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-6">
								<form action="/newaccount.php" method="GET" data-toggle="validator">
										<h2 class="text-center"><i class="fa fa-user"></i> Create new account?yX</h2>
										<br/>
										<div class="form-group has-feedback">
												<label for="inputnickname" class="control-label">Nickname:</label>
												<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
												<input type="text" class="form-control" id="nickname" placeholder="Fufu" name="nickname" required>
										</div>
										<div class="form-group has-feedback">
												<label class="control-label" for="inputemail">Email:</label>
												<input class="form-control" name="email" type="email" id="email" placeholder="xxx@gmail.com" data-error="Please enter a correct email affress." required>
												<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
												<div class="help-block with-errors"></div>
										</div>
										<div class="form-group has-feedback">
												<label for="inputpw" class="control-label">Password:</label>
												<input type="password" name="password" data-minlength="4" class="form-control" id="inputPw" placeholder="Password" data-error="Your password need at least 4 char" required>
												<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
												<div class="help-block with-errors"></div>
										</div>
										<div class="form-group has-feedback">
												<label for="inputpw" class="control-label">Confirm password:</label>
												<input type="password" class="form-control" id="inputPwConfirm" placeholder="Password again" data-match="#inputPw" data-match-error="Not match your password"  required>
												<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
												<div class="help-block with-errors"></div>
										</div>
										<div class="form-group has-feedback text-center">
												<button type="submit" class="btn btn-primary">Submit</button>
										</div>
								</form>
						</div>
						<div class="col-md-3"></div>
				</div>
		</div>
		<script>
				$(document).ready(function(){
						$('#errorinfo').hide();
				});
		</script>
</body>
</html>