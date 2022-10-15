<?php
	include('functions.php');
	include('markdown.php');
	if ($_POST['action'] == 'query') {
				$query = $_POST['query'];
				$_SESSION['debug'] = 'none';
				if (strpos($query,'query') === 0) {
					$_SESSION['debug'] = 'query()';
					$query = trim($query,'query()');
					$result = pg_query($db,$query);
					if ($result) {
						$output = "";
						while ($row = pg_fetch_assoc($result)) {
							$output.="<tr>";
	    				foreach($row as $field) {
	        			$output.= "<td>".htmlspecialchars($field)."</td>";
	    				}
	    				$output.="</tr>";
						}
						$query = "EXPLAIN ANALYZE ".$query;
						$result = pg_query($db,$query);
						$report = "";
						while ($row = pg_fetch_assoc($result)) {
							foreach($row as $field) {
	        			$report.= htmlspecialchars($field).PHP_EOL;
	    				}
	    				$report.=PHP_EOL;
						}
					}  else {
						$report = pg_last_error($db);
					}
				}  else {
							$array = explode(" ",$query);
							$m = sizeof($array);
							$student = array(); $course = array(); $instructor = array();
							for ($i = 0; $i < $m; $i++) {
								$array[$i] = trim($array[$i],"[],");
								if (pg_num_rows(pg_query($db,"SELECT * FROM student WHERE sid = '".$array[$i]."';")) !== 0) {
									array_push($student,$array[$i]);
								} else if (pg_num_rows(pg_query($db,"SELECT * FROM course_info WHERE cid = '".$array[$i]."';")) !== 0) {
									array_push($course,$array[$i]);
								} else if (pg_num_rows(pg_query($db,"SELECT * FROM course_info WHERE iid = '".$array[$i]."';")) !== 0) {
									array_push($instructor,$array[$i]);
								}
							}
							print_r(array_values($student));
							print_r(array_values($course));
							print_r(array_values($instructor));
				}

				$_SESSION['output'] = $output;
				$_SESSION['report'] = $report;
				header("Location: index.php?q=1");
  }	 else if($_POST['action']=='email') {
			// change the email id of the user
			if(trim($_POST['email']) == "")
				header("Location: account.php?derror=1");
			else {
				pg_query($db,"UPDATE users SET email='".pg_escape_string($db,$_POST['email'])."' WHERE userid='".$_SESSION['userid']."'");
				header("Location: account.php?changed=1");
			}
 }  else if($_POST['action']=='password') {
			// change the password of the user
			if(trim($_POST['oldpass']) == "" or trim($_POST['newpass']) == "")
				header("Location: account.php?derror=1");
			else {
				$query = "SELECT * FROM users WHERE user_id='".$_SESSION['userid']."'";
				$result = pg_query($db,$query);
				$fields = pg_fetch_array($result);
				if($_POST['oldpass'] == $fields['password']) {
					pg_query($db,"UPDATE users SET password='".pg_escape_string($db,$_POST['newpass'])."'  WHERE userid='".$_SESSION['userid']."'");
					header("Location: account.php?changed=1");
				} else
						header("Location: account.php?passerror=1");
			}
	}
?>
