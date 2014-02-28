<?php $this -> load -> view('resourcedb/header'); ?>
<h1><?php echo $heading;?></h1>

<p>To register for the resource database, please fill in the fields before. This is <em>only</em> for preventing abuse and spam - your details will <em>never</em> be passed on to others without your explicit permission. You can continue to use the database without registering, you just won't be able to comment on, and rate, resources, and suggest resources for inclusion.</p>
<p>NB: Your password will be MD4-encrypted, and will thus <em>not</em> be transmitted or stored in plaintext form.</p>

<?php echo validation_errors(); ?>

<?php echo form_open('register'); ?>

<h5>Username</h5>
<input type="text" name="username" value="<?php echo set_value('username'); ?>" size="50" />

<h5>Password</h5>
<input type="password" name="password" value="<?php echo set_value('password'); ?>" size="50" />

<h5>Password Confirm</h5>
<input type="password" name="passconf" value="<?php echo set_value('passconf'); ?>" size="50" />

<h5>Email Address</h5>
<input type="text" name="email" value="<?php echo set_value('email'); ?>" size="50" />

<div><input type="submit" value="Submit" /></div>

</form>

</body>
</html>
