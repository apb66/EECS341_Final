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
	echo '<br>';
	
	echo '<form action="member-service.php" method="post">';
	echo '<input name="iid" type="hidden" value="' . $iid . '"/>';
	$query = "SELECT * " .
			 "FROM ServiceHours " .
			 "WHERE iid=" . $iid;
	$result = mysqli_query($link, $query);
	$service = 0;
	if ($result) {
		$row = mysqli_fetch_assoc($result);
		if ($row['SUM(hours)'] != NULL) {
			$service = $row['SUM(hours)'];
		}
	}
	if ($service == 1) {
		echo 'service: ' . $service . ' hour ';
	}
	else {
		echo 'service: ' . $service . ' hours ';
	}
	
	echo '<button type="submit">Submit Service</button>';
	echo '</form>';
	
	echo '<form action="member-philanthropy.php" method="post">';
	echo '<input name="iid" type="hidden" value="' . $iid . '"/>';
	$query = "SELECT * " .
			 "FROM PhilanthropyAmount " .
			 "WHERE iid=" . $iid;
	$result = mysqli_query($link, $query);
	$philanthropy = 0;
	if ($result) {
		$row = mysqli_fetch_assoc($result);
		if ($row['COUNT(*)'] != NULL) {
			$philanthropy = $row['COUNT(*)'];
		}
	}
	if ($philanthropy == 1) {
		echo 'philanthropy: ' . $philanthropy . ' event ';
	}
	else {
		echo 'philanthropy: ' . $philanthropy . ' events ';
	}
	echo '<button type="submit">Submit Philanthropy</button>';
	echo '</form>';
}

?>