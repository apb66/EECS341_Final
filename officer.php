<a href="index.html">Return Home</a><br><br>
<?PHP
include('dbconnect.php');
$officer = mysqli_real_escape_string($link, stripslashes($_POST['officer']));
if (!$officer) {
	echo "Error getting POST data.<br>";
}
else {
	$query = "SELECT title FROM Officer WHERE iid=$officer";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_assoc($result);
	if ($row > 0) {
		echo '<form action="officer-update.php" method="post">';
		echo '<input name="position" type="hidden" value="' . $row['title'] . '"</input>';
		if ($row['title'] == "Treasurer") {
			$query = "SELECT iid, name, dues FROM Individual";
			$result = mysqli_query($link, $query);
			if ($result) {
				echo "<table>";
				echo "<thead>";
				echo "<tr>";
				echo "<td><b>Name</b></td>";
				echo "<td><b>Due</b></td>";
				echo "</tr>";
				echo "</thead>";
				while ($row = mysqli_fetch_assoc($result)) {
					echo "<tr>";
					echo '<td>' . $row['name'] . ':</td>';
					echo '<td><input name="' . $row['iid'] . '" type="text" value="' . $row['dues'] . '"</input><td>';
					echo "</tr>";
				}
				echo "</table>";
				echo '<button type="submit">Update</button>';
			}
		}
		elseif ($row['title'] == "Service Chair") {
			$query = "SELECT I.iid, I.name, S.sid, S.event_name, S.date " .
					 "FROM Individual I, ServiceEvent S, AttendsService A " .
					 "WHERE I.iid = A.iid " .
						"AND S.sid = A.sid " .
						"AND A.approval_status = \"New\"";
			$result = mysqli_query($link, $query);
			if ($result) {
				echo "<table>";
				echo "<thead>";
				echo "<tr>";
				echo "<td><b>Name</b></td>";
				echo "<td><b>Event</b></td>";
				echo "<td><b>Date</b></td>";
				echo "<td><b>Status</b></td>";
				echo "</tr>";
				echo "</thead>";
				while ($row = mysqli_fetch_assoc($result)) {
					echo "<tr>";
					echo '<td>' . $row['name'] . '</td>';
					echo '<td>' . $row['event_name'] . '</td>';
					echo '<td>' . $row['date'] . '</td>';
					echo '<td>';
					echo '<input name="' . $row['iid'] . ',' . $row['sid'] . '" type="radio" value="approved">Approve</input>';
					echo '<input name="' . $row['iid'] . ',' . $row['sid'] . '" type="radio" value="rejected">Reject</input>';
					echo '</td>';
					echo "</tr>";
				}
				echo "</table>";
				echo '<button type="submit">Update</button>';
			}
			else {
				echo "No service hours submitted.<br>";
			}
		}
		echo "</form>";
	}
}

?>