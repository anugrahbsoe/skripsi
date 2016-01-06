<?php
session_start();

if (empty($_SESSION['login'])) {
    header("Location: login.php");
}

include 'blowfish.php';
include 'base64.php';




if ( ! empty($_POST) OR ! empty($_FILES)) {
  if (empty($_POST['key'])) {
    $msg = 'Please provide your secret key';
  }
  else {
    if ( ! empty($_FILES['file']) && ! empty($_FILES['file']['tmp_name'])) {
      if ($_FILES['file']['size'] <= (1024 * 1024 * 2)) {
        $tf = file_get_contents($_FILES['file']['tmp_name']);
      }
      else {
        $msg = 'Maximum allowed file size 2MB';
      }
    }
    elseif ( ! empty($_POST['string'])) {
      $tf = $_POST['string'];
    }
    
    if ( ! empty($tf)) {
      $f = new Blowfish($tf, $_POST['key']);
      $ef = $f->encrypt();
      $bf = base64::encode($ef);
      
      if ( ! empty($_FILES['file'])) {
        $filename = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME) .'.pct';
        $content = $bf.'|'.base64::encode(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        
        file_put_contents('download/'.$filename, $content);
        
        echo json_encode(array('name' => $filename, 'size' => filesize('download/'.$filename), 'link' => 'download/'.$filename));
        exit;
      }
    }
    elseif (empty($msg)) {
      $msg = 'Please input some text or upload a file';
    }
  }
  $valid_ext = array('jpg','jpeg','png','gif','bmp');
if(isset($_POST['submit']) && $_FILES['file']['size']>0){
  $ext = strtolower(end(explode('.', $_FILES['file']['name'])));
  if(in_array($ext, $valid_array)){
    move_uploaded_file($_FILES['file']['tmp_name'], 'submit/'.$_FILES['file']['name']);
  }else{
    echo "Maaf... file yang ada pilih bukan file gambar. Hanya file JPG, PNG, GIF atau BMP yang boleh diupload..!";
  }
}

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
      
			<div class="navbar">
				<div class="navbar-inner">
					<div class="container">
						<ul class="nav nav-pills">
							<li class="active"><a href="encode.php">Encrypter</a></li>
							<li><a href="decode.php">Decrypter</a></li>
							<li><a href="Logout.php">Log Out</a></li>	
						</ul>
					</div>
				</div>
			</div>
    </header>
    
    <?php if ( ! empty($msg)) : ?>
    <div class="alert alert-error">
      <?php echo $msg; ?>  
    </div>    
    <?php endif; ?>
    
  	<section id="subtitle">
  		<h2>Encrpyter</h2>
      <br>
      <br>
    </section>

    
    <div class="tab-content">
      <div class="tab-pane active file" id="tab-file">
        <form method="post" id="formFile" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" enctype="multipart/form-data">
          <input type="file" name="file" style="display: none">
          
          <div class="add" id="add-file">
            <i class="icon-plus"></i>
          </div>
          
          <div class="row">
            <div class="add-holder" id="add-info" style="display: none">
              <img src="../img/file.png">
              <div id="add-info-name" class="info-name"></div>
              <div id="add-info-size" class="info-size"></div>
            
              <input type="password" name="key" placeholder="Please provide your secret key">
            
              <div class="progress progress-striped active" style="display: none">
                <div class="bar" style="width: 100%;"></div>
              </div>
          
    				  <input type="submit" name="submit" class="btn btn-primary" value="Encrypt" style="display: none">
              <a href="encode.php" id="add-cancel" class="cancel">&times;</a>
            </div>
            
            <div class="arrow span1" style="display: none">
              <img src="../img/arrow.png">
            </div>
          
            <div class="add-holder span2" id="result-info" style="display: none">
              <img src="../img/file-secure.png">
              <div id="result-info-name" class="info-name"></div>
              <div id="result-info-size" class="info-size"></div>
              
              <a href="#" target="_blank" id="download-file" style="display: none; width: 200px" class="btn btn-success">Download</a>
            </div>
          </div>     
        </form>   
      </div>
    
      <div class="tab-pane" id="tab-text">
        <?php if ( ! empty($bf)) : ?>
          <?php echo $bf; ?>
          <hr>
        <?php endif; ?>
    		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal">
    			<fieldset>
    				<textarea class="txtlarge" rows="20" name="string">
					<?php echo isset($_POST['string']) ? $_POST['string'] : ''; ?>
					</textarea>
    				<br>
            <br>
            <input type="text" name="key" placeholder="Please provide your secret key">
            <br>
    				<br>
    				<input type="submit" name="submit" class="btn btn-primary" value="Encrypt">
    			</fieldset>
    		</form>
      </div>
    </div>
  </div>
  
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script>
  var maxFileSize = 1024 * 1024 * 2;
  </script>
  <script src="js/kkp.js"></script>
  <script>
  $(function() {
    $('#myTab a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
    });
	$('#formFile').submit(function(){
		var key = $('input[name="key"]').val();
		if (key  === '') {
			alert('isi dulu passwordnya.');
			return false;
		}
	});
	
    <?php if ( ! empty($bf)) : ?>
    $('#myTab a:last').tab('show');
    <?php endif; ?> 
  });
  </script>
</body>
</html>
