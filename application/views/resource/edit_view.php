

    <?php
	# POPULATE EDIT FORM WITH EXISTING VALUES
	
	# Get full resource record detail. 
	$resource_ary = $resource_detail_query -> row_array();
	//print_r($resource_ary);

	# Get subjects, origins, and resource types for <select> elements. 
	# Subjects
	# --------
	foreach($subjects_query -> result_array() as $row)
	{
		$id = $row['id']; $title = $row['title'];
		$subjects_ary[$id] = $title;
	}
	# Attached Subjects
	# The subjects attached to this resource are passed from the controller as the 
	# array $attached_subjects_ary of subject titles indexed by subject numbers. 
	# So no need to do owt right now - this var will be used further down

	# Origins
	/* foreach($origins_query -> result_array() as $row)
	{
		$id = $row['id']; $title = $row['title'];
		$origins_ary[$id] = $title;
	}
	*/
	# Get the origin of this resource - single value
	

	# Resource types
	foreach($resource_types_query -> result_array() as $row)
	{
		$id = $row['id']; $title = $row['title'];
		$resource_types_ary[$id] = $title;
	}	

	# Get tags attached to this resource, combine into 
	# comma-delimited string for shoving into tags field
	# Use implode() to combine array elements to create a
	# delimited string to put into the tags field. 
	# NB: tags passed to this script as an array.

	$tags_str = implode(',', $tags_ary);
	
	?>
	
				<?php $this -> load -> view('resource/contribute_submenu_view', $active_submenu); ?>
				
<!-- CONTENT --> 
<?php
	# Display delete resource option
	# The user is prompted, with a Bootstrap modal dialogue, to confirm deletion.
	# This uses the jConfirm library, loaded by the controller in views/confirm_script_view
	# at the end of the page, after the closing html tag
	# http://myclabs.github.com/jquery.confirm/
	$delete_icon = "<img src=\"img/bin.png\" alt=\"Delete this resource\" title=\"Delete this resource\" >";
	$delete_link = "resource/delete/" . $resource_ary['id'];
	$delete_confirm = "<a href=\"" . $delete_link . "\" class=\"confirm pull-right\" >". $delete_icon . "</a>";
	echo $delete_confirm; 
?>
<p>Mandatory fields in <span class="label label-important">red</span>. Please fill in as many other fields as you can.</p>
    <div id="message" class="notify"><?php echo $message; ?></div>
    <div id="error" class="error"><?php echo $error; ?></div>

	<!-- FORM -->
    <form name="form1" method="post" action="<?php echo current_url(); ?>">
		<p><label for="id" class="label">Resource ID</label><br>
		<input name="id" type="text" readonly="readonly" class="input-small" value="<?= $resource_ary['id']; ?>" ></p>
      <p>
        <label for="title" class="label label-important">Title</label>
        <br />
        <input name="title" type="text" id="title" class="input-xxlarge" value="<?= set_value('title', $resource_ary['title']); ?>" >

      </p>
      <p>
        <label for="url" class="label label-important">URL</label><br />
        <input name="url" type="text" id="url" class="input-xxlarge" value="<?= set_value('url', $resource_ary['url']); ?>" >
        	&nbsp;&nbsp;<a href="<?php echo $resource_ary['url']; ?>" target="win">Visit link (new window)</a>
      </p>
      <p>
        <label for="description" class="label label-important" data-toggle="tooltip" title="Type a brief description of the resource. You can use rich text for formatting.">Description</label><br />
        
        <textarea name="description" id="description" cols="45" rows="5" class="input-xxlarge"><?= set_value('description', $resource_ary['description']); ?></textarea>
      </p>
      <p>
        <label for="subject_area" class="label label-important" data-toggle="tooltip" title="Select one or more categories for the resource">Categories</label><br />
        <?php 
		# Display subjects as checkboxes. Each checkbox has the same
		# name subjects[] which returns an associative array on POST. If the subject is
		# attached to the resource, check it.
		?>
      <div id="subjects" >
		<?php

		foreach ($subjects_ary as $key => $val)
		{
			if (array_key_exists($key, $attached_subjects_ary))
			{
				echo form_checkbox("subjects[]", $key, TRUE) . "&nbsp;&nbsp;" . $val . "<br />\n";	
			}
			else
			{
				echo form_checkbox("subjects[]", $key, FALSE) . "&nbsp;&nbsp;" . $val . "<br />\n";	
			}
		}
		?>
      </div>
      </p>
      <p>
        <label for="tags" class="label" data-toggle="tooltip" title="Type a keyword or phrase followed by a comma to enter the tag. To remove a tag, just click x on the right of the tag box.">Tags</label>
        <br />
		<input name="tags" type="text" id="tags" class="input-xxlarge" value="<?= set_value('tags', $tags_str); ?>" size="30">
      </p>
      <p>
        <label for="type" class="label" data-toggle="tooltip" title="Choose one resource type">Type</label><br />
      <?php
	  	# Use form helper functions to create <select> elements. The third parameter is
		# the value of the selected <option>
	  	echo form_dropdown('type', $resource_types_ary, $resource_ary['type']); 
	  ?>
      </p>


<p>
  <label for="author" class="label" data-toggle="tooltip" title="Enter the author name(s), if known.">Author</label><br />

  <input name="author" type="text" id="author" class="input-xlarge" value="<?= set_value('author', htmlspecialchars($resource_ary['author'])); ?>">
</p>
<p>
  <label for="rights" class="label" data-toggle="tooltip" title="Details of usage rights (eg Creative Commons) if known">Rights</label><br>
  <textarea name="rights" id="rights" class="input-xlarge" rows="3"><?= set_value('rights', $resource_ary['rights']); ?></textarea>
</p>

      <p>
        <label for="restricted" class="label">Restricted</label><br />
        <?php
			if ($resource_ary['restricted'] == 1)
			{
				echo "Yes " . form_radio('restricted', '1', TRUE) . "&nbsp; &nbsp;";
				echo "No " . form_radio('restricted', '0', FALSE);
			}
			else
			{
				echo "Yes " . form_radio('restricted', '1', FALSE) . "&nbsp; &nbsp;";
				echo "No " . form_radio('restricted', '0', TRUE);
			}			
		
		?>
      </p>
      <p>
        <label for="visible" class="label">Visible</label><br />

        <?php
			if ($resource_ary['visible'] == 1)
			{
				echo "Yes " . form_radio('visible', '1', TRUE) . "&nbsp; &nbsp;";
				echo "No " . form_radio('visible', '0', FALSE);
			}
			else
			{
				echo "Yes " . form_radio('visible', '1', FALSE) . "&nbsp; &nbsp;";
				echo "No " . form_radio('visible', '0', TRUE);
			}			
		
		?>
      </p>
      <p>
	  <label for="notes" class="label" data-toggle="tooltip" title="Private notes about the resource. These will not be visible to repository users, only to contributors">Notes</label><br />
        <textarea id="notes" name="notes" class="input-xlarge" rows="3"><?= set_value('notes', $resource_ary['Notes']); ?></textarea>
      </p>
        <input type="submit" name="submit" id="submit" value="Submit">
      <p>&nbsp;</p>
    </form>
    <p>&nbsp;</p>

