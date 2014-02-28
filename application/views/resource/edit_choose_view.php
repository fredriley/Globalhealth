				<?php $this -> load -> view('resource/contribute_submenu_view', $active_submenu); ?>
<!-- CONTENT -->




    <?php
	# Get resource IDs and titles and shove them in a combo box
	
	?>
	<p>You can pick a resource title to edit from the dropdown box below...</p>

	<!-- FORM -->
	<?php
	echo form_open('resource/edit', "class=\"form-inline\"");
	# Go through query sent by controller to produce a combo box 
	foreach ($resource_query -> result() as $row)
	{
		$resource_ary[$row -> id] = $row -> title;
	}


	echo form_dropdown('resource_id', $resource_ary,"", "class=\"span6 \""); echo "&nbsp;&nbsp;";
	echo form_submit('dropdown_submit', 'Submit', "class=\"btn-primary\"");
	echo form_close();

	# Give user an auto-suggest field in case they prefer typing
	# to choosing from a combo box. Requires a bit of jQuery trickery 
	# to put the resource id into a hidden field
	# Use HTML to create input and hidden fields rather than HTML Helper method, as we need
	# the fields to have id attributes for the jQuery auto-suggest code
	?>

    <p>...or you can type part of the title in the field below:</p>
	<form method="post" action="resource/edit" class="form-inline" >
		<input type="text" id="resource_title" name="resource_title" class="span6"  />&nbsp; 
		<input type="hidden" id="resource_id" name="resource_id"  />	
		<input type="submit" id="title_submit" name="title_submit" value="Submit" class="btn-primary" />
    </form>
    <p>You can also use Browse and Search to find a resource, and as long as you're logged in as a contributor an edit option will be visible. </p>
	<h2>Recently-edited records</h2>
	<?php
		foreach($recently_edited -> result() as $row)
		{
			$edit_link = "resource/edit/" . $row -> id; 
			$edit_text = $row -> title . " (" . $row -> metadata_modified . ")";
			echo "<p>" . anchor($edit_link, $edit_text) . "</p>";
		}
	?>    
<!-- END CONTENT -->
