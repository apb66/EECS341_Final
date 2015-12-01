<a href="index.html">Return Home</a><br><br>
<?PHP
include('dbconnect.php');
$position = mysqli_real_escape_string($link, stripslashes($_POST['position']));
if (!$position) {
	echo "Error getting POST data.<br>";
}
else {
	if ($position == "Treasurer") {
		$query = "SELECT i_id from Individual";
		$result = mysqli_query($link, $query);
		if ($result) {
			$success = 1;
			while ($row = mysqli_fetch_assoc($result)) {
				$dues = mysqli_real_escape_string($link, stripslashes($_POST[$row['i_id']]));
				if ($dues) {
					$query = "UPDATE Individual SET dues=\"$dues\" WHERE i_id=" . $row['i_id'];
					$update = mysqli_query($link, $query);
					if (!$update) {
						$success = 0;
					}
				}
			}
			if ($success) {
				echo "Successfully updated database.<br>";
			}
			else {
				echo "Error updating database.<br>";
			}
		}
		else {
			echo "Error connecting to database.<br>";
		}
	}
}

?>