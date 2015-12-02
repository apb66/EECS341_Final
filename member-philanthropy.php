<a href="index.html">Return Home</a><br><br>
<?PHP
include('dbconnect.php');
$iid = mysqli_real_escape_string($link, stripslashes($_POST['iid']));
if (!$iid) {
	echo "Error getting POST data.<br>";
}
else {
	$query = "SELECT pid, event_name, date FROM PhilanthropyEvent";
	$result = mysqli_query($link, $query);
	if (!$result) {
		echo "Error contacting database.<br>";
	}
	elseif (mysqli_num_rows($result) < 1) {
		echo "No Philanthropy Events have occured.";
	} 
	else {
		echo '<form action="member-submit.php" method="post">';
		echo '<input name="iid" type="hidden" value="' . $iid . '"</input>';
		echo '<input name="type" type="hidden" value="philanthropy"</input>';
		echo "Event: ";
		echo '<select name="pid">';
		while ($row = mysqli_fetch_assoc($result)) {
			echo '<option value="' . $row['pid'] . '">' . $row['event_name'] . ' [' . $row['date'] . ']</option>';
		}
		echo '</select>';
		echo "<br>";
		echo "<br>";
		echo '<button type="submit">Submit Philanthropy</button>';
		echo "</form>";
	}
}

?>