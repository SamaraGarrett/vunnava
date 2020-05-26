<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/functions.php';
// Start session to store variables
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
// Allows user to return 'back' to this page
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
 ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $parameters['systemname']->value ?> Edit Project</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- For Date Picker -->
  <link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
 <link href="/resources/demos/style.css" rel="stylesheet" >
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<?php
     require 'ProjectManagementSystem/configure.php';
// Establishing Connection with Server
$servername = DATABASE_HOST;
$db_username = DATABASE_USER;
$db_password = DATABASE_PASSWORD;
$database = DATABASE_DATABASE;
// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully<br>";
$conn->set_charset("utf8");
$id = $_GET['id'];
if(isset($_POST['submit'])){
	$sql = "DELETE FROM project
	WHERE project_id = '$id'";

	if ($conn->query($sql) === TRUE) {
    echo "New record created successfully.";
	}
	else {
    echo "Error: " . $sql . "<br>" . $conn->error;
	}
$conn->close();
	header('Location: project_list.php');
}
echo '
<form method="post" action="">
<input type="submit" class="orange_button" name="submit" value="Yes">
<!-- No Button -->
<a href="project_list.php" id="noButton" class="orange_button">Cancel</a>
</form>
';
?>
</div>
</body>
