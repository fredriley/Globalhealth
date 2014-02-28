<?php $this -> load -> view('resourcedb/header'); ?>
<?php
# Get all details of the user just registered. The user_id is passed from the controller in register.php
# NB: the call to user() returns an object, so you have to use row() to get the user details
# See Ion Auth documentation at http://benedmunds.com/ion_auth/
$user = $this->ion_auth->user($user_id)->row();
//print_r($user);
?>
<h1><?php echo $heading;?></h1>

<p>You've been successfully registered with the Global Health resources repository. Your details are:</p>

<ul>
	<li>First name: <?php echo $user->first_name; ?></li>
	<li>Last name: <?php echo $user->last_name; ?></li>
	<li>Email: <?php echo $user->email; ?></li>
</ul>

<p>Your status is 'member', and this enables you to:</p>
<ul>
	<li>comment on resource entries</li>
	<li>suggest resources for inclusion in the database</li>
</ul>
<p>If you'd like to be a contributing user, so that you can add and edit resources, please contact the site administrator requesting these rights.</p>
<p><strong>NB:</strong> When you login, use your email address of <strong><?php echo $user->email; ?></strong> as your username. </p>

<?php echo anchor('auth/login', 'Login', ""); ?>

<?php $this -> load -> view('resourcedb/footer'); ?>

