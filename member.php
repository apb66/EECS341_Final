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
	$query = 'SELECT * FROM Individual WHERE i_id="' . $member . '"';
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_assoc($result);
	$i_id = $row['i_id'];
	echo '<input name="id" type="hidden" value="' . $i_id . '"/>';
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
	echo 'dues: ' . $row['dues'];
	echo '<br>';
	echo '<form action="member-service.php" method="post">';
	$query = "SELECT SUM(hours) AS sum " .
			 "FROM AttendsService " .
			 "WHERE i_id=" . $i_id . " AND approval_status='Approved'";
	$result = mysqli_query($link, $query);
	$service = 0;
	if ($result) {
		$row = mysqli_fetch_assoc($result);
		if ($row['sum'] != NULL) {
			$service = $row['sum'];
		}
	}
	echo 'service: ' . $service;
	echo '<button type="submit">Submit Service</button>';
	echo '</form>';
	echo '<form action="member-philanthropy.php" method="post">';
	$query = "SELECT COUNT(*) AS total " .
			 "FROM AttendsPhilanthropy " .
			 "WHERE i_id=" . $i_id . " AND approval_status='Approved'";
	$result = mysqli_query($link, $query);
	$philanthropy = 0;
	if ($result) {
		$row = mysqli_fetch_assoc($result);
		if ($row['total'] != NULL) {
			$philanthropy = $row['total'];
		}
	}
	echo 'philanthropy: ' . $philanthropy;
	echo '<button type="submit">Submit Philanthropy</button>';
	echo '</form>';
}

?>