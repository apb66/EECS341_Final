<a href="index.html">Return Home</a><br><br>
<?PHP
include('dbconnect.php');
$id = mysqli_real_escape_string($link, stripslashes($_POST['id']));
$name = mysqli_real_escape_string($link, stripslashes($_POST['name']));
$email = mysqli_real_escape_string($link, stripslashes($_POST['email']));
$bond = mysqli_real_escape_string($link, stripslashes($_POST['bond']));
$major = mysqli_real_escape_string($link, stripslashes($_POST['major']));
$graduate = mysqli_real_escape_string($link, stripslashes($_POST['graduate']));
if (!$id || !$name || !$email || !$bond || !$major || !$graduate) {
	echo "Error getting POST data.<br>";
}
else {
	$query = "UPDATE Individual " .
			 "SET name=\"$name\", email=\"$email\", bond_number=$bond, major=\"$major\", graduation_date=\"$graduate\" " .
			 "WHERE i_id=$id";
	$result = mysqli_query($link, $query);
	if ($result) {
		echo "Successfully updated database.<br>";
	}
	else {
		echo "Error updating database.<br>";
	}
}

?>