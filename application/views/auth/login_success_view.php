 <!-- CONTENT -->    
    <?php 
	# Get user details from object passed from controller, via ion-auth get_user() function
	$fullname = $user -> first_name . " " . $user -> last_name;
	$username = $user -> username;
	$last_login = unix_to_human($user -> last_login, TRUE, 'eu'); 

	?>

<p>Hello, <?php echo $fullname; ?>. You are now logged into the Global Health repository as the following:</p>

<p>Username: <?php echo $username; ?>	</p>
<p><a href="auth/groupinfo">User group(s)</a>: <?php 
	# Groups that user's a part of is passed from controller as a mysql_result object, 
	# so treat that as a query result to display the group names. 
	foreach ($users_groups -> result() as $row)
	{
		echo $row -> name . "&nbsp;&nbsp;";
	}

?></p>


<?php /* Last login shows current login, which isn't much cop - edit login function in auth controller 
   to get user data prior to login, then display last login
<p>You last logged in at <?php echo $last_login; ?> </p>
*/
?>
<!-- END CONTENT -->

