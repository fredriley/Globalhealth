<div id="infoMessage" class="error"><?php echo $message;?></div>

<p>You can edit your personal details below. To change your password, use the <a href="auth/change_password">change password form</a>. All fields are required.</p>

<?php echo form_open("auth/edit_profile");?>

      <p>
		<label for="first_name" class="label label-important">First name</label><br />
		<input type="text" name="first_name" value="<?php echo $firstname; ?>" id="first_name" class="input-xlarge" required/>

      </p>
      
      <p>
		<label for="last_name" class="label label-important">Last name</label><br />
		<input type="text" name="last_name" value="<?php echo $lastname; ?>" id="last_name" class="input-xlarge" required/>
      </p>
      
      <p>
	    <label for="email" class="label label-important">Email</label><br />
		<input type="text" name="email" value="<?php echo $email; ?>" id="email" class="input-xlarge" required/><br>

      <p class="label label-warning">NB: Your email is your login name, so if you change it you'll need to use the new address as your login.
      </p>
      
      <p><?php echo form_submit('submit', 'Update profile');?></p>
      
<?php echo form_close();?>



