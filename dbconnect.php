<?PHP

$host = "localhost";
$user = "root";
$pass = "ee274af3fdebc3e43b76b2bc32acbc71";
$db	  = "Accountability";

$link = mysqli_connect($host, $user, $pass, $db);
if (!$link) {
	echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

?>