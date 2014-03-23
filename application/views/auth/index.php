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
	$data['title'] = "Global Health: user administration";
	$data['heading'] = "User administration";
	$this -> load -> view('header_view', $data);
	$this -> load -> view('top_navbar_view', $data);
	$this -> load -> view('left_navbar_view', $data);
	$this -> load -> view('content_start_view', $data);
?>
<p><a href="<?php echo site_url('auth/create_user');?>">Create a new user</a> </p>

<?php
/*  
Commented out in version 1.0 to prevent a raft of new user groups being created!
$url = site_url('auth/create_group');
echo anchor ($url, "Create a group");
*/
?>	

<p>Existing users are in the table below. </p>
<p>If you need help, see the short User administration guide 
	(<a href="docs/user_admin.rtf">RTF</a>) (<a href="docs/user_admin.odt">Libre Office</a>). This is restricted - when prompted, use <span class="label label-important">globalhealth/squirrels</span> to view it. </p>


<div id="infoMessage"><?php echo $message;?></div>

<table border="1" cellpadding="3" cellspacing="3">
	<tr>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Email</th>
		<th>Groups</th>
		<th>Status</th>
		<th>Action</th>
	</tr>
	<?php foreach ($users as $user):?>
		<tr>
			<td><?php echo $user->first_name;?></td>
			<td><?php echo $user->last_name;?></td>
			<td><?php echo $user->email;?></td>
			<td>
				<?php foreach ($user->groups as $group):?>
					<?php echo anchor("auth/edit_group/".$group->id, $group->name) ;?><br />
                <?php endforeach?>
			</td>
			<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, 'Active') : anchor("auth/activate/". $user->id, 'Inactive');?></td>
			<td><?php echo anchor("auth/edit_user/".$user->id, 'Edit') ;?> | <?php echo anchor("auth/delete/".$user->id, 'Delete', "class=\"confirm\"") ;?></td>
		</tr>
	<?php endforeach;?>
</table>

<?php
	$this -> load -> view ('content_end_view');
	$this -> load -> view ('footer_view');
	# Load confirmation script for 'are you sure?' dialogue on delete
	$script_data['text'] = "\"Do you really want to delete this user? You cannot undo this action. You can deactivate the user instead, for later reactivation if required.\"";
	$this -> load -> view('confirm_script_view', $script_data);
?>