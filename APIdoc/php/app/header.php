<?php 
	session_start(); 

	if(!isset($checkSession)){
		$checkSession = true;
	}	

	if($checkSession && !isset($_SESSION['sessionKey'])){
		header( 'Location: /login.php' );		
	}
?>
<html>
	<head>
		<title><?php echo $title; ?></title>
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/bootswatch/3.1.1/cerulean/bootstrap.min.css" rel="stylesheet">

		<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	</head>
	<body>
	<nav class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">Demo</a>
        </div>
        <?php if(isset($_SESSION['sessionKey'])){ ?>
		<ul class="nav navbar-nav">
			<li><a href="/">List</a></li>
			<li><a href="/upload.php">Upload</a></li>
		</ul>
		<?php } ?>
        <ul class="nav navbar-nav pull-right">
            <?php if(isset($_SESSION['sessionKey'])){ ?>
				<li><a href="/logout.php">Logout</a></li>
            <?php } else { ?>
				<li><a href="/login.php">Login</a></li>
			<?php } ?>
        </ul>
    </nav>