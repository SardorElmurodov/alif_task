<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fileName = $_POST['file'];
  $operation = $_POST['operation'];

  $myfile = fopen($fileName, "r") or die("Unable to open file!");
  $positiveFile = fopen("positive.txt", "w") or die("Unable to open file!");
  $negativeFile = fopen("negative.txt", "w") or die("Unable to open file!");
  $negativeTxt = "";
  $positiveTxt = "";

  while(!feof($myfile)) {
    $row = fgets($myfile);
    $numbers = explode(" ", trim($row));

	if(count($numbers) >= 2) {
	  if(is_numeric($numbers[0]) && is_numeric($numbers[1])) {
        switch($operation) {
          case "+":
        	  $s = (float)$numbers[0] + (float)$numbers[1]; break;
          case "-":
        	  $s = (float)$numbers[0] - (float)$numbers[1]; break;
          case "*":
        	  $s = (float)$numbers[0] * (float)$numbers[1]; break;
          case "/":
        	  $s = (float)$numbers[0] / (float)$numbers[1]; break;
        }
	  } else {
		$s = null;
	  }
	} else {
	  $s = null;
	}

	if(!is_null($s)) {
	  if($s >= 0) {
	    $positiveTxt .= $s . " ";
	  } elseif($s < 0) {
	    $negativeTxt .= $s . " ";
	  }
	}
  }

  fwrite($positiveFile, $positiveTxt);
  fwrite($negativeFile, $negativeTxt);
  fclose($positiveFile);
  fclose($negativeFile);
  fclose($myfile);
}
?>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<body>
  <div class="container">
  	<form method="post" action="index.php">
	  <div class="row">
	    <div class="col-md-4 form-group">
		  <label for="file">File name</label>
		  <input type="text" class="form-control" name="file" id="file">
		</div>
  	  </div>
	  <div class="row">
	    <div class="col-md-4 form-group">
		  <label for="operation">Operation</label>
          <select class="form-control" name="operation" id="operation">
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="*">*</option>
            <option value="/">/</option>
          </select>
	    </div>
	  </div>
  	  <button type="submit" class="btn btn-primary">Calculate</button>
  	</form>
  </div>
</body>
</html>