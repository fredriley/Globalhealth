
<?php
	/**
	* Load page elements: header, footer, navbars, whatnot
	* Strictly speaking view loading should go into the controller but 
	* included in ion-auth pages for convenience, to save changing ion-auth 
	* controller code and to keep all view loading in one place, ie the view
	* Maybe not MVC, but WTF, bite me. 
	
	*/

	$data['description'] = "Login to the Global Health repository";
	$data['keywords'] = "";
	$data['active_topnav'] = "";
	$data['active_leftnav'] = "Login";
	$data['heading'] = "Login";
	$this -> load -> view('header_view', $data);
	$this -> load -> view('top_navbar_view', $data);
	$this -> load -> view('left_navbar_view', $data);
	$this -> load -> view('content_start_view', $data);
?>

	<p>If you're a registered user of the Global Health repository, please login with your email address and password below. If you wish to be registered with the system as a contributor, please fill in the <a href="form/request" >registration request form</a>. </p>
	
	<div id="infoMessage" class="error"><?php echo $message;?></div>
	
    <?php echo form_open("auth/login");?>
    	
      <p>
      	<label for="identity">Email:</label><br  />
      <input type="text" name="identity" id="identity" size="40" maxlength="60"  />
      </p>
      
      <p>
      	<label for="password">Password</label><br  />
      	<?php echo form_input($password);?>
      </p>
      
      <p>
	      <label for="remember">Remember Me</label>
	      <?php echo form_checkbox('remember', '1', FALSE);?>
	  </p>
      
      
      <p><?php echo form_submit('submit', 'Login');?></p>

      
    <?php echo form_close();?>
    
    <p><a href="auth/forgot_password/">Forgotten your password?</a></p>

<?php
	$this -> load -> view ('content_end_view');
	$this -> load -> view ('footer_view');
?>
