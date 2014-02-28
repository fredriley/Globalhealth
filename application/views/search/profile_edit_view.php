<?php $this -> load -> view('resourcedb/header'); ?>
<h1><?php echo $heading; ?></h1>
<div id="infoMessage" class="error"><?php echo $message;?></div>

<p>You can edit your personal details below. To change your password, use the <a href="auth/change_password">change password form</a></p>

<?php echo form_open("auth/edit_profile");?>

      <p>First name:<br />
      <?php echo form_input('first_name', $firstname);?>
      </p>
      
      <p>Last name:<br />
      <?php echo form_input('last_name', $lastname);?>
      </p>
      
      <p>Email:<br />
      <?php echo form_input('email', $email);?><br />
      NB: Your email is your login name, so if you change it you'll need to use the new address as your login.
      </p>
      
      <p><?php echo form_submit('submit', 'Update profile');?></p>
      
<?php echo form_close();?>

<?php $this -> load -> view('resourcedb/footer'); ?>

