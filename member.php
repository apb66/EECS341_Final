<a href="index.html">Return Home</a><br><br>
<?PHP
include('dbconnect.php');
$member = mysqli_real_escape_string($link, stripslashes($_POST['member']));
if (!$member) {
	echo "Error getting POST data.<br>";
}
else {
	echo '<h2>Personal Information</h2>';
	echo '<form action="member-update.php" method="post">';
	$query = 'SELECT * FROM Individual WHERE iid="' . $member . '"';
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_assoc($result);
	$iid = $row['iid'];
	echo '<input name="id" type="hidden" value="' . $iid . '"/>';
	echo 'name: ';
	echo '<input name="name" type="text" value="' . $row['name'] . '"/>';
	echo '<br/>';
	echo 'email: ';
	echo '<input name="email" type="text" value="' . $row['email'] . '"/>';
	echo '<br/>';
	echo 'bond: ';
	echo '<input name="bond" type="text" value="' . $row['bond_number'] . '"/>';
	echo '<br/>';
	echo 'major: ';
	echo '<input name="major" type="text" value="' . $row['major'] . '"/>';
	echo '<br/>';
	echo 'graduate: ';
	echo '<input name="graduate" type="date" value="' . $row['graduation_date'] . '">';
	echo '<br>';
	echo '<button type="submit">Update</button>';
	echo '</form>';
	
	echo '<h2>Requirements</h2>';
	
	echo 'dues: $' . $row['dues'];
	$query = "SELECT requirement FROM Officer WHERE title='Treasurer'";
	$result = mysqli_query($link, $query);
	if ($result && !empty($result) && mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		echo " / $" . $row['requirement'];
	}
	echo '<br>';
	
	echo "meetings: ";
	$meetings = 0;
	$query = "SELECT COUNT(A.mid) AS meetings " .
			 "FROM AttendsMeeting A " .
			 "WHERE A.iid = " . $iid;
	$result = mysqli_query($link, $query);
	if ($result && !empty($result) && mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$meetings = $row['meetings'];
	}
	echo $meetings;
	$query = "SELECT requirement FROM Officer WHERE title='Secretary'";
	$result = mysqli_query($link, $query);
	if ($result && !empty($result) && mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		echo " / " . $row['requirement'];
	}
	
	echo '<form action="member-service.php" method="post">';
	echo '<input name="iid" type="hidden" value="' . $iid . '"/>';
	$query = "SELECT total_hours " .
			 "FROM ServiceHours " .
			 "WHERE iid=" . $iid;
	$result = mysqli_query($link, $query);
	$service = 0;
	if ($result) {
		$row = mysqli_fetch_assoc($result);
		if ($row['total_hours'] != NULL) {
			$service = $row['total_hours'];
		}
	}
	echo 'service: ' . $service;
	$query = "SELECT requirement FROM Officer WHERE title='Service Chair'";
	$result = mysqli_query($link, $query);
	if ($result && !empty($result) && mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		echo " / " . $row['requirement'];
	}
	if ($service == 1) {
		echo ' hour ';
	}
	else {
		echo ' hours ';
	}
	
	echo '<button type="submit">Submit Service</button>';
	echo '</form>';
	
	echo '<form action="member-philanthropy.php" method="post">';
	echo '<input name="iid" type="hidden" value="' . $iid . '"/>';
	$query = "SELECT total_events " .
			 "FROM PhilanthropyAmount " .
			 "WHERE iid=" . $iid;
	$result = mysqli_query($link, $query);
	$philanthropy = 0;
	if ($result) {
		$row = mysqli_fetch_assoc($result);
		if ($row['total_events'] != NULL) {
			$philanthropy = $row['total_events'];
		}
	}
	echo 'philanthropy: ' . $philanthropy;
	$query = "SELECT requirement FROM Officer WHERE title='Philanthropy Chair'";
	$result = mysqli_query($link, $query);
	if ($result && !empty($result) && mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		echo " / " . $row['requirement'];
	}
	if ($philanthropy == 1) {
		echo ' event ';
	}
	else {
		echo ' events ';
	}
	echo '<button type="submit">Submit Philanthropy</button>';
	echo '</form>';
}

?>