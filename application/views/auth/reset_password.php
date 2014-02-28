<?php
	/**
	* Load page elements: header, footer, navbars, whatnot
	* Strictly speaking view loading should go into the controller but 
	* included in ion-auth pages for convenience, to save changing ion-auth 
	* controller code and to keep all view loading in one place, ie the view
	* Maybe not MVC, but WTF, bite me. 
	
	*/

	$data['description'] = "Change your password for the Global Health repository";
	$data['keywords'] = "";
	$data['active_topnav'] = "";
	$data['active_leftnav'] = "Login";
	$data['heading'] = "Change password";
	$this -> load -> view('header_view', $data);
	$this -> load -> view('top_navbar_view', $data);
	$this -> load -> view('left_navbar_view', $data);
	$this -> load -> view('content_start_view', $data);
?>

<div id="infoMessage"><?php echo $message;?></div>
<p>You can reset your password for the Global Health repository below:</p>

<?php echo form_open('auth/reset_password/' . $code);?>
      
	<p>
		New Password (at least <?php echo $min_password_length;?> characters long): <br />
		<?php echo form_input($new_password);?>
	</p>

	<p>
		Confirm New Password: <br />
		<?php echo form_input($new_password_confirm);?>
	</p>

	<?php echo form_input($user_id);?>
	<?php echo form_hidden($csrf); ?>

	<p><?php echo form_submit('submit', 'Change');?></p>
      
<?php echo form_close();?>

<?php
	$this -> load -> view ('content_end_view');
	$this -> load -> view ('footer_view');
?>
