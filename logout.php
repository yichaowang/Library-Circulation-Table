<?php
	session_start();
	if(!isset($_SESSION["user"])){
		$_SESSION["user"] == "";
		unset($_SESSION['user']); 
	}
	session_destroy();
	$url = "index.php";
	//header('Location: index.php');
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
		<meta http-equiv="refresh" content="1;url=<?php echo $url; ?>">
	</head>
	<body>
		�����µ�¼��
		<a href = "index.php">����</a>
	</body>
</html>