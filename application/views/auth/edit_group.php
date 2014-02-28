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
	$data['heading'] = "Edit group";
	$this -> load -> view('header_view', $data);
	$this -> load -> view('top_navbar_view', $data);
	$this -> load -> view('left_navbar_view', $data);
	$this -> load -> view('content_start_view', $data);
?>

<p>You can edit the group description below. The group name needs to remain as defined.</p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(current_url());?>

      <p>
            Group Name: <br />
            <?php echo form_input($group_name);?>
      </p>

      <p>
            Group Description: <br />
            <?php echo form_textarea($group_description);?>
      </p>

      <p><?php echo form_submit('submit', 'Save Group');?></p>

<?php echo form_close();?>

<?php
	$this -> load -> view ('content_end_view');
	$this -> load -> view ('footer_view');
	$this -> load -> view ('tinymce_script_view');
?>