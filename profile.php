<?php
	require_once('functions.php');
	if(!loggedin())
		header("Location: login.php");
	else
		include('header.php');
		connectdb();
?>
              <li><a href="index.php">Forum</a></li>
              <li><a href="account.php"><?php echo $_SESSION['username']; ?></a></li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
    <?php
      // get the name, email and status
      $query = "SELECT * FROM users WHERE user_id='".$_GET['uid']."'";
      $result = mysqli_query($db,$query);
      $row = mysqli_fetch_array($result);
    ?>
    <h1><small>Profile details for <strong><?php echo($_GET['uid']); ?></strong></small></h1>
    <h3><small>Name: <strong><?php echo $row['firstname']." ".$row['lastname'];?></strong></small></h3>
    <h3><small>Email: <strong><?php if($row['email']==""){echo "No email found";}else echo($row['email']);?></strong></small></h3>
    <br/><br/>
    </div> <!-- /container -->

<?php
	include('footer.php');
?>
