<?php
	/**
	* Load page elements: header, footer, navbars, whatnot
	* Strictly speaking view loading should go into the controller but 
	* included in ion-auth pages for convenience, to save changing ion-auth 
	* controller code and to keep all view loading in one place, ie the view
	* Maybe not MVC, but WTF, bite me. 
	
	*/

	$data['description'] = "";
	$data['keywords'] = "";
	$data['active_topnav'] = "";
	$data['active_leftnav'] = "";
	$data['title'] = "Global Health: change password";
	$data['heading'] = "Change password";
	$this -> load -> view('header_view', $data);
	$this -> load -> view('top_navbar_view', $data);
	$this -> load -> view('left_navbar_view', $data);
	$this -> load -> view('content_start_view', $data);
?>


<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/change_password");?>

      <p>Old Password:<br />
      <?php echo form_input($old_password);?>
      </p>
      
      <p>New Password (at least <?php echo $min_password_length;?> characters long):<br />
      <?php echo form_input($new_password);?>
      </p>
      
      <p>Confirm New Password:<br />
      <?php echo form_input($new_password_confirm);?>
      </p>
      
      <?php echo form_input($user_id);?>
      <p><?php echo form_submit('submit', 'Change');?></p>
      
<?php echo form_close();?>
<?php
	$this -> load -> view ('content_end_view');
	$this -> load -> view ('footer_view');
?>