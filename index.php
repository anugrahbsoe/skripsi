<?php
session_start();

if (empty($_SESSION['login'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>PT.BERCA CAKRA TEKNOLOGI</title>
	<meta naem="viewport" content="width=device-width, intial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/ps.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <header class="jumbotron subhead">
      <img src="../img/Berca.png">
      <p>Multi platform file security system</p>
    </header>
    
    <p class="action">
      <a href="encode.php" class="btn btn-primary btn-large">Encrypter</a>

      <a href="decode.php" class="btn btn-primary btn-large">Decrypter</a>
    </p>
  </div>
</body>
</html>
