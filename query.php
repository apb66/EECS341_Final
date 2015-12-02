<a href="index.html">Return Home</a><br><br>
<?PHP
include('dbconnect.php');
$query = $_POST['query'];
if (!$query) {
	echo "Error getting POST data.<br>";
}
else {
	echo "Query:<br>" . $query . "<br><br>";
	echo "Result:<br>";
	$result = mysqli_query($link, $query);
	if ($result) {
		if (is_bool($result)) {
			echo "Query Successfull.<br>";
		}
		elseif (!empty($result) && mysqli_num_rows($result) > 0) {
			echo "<table>";
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<tr>";
				foreach ($row as $cell) {
					echo '<td>' . $cell . '</td>';
				}
				echo "</tr>";
			}
			echo "</table>";
		}
	}
	else {
		echo 'Error in query.<br>';
	}
}
?>