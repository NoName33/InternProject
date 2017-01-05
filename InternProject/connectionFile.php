
<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "articlesDB";

try {
    $conn = new PDO("mysql:host=$servername;dbname=articlesDB", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>

