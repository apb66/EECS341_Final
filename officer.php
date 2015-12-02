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
			if (!empty($result) && mysqli_num_rows($result) > 0) {
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
		elseif ($row['title'] == "Philanthropy Chair") {
			$query = "SELECT I.iid, I.name, P.pid, P.event_name, P.date " .
					 "FROM Individual I, PhilanthropyEvent P, AttendsPhilanthropy A " .
					 "WHERE I.iid = A.iid " .
						"AND P.pid = A.pid " .
						"AND A.approval_status = \"New\"";
			$result = mysqli_query($link, $query);
			if (!empty($result) && mysqli_num_rows($result) > 0) {
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
					echo '<input name="' . $row['iid'] . ',' . $row['pid'] . '" type="radio" value="approved">Approve</input>';
					echo '<input name="' . $row['iid'] . ',' . $row['pid'] . '" type="radio" value="rejected">Reject</input>';
					echo '</td>';
					echo "</tr>";
				}
				echo "</table>";
				echo '<button type="submit">Update</button>';
			}
			else {
				echo "No philanthropy events submitted.<br>";
			}
		}
		elseif ($row['title'] == "President") {
			echo "<h2>Requirements</h2>";
			$query = "SELECT * FROM Officer";
			$result = mysqli_query($link, $query);
			if ($result && !empty($result)) {
				echo "<table>";
				echo "<thead>";
				echo "<tr>";
				echo "<td><b>Position</b></td>";
				echo "<td><b>Requirement</b></td>";
				echo "</tr>";
				echo "</thead>";
				while ($row = mysqli_fetch_assoc($result)) {
					echo "<tr>";
					echo '<td>' . $row['title'] . '</td>';
					echo '<td><input name="' . $row['iid'] . '" type="text" value="' . $row['requirement'] . '"</input></td>';
					echo '</td>';
					echo "</tr>";
				}
				echo "</table>";
				echo '<button type="submit">Update</button>';
			}
			else {
				echo "Error connecting to database.<br>";
			}
			
			echo "<h2>Members Passing Accountability System</h2>";
			$query = "SELECT DISTINCT(I.iid), I.name, I.dues, S.total_hours, P.total_events " .
					 "FROM Individual I, ServiceHours S, PhilanthropyAmount P, AttendsMeeting A " .
					 "WHERE I.iid = S.iid AND I.iid = P.iid AND I.iid = A.iid " .
					 "AND I.dues >= (" .
						 "SELECT O.requirement " .
						 "FROM Officer O " . 
						 "WHERE O.title = 'Treasurer') " .
					 "AND S.total_hours >= (" .
						 "SELECT O.requirement " .
						 "FROM Officer O " . 
						 "WHERE O.title = 'Service Chair') " .
					 "AND P.total_events >= (" .
						 "SELECT O.requirement " .
						 "FROM Officer O " . 
						 "WHERE O.title = 'Philanthropy Chair') " .
					 "AND (" .
						 "SELECT COUNT(M2.mid) " .
						 "FROM AttendsMeeting M2 " .
						 "WHERE I.iid = M2.iid) " .
						 ">= (" .
						 "SELECT O.requirement " .
						 "FROM Officer O " . 
						 "WHERE O.title = 'President') ";
			$result = mysqli_query($link, $query);
			if (!empty($result) && mysqli_num_rows($result) > 0) {
				echo "<table>";
				echo "<thead>";
				echo "<tr>";
				echo "<td><b>Name</b></td>";
				echo "<td><b>Dues</b></td>";
				echo "<td><b>Service</b></td>";
				echo "<td><b>Philanthropy</b></td>";
				echo "<td><b>Meetings</b></td>";
				echo "</tr>";
				echo "</thead>";
				while ($row = mysqli_fetch_assoc($result)) {
					$meetings = 0;
					$query = "SELECT COUNT(mid) AS meetings " .
							 "FROM AttendsMeeting A " .
							 "WHERE A.iid = " . $row['iid'];
					$result2 = mysqli_query($link, $query);
					if ($result2 && mysqli_num_rows($result2) > 0) {
						$row2 = mysqli_fetch_assoc($result2);
						$meetings = $row2['meetings'];
					}
					echo "<tr>";
					echo '<td>' . $row['name'] . '</td>';
					echo '<td>' . $row['dues'] . '</td>';
					echo '<td>' . $row['total_hours'] . '</td>';
					echo '<td>' . $row['total_events'] . '</td>';
					echo '<td>' . $meetings . '</td>';
					echo '</td>';
					echo "</tr>";
				}
				echo "</table>";
			}
			else {
				echo "No members met the requirements.<br>";
			}
			echo "<h2>Members Failing Accountability System</h2>";
			$query = "SELECT I.iid, I.name, I.dues " .
					 "FROM Individual I " .
					 "WHERE I.iid NOT IN (" .
						 "SELECT I.iid " .
						 "FROM Individual I, ServiceHours S, PhilanthropyAmount P, AttendsMeeting A " .
						 "WHERE I.iid = S.iid AND I.iid = P.iid AND I.iid = A.iid " .
						 "AND I.dues >= (" .
							 "SELECT O.requirement " .
							 "FROM Officer O " . 
							 "WHERE O.title = 'Treasurer') " .
						 "AND S.total_hours >= (" .
							 "SELECT O.requirement " .
							 "FROM Officer O " . 
							 "WHERE O.title = 'Service Chair') " .
						 "AND P.total_events >= (" .
							 "SELECT O.requirement " .
							 "FROM Officer O " . 
							 "WHERE O.title = 'Philanthropy Chair') " .
						 "AND (" .
							 "SELECT COUNT(A.mid) " .
							 "FROM AttendsMeeting M2 " .
							 "WHERE I.iid = M2.iid) " .
							 ">= (" .
							 "SELECT O.requirement " .
							 "FROM Officer O " . 
							 "WHERE O.title = 'President'))";
			$result = mysqli_query($link, $query);
			if (!empty($result) && mysqli_num_rows($result) > 0) {
				echo "<table>";
				echo "<thead>";
				echo "<tr>";
				echo "<td><b>Name</b></td>";
				echo "<td><b>Dues</b></td>";
				echo "<td><b>Service</b></td>";
				echo "<td><b>Philanthropy</b></td>";
				echo "<td><b>Meetings</b></td>";
				echo "</tr>";
				echo "</thead>";
				while ($row = mysqli_fetch_assoc($result)) {
					$hours = 0;
					$query = "SELECT S.total_hours " .
							 "FROM ServiceHours S " .
							 "WHERE S.iid = " . $row['iid'];
					$result2 = mysqli_query($link, $query);
					if ($result2 && mysqli_num_rows($result2) > 0) {
						$row2 = mysqli_fetch_assoc($result2);
						$hours = $row2['total_hours'];
					}
					$events = 0;
					$query = "SELECT P.total_events " .
							 "FROM PhilanthropyAmount P " .
							 "WHERE p.iid = " . $row['iid'];
					$result2 = mysqli_query($link, $query);
					if ($result2 && mysqli_num_rows($result2) > 0) {
						$row2 = mysqli_fetch_assoc($result2);
						$events = $row2['total_events'];
					}
					$meetings = 0;
					$query = "SELECT COUNT(M.mid) AS meetings " .
							 "FROM AttendsMeeting M " .
							 "WHERE M.iid = " . $row['iid'];
					$result2 = mysqli_query($link, $query);
					if ($result2 && mysqli_num_rows($result2) > 0) {
						$row2 = mysqli_fetch_assoc($result2);
						$meetings = $row2['meetings'];
					}
					echo "<tr>";
					echo '<td>' . $row['name'] . '</td>';
					echo '<td>' . $row['dues'] . '</td>';
					echo '<td>' . $hours . '</td>';
					echo '<td>' . $events . '</td>';
					echo '<td>' . $meetings . '</td>';
					echo '</td>';
					echo "</tr>";
				}
				echo "</table>";
			}
			else {
				echo "All members met the requirements.<br>";
			}
		}
		echo "</form>";
	}
}

?>