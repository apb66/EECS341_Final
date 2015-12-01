<a href="index.html">Return Home</a><br><br>
<?PHP
include('dbconnect.php');
$iid = mysqli_real_escape_string($link, stripslashes($_POST['iid']));
if (!$iid) {
	echo "Error getting POST data.<br>";
}
else {
	$query = "SELECT sid, event_name, date FROM ServiceEvent";
	$result = mysqli_query($link, $query);
	if (!$result) {
		echo "Error contacting database.<br>";
	}
	else {
		echo '<form action="member-submit.php" method="post">';
		echo '<input name="iid" type="hidden" value="' . $iid . '"</input>';
		echo '<input name="type" type="hidden" value="service"</input>';
		echo "Event: ";
		echo '<select name="sid">';
		while ($row = mysqli_fetch_assoc($result)) {
			echo '<option value="' . $row['sid'] . '">' . $row['event_name'] . ' [' . $row['date'] . ']</option>';
		}
		echo '</select>';
		echo "<br>";
		echo "Hours: ";
		echo '<input name="hours" type="text">';
		echo "<br>";
		echo '<button type="submit">Submit Service</button>';
		echo "</form>";
	}
}

?>