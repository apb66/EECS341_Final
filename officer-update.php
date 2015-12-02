<a href="index.html">Return Home</a><br><br>
<?PHP
include('dbconnect.php');
$position = mysqli_real_escape_string($link, stripslashes($_POST['position']));
if (!$position) {
	echo "Error getting POST data.<br>";
}
else {
	if ($position == "Treasurer") {
		$query = "SELECT iid from Individual";
		$result = mysqli_query($link, $query);
		if ($result) {
			$success = 1;
			while ($row = mysqli_fetch_assoc($result)) {
				$dues = mysqli_real_escape_string($link, stripslashes($_POST[$row['iid']]));
				if (!is_null($dues)) {
					$query = "UPDATE Individual SET dues=\"$dues\" WHERE iid=" . $row['iid'];
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
	elseif ($position == "Service Chair") {
		$query = "SELECT I.iid, S.sid " .
				 "FROM Individual I, ServiceEvent S, AttendsService A " .
				 "WHERE I.iid = A.iid " .
					"AND S.sid = A.sid " .
					"AND A.approval_status = \"New\"";
		$result = mysqli_query($link, $query);
		if ($result) {
			$success = 1;
			while ($row = mysqli_fetch_assoc($result)) {
				$status = mysqli_real_escape_string($link, stripslashes($_POST[$row['iid'] . ',' . $row['sid']]));
				if (!is_null($status)) {
					if ($status == "approved") {
						$query = "UPDATE AttendsService " .
								 "SET approval_status=\"Approved\" " .
								 "WHERE iid=" . $row['iid'] . " AND sid=" . $row['sid'];
						$result2 = mysqli_query($link, $query);
						if (!$result) {
							$success = 0;
						}
					}
					elseif ($status == "rejected") {
						$query = "UPDATE AttendsService " .
								 "SET approval_status=\"Rejected\" " .
								 "WHERE iid=" . $row['iid'] . " AND sid=" . $row['sid'];
						$result2 = mysqli_query($link, $query);
						if (!$result) {
							$success = 0;
						}
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
	}
	elseif ($position == "Philanthropy Chair") {
		$query = "SELECT I.iid, P.pid " .
				 "FROM Individual I, PhilanthropyEvent P, AttendsPhilanthropy A " .
				 "WHERE I.iid = A.iid " .
					"AND P.pid = A.pid " .
					"AND A.approval_status = \"New\"";
		$result = mysqli_query($link, $query);
		if ($result) {
			$success = 1;
			while ($row = mysqli_fetch_assoc($result)) {
				$status = mysqli_real_escape_string($link, stripslashes($_POST[$row['iid'] . ',' . $row['pid']]));
				if (!is_null($status)) {
					if ($status == "approved") {
						$query = "UPDATE AttendsPhilanthropy " .
								 "SET approval_status=\"Approved\" " .
								 "WHERE iid=" . $row['iid'] . " AND pid=" . $row['pid'];
						$result2 = mysqli_query($link, $query);
						if (!$result) {
							$success = 0;
						}
					}
					elseif ($status == "rejected") {
						$query = "UPDATE AttendsPhilanthropy " .
								 "SET approval_status=\"Rejected\" " .
								 "WHERE iid=" . $row['iid'] . " AND pid=" . $row['pid'];
						$result2 = mysqli_query($link, $query);
						if (!$result) {
							$success = 0;
						}
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
	}
	elseif ($position == "President") {
		$query = "SELECT iid FROM Officer";
		$result = mysqli_query($link, $query);
		if ($result) {
			$success = 1;
			while ($row = mysqli_fetch_assoc($result)) {
				$req = mysqli_real_escape_string($link, stripslashes($_POST[$row['iid']]));
				if (!is_null($req)) {
					$query = "UPDATE Officer SET requirement=" . $req . " WHERE iid=" . $row['iid'];
					$result2 = mysqli_query($link, $query);
					if (!$result) {
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
	}
}

?>