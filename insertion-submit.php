<?PHP
include('dbconnect.php');
$table = mysqli_real_escape_string($link, stripslashes($_POST['table']));
if (!$table) {
	echo "Error getting POST data.<br>";
	echo '<a href="index.html">Return to home page</a>';
}
else {
	if ($table == 'Individual')
	{
		$id = mysqli_real_escape_string($link, stripslashes($_POST['id']));
		$name = mysqli_real_escape_string($link, stripslashes($_POST['name']));
		$email = mysqli_real_escape_string($link, stripslashes($_POST['email']));
		$bond = mysqli_real_escape_string($link, stripslashes($_POST['bond']));
		$major = mysqli_real_escape_string($link, stripslashes($_POST['major']));
		$graduate = mysqli_real_escape_string($link, stripslashes($_POST['graduate']));
		$dues = mysqli_real_escape_string($link, stripslashes($_POST['dues']));
		$service = mysqli_real_escape_string($link, stripslashes($_POST['service']));
		$philanthropy = mysqli_real_escape_string($link, stripslashes($_POST['philanthropy']));
		$query = "INSERT INTO Individual VALUES($id, \"$name\", \"$email\", $bond, \"$major\", \"$graduate\", $dues, $service, $philanthropy)";
		$result = mysqli_query($link, $query);
		if ($result) {
			echo "Insertion Successfull!<br>";
		}
		else {
			echo "Insertion Failed.<br>";
		}
	}
	echo '<a href="index.html">Return to home page</a>';
}

?>