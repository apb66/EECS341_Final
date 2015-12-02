<a href="index.html">Return Home</a><br><br>
<?PHP
include('dbconnect.php');
$type = mysqli_real_escape_string($link, stripslashes($_POST['type']));
if (!$type) {
	echo "Error getting POST data.<br>";
}
else {
	if ($type == "service") {
		$iid = mysqli_real_escape_string($link, stripslashes($_POST['iid']));
		$sid = mysqli_real_escape_string($link, stripslashes($_POST['sid']));
		$hours = mysqli_real_escape_string($link, stripslashes($_POST['hours']));
		$query = "SELECT iid from Individual";
		$result = mysqli_query($link, $query);
		if ($iid && $sid && $hours) {
			$query = "INSERT INTO AttendsService (iid, sid, hours, approval_status) " .
					 "VALUES($iid, $sid, $hours, \"New\")";
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
	if ($type == "philanthropy") {
		$iid = mysqli_real_escape_string($link, stripslashes($_POST['iid']));
		$pid = mysqli_real_escape_string($link, stripslashes($_POST['pid']));
		if ($iid && $pid) {
			$query = "INSERT INTO AttendsPhilanthropy (iid, pid, approval_status) " .
					 "VALUES($iid, $pid, \"New\")";
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