	<?php $this -> load -> view('resourcedb/header'); ?>
	<h1><?php echo $heading;?></h1>
    
    <?php 
	# Get user details from object passed from controller, via ion-auth get_user() function
	$fullname = $user -> first_name . " " . $user -> last_name;
	$username = $user -> username;
	$last_login = unix_to_human($user -> last_login, TRUE, 'eu'); 
	//$group = $user -> group;
	?>

<p>Hello, <?php echo $fullname; ?>. You are logged into the Global Health repository as the following:</p>

<p>Username: <?php echo $username; ?>	</p>
<p>User group: <?php echo $group; ?></p>
<p>You are god. Exercise your rights over users</p>
<p>Users: 
<table cellpadding="3" cellspacing="3" border="1">
<tr>
	<th>id</th>
	<th>name</th>
	<th>username</th>
	<th>&nbsp;</th>
</tr>


<?php 
//print_r($users);
foreach ($users as $user)
{
	echo "<tr>";
		echo "<td>" . $user->id . "</td>";
		echo "<td>" . $user->last_name . ", " . $user->first_name . "</td>";
		echo "<td>" . $user->username . "</td>";
		echo "<td><a href=\"admin/edit_user/" . $user->id . "\">edit user</a></td>";
	echo "</tr>";
}
 ?>
</table>
</p>
<?php 
/* Last login shows current login, which isn't much cop - edit login function in auth controller 
   to get user data prior to login, then display last login
<p>You last logged in at <?php echo $last_login; ?> </p>
*/
?>
    
    <?php $this -> load -> view('resourcedb/footer'); ?>
