<div id="infoMessage" class="error"><?php echo $message;?></div>

<p>This is your current user profile:</p>
<p>User ID: <?php echo $id; ?></p>
<p>Username: <?php echo $username; ?></p>
<p>Email: <?php echo $email; ?></p>
<p>First name: <?php echo $firstname; ?></p>
<p>Last name: <?php echo $lastname; ?></p>
<p><a href="auth/groupinfo">User group(s)</a>: <?php 
	# Groups that user's a part of is passed from controller as a mysql_result object, 
	# so treat that as a query result to display the group names. 
	foreach ($users_groups -> result() as $row)
	{
		echo $row -> name . "&nbsp;&nbsp;";
	}

?></p>

<p><a href="auth/edit_profile">Edit your profile</a> | <a href="auth/change_password">Change password</a></p>



