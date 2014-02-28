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
	$data['title'] = "Global Health: create user";
	$data['heading'] = "Create user";
	$this -> load -> view('header_view', $data);
	$this -> load -> view('top_navbar_view', $data);
	$this -> load -> view('left_navbar_view', $data);
	$this -> load -> view('content_start_view', $data);
?>

<p>Please enter the users information below. Fields labelled <span class="label label-important">as important</span> are required.</p>

<div id="infoMessage"><?php echo $message;?></div>
<form method="post" action="auth/create_user" id="form1">
	<p><label for="firstname" class="label label-important">First name</label><br>
	<input type="text" name="firstname" id="firstname" class="required" required ></p>

	<p><label for="lastname" class="label label-important">Last name</label><br>
	<input type="text" name="lastname" id="lastname" class="required" required ></p>

	<p><label for="company" class="label">Company/institution/organisation</label><br>
	<input type="text" name="company" id="company" ></p>
	
	<p><label for="email" class="label label-important">Email</label><br>
	<input type="text" name="email" id="email" required></p>	
	
    <p><label for="phone" class="label">Phone</label> <br />
    <input type="tel" name="phone" id="phone" maxlength="15" class="" placeholder="Contact phone number" ></p>
	
    <p><label for="url" class="label">URL</label> <br />
    <input type="tel" name="url" id="url" maxlength="100" class="input-large" placeholder="URL of personal page/site" ></p>
	
	<p><label for="country" class="label label-important" >Country:</label> <br />
	<select id="country" name="country" size="1" >
	<?php 
	foreach ($countries_query -> result() as $row) 
	{
		$option = "<option value=\"" . $row -> id . "\"" ;
		if ($row -> id == 10) // England - default
		{
			$option .= " selected=\"selected\" ";
		}
		$option .= ">" . $row -> country_name . "</option>\n";
		echo $option;
	}
	?>
	</select></p>

	<p><label for="password" class="label label-important">Password</label><br>
	<input type="password" name="user_password" id="user_password" class="required" required></p>	

	<p><label for="password_confirm" class="label label-important">Confirm password</label><br>
	<input type="password" name="user_password_confirm" id="user_password_confirm" class="required" required></p>		

	<input type="submit" class="btn" value="Create user">
	
</form>

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
				required: true,
				minlength: 6
			},
			user_password_confirm: 
			{
				required: true,
				minlength: 6,
				equalTo: "#user_password"				
			}		
		
		}
	});	
	
 }); // end document ready
</script>