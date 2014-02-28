<?php $this -> load -> view('resourcedb/header'); ?>
<h1><?php echo $heading; ?></h1>
<div id="infoMessage" class="error"><?php echo $message;?></div>

<p>This is your current user profile:</p>

<p>Email/username: <?php echo $email; ?></p>
<p>First name: <?php echo $firstname; ?></p>
<p>Last name: <?php echo $lastname; ?></p>
<p>User group: <?php echo $userlevel; ?></p>

<p><a href="auth/edit_profile">Edit your profile</a> | <a href="auth/change_password">Change password</a></p>

<?php $this -> load -> view('resourcedb/footer'); ?>

