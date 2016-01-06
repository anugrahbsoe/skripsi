<?php
session_start();

if ( ! empty($_SESSION['login'])) {
  header("Location: index.php");
}

if ( ! empty($_POST['email']) && ! empty($_POST['password'])) {
  $userdata = file_get_contents('userdata.csv');
  $login = false;
  
  foreach(explode("\n", $userdata) as $row) {
    $data = explode(',', $row);
    
    if ($_POST['email'] == $data[0] && $_POST['password'] == $data[1]) {
      $login = true;
      break;
    }
  }
  
  if ($login) {
    $_SESSION['login'] = 'ok';
    header("Location: index.php");
  }
  
  $error = 'Invalid email or password';
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
    
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
      
      img {
        display: block;
        margin: 0 auto 40px auto;
      }
    </style>
</head>
<body>
  <div class="container">
    <img src="../img/Berca.png">
    <form class="form-signin" method="post">
      <h2 class="form-signin-heading">Please sign in</h2>
      <?php if ( ! empty($error)) : ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
      <?php endif; ?>
      <input type="text" class="input-block-level" name="email" placeholder="User Name">
      <input type="password" class="input-block-level" name="password" placeholder="Password">

      <button class="btn btn-large btn-primary" type="submit">Sign in</button>
    </form>
  </div>
</body>
</html>
