<?php
// including the database connection file
include_once("config.php");

if(isset($_POST['update'])) {
	$id = mysqli_real_escape_string($mysqli, $_POST['id']);
	$name = mysqli_real_escape_string($mysqli, $_POST['name']);
	$age = mysqli_real_escape_string($mysqli, $_POST['age']);
	$email = mysqli_real_escape_string($mysqli, $_POST['email']);
	$apellido1 = mysqli_real_escape_string($mysqli, $_POST['apellido1']);
	$apellido2 = mysqli_real_escape_string($mysqli, $_POST['apellido2']);

	// checking empty fields
	if(empty($name) || empty($age) || empty($email) || empty($apellido1) || empty($apellido2)) {
		if(empty($name)) {
			echo "<font color='red'>Name field is empty.</font><br/>";
		}
		
		if(empty($apellido1)) {
			echo "<font color='red'>Apellido1 field is empty.</font><br/>";
		}

		if(empty($apellido2)) {
			echo "<font color='red'>Apellido2 field is empty.</font><br/>";
		}

		if(empty($age)) {
			echo "<font color='red'>Age field is empty.</font><br/>";
		}

		if(empty($email)) {
			echo "<font color='red'>Email field is empty.</font><br/>";
		}
	} else {
		// updating the table
		$stmt = mysqli_prepare($mysqli, "UPDATE users SET name=?,apellido1=?,apellido2=?,age=?,email=? WHERE id=?");
		mysqli_stmt_bind_param($stmt, "sssisi", $name, $apellido1, $apellido2, $age, $email, $id);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_free_result($stmt);
		mysqli_stmt_close($stmt);

		// redirectig to the display page. In our case, it is index.php
		header("Location: index.php");
	}
}
?>

<?php
// getting id from url
$id = $_GET['id'];

// selecting data associated with this particular id
$stmt = mysqli_prepare($mysqli, "SELECT name, apellido1, apellido2, age, email FROM users WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $name, $apellido1, $apellido2, $age, $email);
mysqli_stmt_fetch($stmt);
mysqli_stmt_free_result($stmt);
mysqli_stmt_close($stmt);
mysqli_close($mysqli);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Edit Data</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"  crossorigin="anonymous">
</head>

<body>
<div class = "container">
	<div class="jumbotron">
		<h1 class="display-4">Simple LAMP web app</h1>
		<p class="lead">Demo app</p>
	</div>

	<a href="index.php" class="btn btn-primary">Home</a>
	<br/><br/>

	<form name="form1" method="post" action="edit.php">

		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" class="form-control" name="name" value="<?php echo $name;?>">
		</div>

		<div class="form-group">
			<label for="name">Apellido1</label>
			<input type="text" class="form-control" name="apellido1" value="<?php echo $apellido1;?>">
		</div>

		<div class="form-group">
			<label for="name">Apellido2</label>
			<input type="text" class="form-control" name="apellido2" value="<?php echo $apellido2;?>">
		</div>

		<div class="form-group">
			<label for="name">Age</label>
			<input type="text" class="form-control" name="age" value="<?php echo $age;?>">
		</div>

		<div class="form-group">
			<label for="name">Email</label>
			<input type="text" class="form-control" name="email" value="<?php echo $email;?>">
		</div>

		<div class="form-group">
			<input type="hidden" name="id" value=<?php echo $_GET['id'];?>>
			<input type="submit" name="update" value="Update" class="form-control" >
		</div>

	</form>
</div>
</body>
</html>