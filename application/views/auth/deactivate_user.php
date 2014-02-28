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
	$data['active_leftnav'] = "User admin";
	$data['heading'] = "Deactivate user";
	$this -> load -> view('header_view', $data);
	$this -> load -> view('top_navbar_view', $data);
	$this -> load -> view('left_navbar_view', $data);
	$this -> load -> view('content_start_view', $data);
?>

<p>Are you sure you want to deactivate the user '<?php echo $user->username; ?>'</p>
	
<?php echo form_open("auth/deactivate/".$user->id);?>

    <label class="radio" for="confirm">Yes
	<input type="radio" name="confirm" value="yes" checked="checked" /> </label>
	
  	<label class="radio" for="confirm">No
    <input type="radio" name="confirm" value="no" /></label>


  <?php echo form_hidden($csrf); ?>
  <?php echo form_hidden(array('id'=>$user->id)); ?>

  <p><?php echo form_submit('submit', 'Submit');?></p>

<?php echo form_close();?>

<?php
	$this -> load -> view ('content_end_view');
	$this -> load -> view ('footer_view');
?>