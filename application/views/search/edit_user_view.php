	<?php $this -> load -> view('resourcedb/header'); ?>
	<h1><?php echo $heading;?></h1>
    
    <?php 
	# Get user details from object passed from controller, via ion-auth get_user() function
	$fullname = $user -> first_name . " " . $user -> last_name;
	$username = $user -> username;
	$last_login = unix_to_human($user -> last_login, TRUE, 'eu'); 
	//$group = $user -> group;
	?>

<p><?php echo $msg; ?>
<?php 
/* Last login shows current login, which isn't much cop - edit login function in auth controller 
   to get user data prior to login, then display last login
<p>You last logged in at <?php echo $last_login; ?> </p>
*/
?>
    
    <?php $this -> load -> view('resourcedb/footer'); ?>
