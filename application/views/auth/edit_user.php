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
	$data['title'] = "Global Health: edit user";
	$data['heading'] = "Edit user";
	$this -> load -> view('header_view', $data);
	$this -> load -> view('top_navbar_view', $data);
	$this -> load -> view('left_navbar_view', $data);
	$this -> load -> view('content_start_view', $data);
?>

<p>Please enter the users information below.</p>

<div id="infoMessage"><?php echo $message;?></div>

<?php 
	$attributes = array('id' => 'form1');
	echo form_open(current_url(), $attributes);?>

      <p>
            <label for="firstname" class="label label-important">First name</label><br>
            <?php echo form_input($first_name);?>
      </p>

      <p>
            <label for="lastname" class="label label-important"><strong>Last name</strong></label><br>
            <?php echo form_input($last_name);?>
      </p>

      <p>
            <label for="company" class="label">Company/institution/organisation</label><br>
            <?php echo form_input($company);?>
      </p>

      <p>
            <label for="phone" class="label">Phone</label> <br />
            <?php echo form_input($phone);?>
      </p>
	  
      <p>
            <label for="url" class="label" >URL</label><br />
            <?php echo form_input($url);?>
      </p>
 
	<p>
            <label for="country" class="label label-important" >Country</label><br />
			<select id="country" name="country" size="1" >
            <?php 
			foreach ($countries_query -> result() as $row) 
			{
				$option = "<option value=\"" . $row -> id . "\"" ;
				if ($row -> id == $country)
				{
					$option .= " selected=\"selected\" ";
				}
				$option .= ">" . $row -> country_name . "</option>\n";
				echo $option;
			}
			?>
			</select>
      </p>
      <p>
            <label for="password" class="label" >Password: (if changing password)</label><br />
            <?php echo form_input($user_password);?>
      </p>

      <p>
            <label for="password_confirm" class="label">Confirm Password: (if changing password)</label><br />
            <?php echo form_input($user_password_confirm);?>
      </p>
      
	 <h3>Member of groups</h3>
	<?php foreach ($groups as $group):?>					
	<label class="checkbox">
	<?php
		$gID=$group['id'];
		$checked = null;
		$item = null;
		foreach($currentGroups as $grp) {
			if ($gID == $grp->id) {
				$checked= ' checked="checked"';
			break;
			}
		}
	?>
	<input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
	<?php echo $group['name'];?>
	</label>
	<?php endforeach?>

      <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden($csrf); ?>

      <p><?php echo form_submit('submit', 'Save User');?></p>

<?php echo form_close();?>

<?php
	$this -> load -> view ('content_end_view');
	$this -> load -> view ('footer_view');
?>

<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript">

 $(document).ready(function()
 {
 
	// Validation code
	// ---------------
	// Documentation at http://docs.jquery.com/Plugins/Validation
	$("#form1").validate(
	{
		rules: 
		{
			firsname: 
			{
				required: true
			}, 
			lastname:
			{
				required: true
			}, 
			phone:
			{
				digits: true
			}, 
			email:
			{
				required: true,
				email: true
			},
			url:
			{
				url: true
			}, 
			user_password: 
			{
				minlength: 6
			},
			user_password_confirm: 
			{
				minlength: 6,
				equalTo: "#user_password"				
			}		
		
		}
	});	
	
 }); // end document ready
</script>