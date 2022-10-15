<?php
	require_once('functions.php');
	if(!loggedin())
		header("Location: login.php");
	else
		include('header.php');
?>
			        <li><a href="index.php">Forum</a></li>
              <li class="active"><a href="#"><?php echo $_SESSION['username']; ?></a></li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
    <?php
        if(isset($_GET['changed']))
          echo("<div class=\"alert alert-success\">\nAccount settings updated!\n</div>");
        else if(isset($_GET['passerror']))
          echo("<div class=\"alert alert-error\">\nThe old password you entered is wrong. Please enter the correct password and try again.\n</div>");
        else if(isset($_GET['derror']))
          echo("<div class=\"alert alert-error\">\nPlease enter all the details asked before you can continue!\n</div>");
    ?>
    Account settings for <?php echo($_SESSION['username']);?><hr/>
        <?php
            $query = "SELECT password FROM users WHERE userid='".$_SESSION['userid']."'";
            $result = pg_query($db,$query);
            $fields = pg_fetch_array($result);
          ?>
        <form method="post" action="update.php">
          <input type="hidden" name="action" value="password"/>
          <h1><small>Change Password</small></h1>
          Old password: <input type="password" name="oldpass" value="" /><br/>
          New password: <input type="password" name="newpass"/><br/><br/>
          <input class="btn" type="submit" name="submit" value="Change Password"/>
          </form>
          <hr/>

          <form method="post" action="update.php">
          <input type="hidden" name="action" value="email"/>
          <h1><small>Change Email</small></h1>
          <?php
            $query = "SELECT email FROM users WHERE userid='".$_SESSION['userid']."'";
            $result = pg_query($db,$query);
            $fields = pg_fetch_array($result);
          ?>
          Email: <input type="email" name="email" value="<?php echo $fields['email'];?>"/><br/><br/>
          <input class="btn" type="submit" name="submit" value="Change Email"/>
          </form>
    </div>

<?php
  include('footer.php');
?>
