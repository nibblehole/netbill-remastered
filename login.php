<?php
error_reporting(0);
	session_start();
	include 'inc/config.php';
	if(isset($_SESSION['username'])){
	header("location:index.php");
}
?>

<html>
<head>
	<title>Login Page - TeamX Project</title>
	<link href="css/bootstrap.css" rel="stylesheet">
<style type="text/css">
body{
	font-family: arial;
	font-size: 14px;
	background-color: #222;
}	
#utama{
	width: 20%;
	margin: 0 auto;
	margin-top: 12%;
	
}
#judul{
	padding: 15px;
	text-align: center;
	color: #fff;
	font-size: 20px;
	background-color: #3498db;
	border-top-right-radius: 10px;
	border-top-left-radius: 10px;
	border-bottom: 3px solid #336666;
}
#isi{
	background-color: #ccc;
	padding: 20px;
	border-bottom-left-radius: 10px;
	border-bottom-right-radius: 10px; 
}
input{
	padding: 10px;
	border: 0;
}
.lg{
	width: 220px;
}
/*
.btn{
	background-color: #339966 ;
	border-radius: 10px;
	color: #fff;
}
.btn:hover{
	background-color: #336666 ;
	cursor: pointer;
}*/
</style>
</head>
<body>
<div id="utama">
	<div id="judul">
		Halaman Login
	</div>
	<div id="isi">
		<form action="" method="post">
		<?php if(!empty($_SESSION['msg'])) echo $_SESSION['msg']; ?>
			<div>
				<input class="form-control" type="text" name="username" placeholder="Username" autofocus>
			</div>
			<div style="margin-top: 10px;">
				<input class="form-control" type="password" name="password" placeholder="Password">
			</div>
			<div style="margin-top: 10px;">
				<button type="submit" name="btnSubmit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>  Login</button> <!-- <input class="btn" type="submit" name="btnSubmit" value="Login"> -->
			</div>
		</form>
		<hr>
		<span><i>Copyright &copy; <?php echo date('Y'); ?> <a href="https://teamxproject.online" target="_blank" title="TeamX Project"> TeamX Project</a>.</i></span>	
	</div>
	<?php
	if(isset($_POST['btnSubmit'])){
		if(!empty($_POST['username']) && !empty($_POST['password'])){
		$username=$_POST['username'];
		$password=$_POST['password']; 
		}else{
			$_SESSION['msg'] = 'Kolom kosong';
		}
		$qu = "SELECT * from t_user WHERE username ='{$username}'";
		$query = $db->prepare($qu);
		$query->execute();
		$r = $query->fetch(PDO::FETCH_ASSOC);
		if(md5($password) == $r['password']){
			$_SESSION['username'] = $r['username'];
			$_SESSION['level'] = $r['level'];
			$_SESSION['id'] = $r['id_pelanggan'];
			header('Location: index.php');
		}else{
			$_SESSION['msg'] = "password tidak cocok";
		}
	}
	?>
</div>
</body>
</html>
	