<a href="index.html">Return Home</a><br><br>
<?PHP
include('dbconnect.php');
$type = mysqli_real_escape_string($link, stripslashes($_POST['type']));
if (!$type) {
	echo "Error getting POST data.<br>";
}
else {
	if ($type == "service") {
		$i_id = mysqli_real_escape_string($link, stripslashes($_POST['i_id']));
		$s_id = mysqli_real_escape_string($link, stripslashes($_POST['s_id']));
		$hours = mysqli_real_escape_string($link, stripslashes($_POST['hours']));
		$query = "SELECT i_id from Individual";
		$result = mysqli_query($link, $query);
		if ($i_id && $s_id && $hours) {
			$query = "INSERT INTO AttendsService (i_id, s_id, hours, approval_status) " .
					 "VALUES($i_id, $s_id, $hours, \"New\")";
			$result = mysqli_query($link, $query);
			if ($result) {
				echo "Successfully submitted hours.<br>";
			}			
			else {
				echo "Error submitting hours.<br>";
			}
		}
		else {
			echo "Error connecting to database.<br>";
		}
	}
}

?>