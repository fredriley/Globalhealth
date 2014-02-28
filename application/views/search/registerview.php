<?php $this -> load -> view('resourcedb/header'); ?>
<p>To register for the Global Health Repository, please fill in the fields below. This is <em>only</em> for preventing abuse and spam - your details will <em>never</em> be passed on to others without your explicit permission. You can continue to use the database without registering, you just won't be able to comment on, and rate, resources, and suggest resources for inclusion.</p>
<p>NB: Your password will be encrypted, and will thus <em>not</em> be transmitted or stored in plaintext form so even the database administrator won't be able to read it.</p>


<div class='mainInfo'>
	
	<div id="infoMessage" class="error"><?php echo $message;?></div>
	
    <?php echo form_open("register");?>
      <p>First Name:<br />
      <?php echo form_input($first_name);?>
      </p>
      
      <p>Last Name:<br />
      <?php echo form_input($last_name);?>
      </p>
      
      <p>Email:<br />
      <?php echo form_input($email);?>
      </p>
            
      <p>Password (minimum 8 characters):<br />
      <?php echo form_input($password);?>
      </p>
      
      <p>Confirm Password:<br />
      <?php echo form_input($password_confirm);?>
      </p>
      
      
      <p><?php echo form_submit('submit', 'Register');?></p>

      
    <?php echo form_close();?>

</div>

<?php $this -> load -> view('resourcedb/footer'); ?>

