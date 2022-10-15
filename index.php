<?php
require_once('functions.php');
if(!loggedin())
	header("Location: login.php");
else
	include('header.php');
	include('markdown.php');
?>
              <li class="active"><a href="#">Forum</a></li>
              <li><a href="account.php"><?php echo $_SESSION['username']; ?></a></li>
              <li><a href="logout.php">Logout</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
		<style type="text/css">
		textarea {
    display: block;
    margin-left: auto;
    margin-right: auto;
		}
		</style>
     <div class="container";style="center">
      <?php
        if(isset($_GET['added']))
          echo("<div class=\"alert alert-success\">\nQuestion added!\n</div>");
        else if(isset($_GET['derror']))
          echo("<div class=\"alert alert-error\">\nPlease enter all the details asked before you can continue!\n</div>");
      ?>
      <div style="center">
				<center>
					<br>
					<br>
					<img alt="uery Base" src="Query_Base.jpg" id="logo" style="padding: 28px 0pt 14px;" onload="window.lol&amp;&amp;lol()">
					<br>
					<br>
				</center>
      <div id="addcomment";style="center">
        <form method="post" action="update.php">
        <input type="hidden" name="action" value="query" id="action"/>
        <textarea style="font-family: mono;font-size: 24px;width: 50%;line-height: 38px" rows="1" name="query" id="query" placeholder=""></textarea><br/>
        <input class="btn btn-primary" type="submit" value="Enter Query"/>
        </form>
      </div>
			<div id="report">
				<h2>
					<small>
						Report :
						<?php
						 	if(isset($_GET['q']) && isset($_SESSION['report'])){
								$report =  Markdown($_SESSION['report']);
								echo("<div style=\"background-color: #efefef;border: 1px solid #cccccc;padding-top: 1em;width: 50%;verflow: auto;overflow-y: hidden;\">
												<pre style=\"border: 0;background-color: #efefef;padding: 0;margin-left: 5px;margin-right:5px;width: 100%;font-size: 50%;\">
													".$report."
												</pre>
											</div>");
							}
						 ?>
					 </small>
				 </h2>
			</div>
		<hr>
			<div id="output">
				<h2><small>Result : </small></h2>
				<table class="table table-striped">
    			<tbody>
						<?php
						 	if(isset($_GET['q']) && isset($_SESSION['output'])){
								$output =  Markdown($_SESSION['output']);
								echo $output;
							}
						 ?>
			 		</tbody>
  			</table>
			</div>
			query(SELECT * FROM users;)
        </div>
      </div>
    </div> <!-- /container -->
<?php
  include('footer.php');
?>
