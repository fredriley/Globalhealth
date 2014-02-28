	<?php $this -> load -> view('resourcedb/header'); ?>

<link rel="stylesheet" href="assets/css/jquery.autocomplete.css"  />
<script type="text/javascript" src="assets/jquery/jquery.autocomplete.js" ></script>
<script type="text/javascript" >

// $function() used as  $(document).ready(function() has already been called in the header view
 $(function()
	{
		
	// Autocomplete plugin. The multiple and separator options mean that the user gets
	// suggestions for strings separated by semicolons, else by default it would be 
	// the whole field string. The autofill option places the first selected tag in the field.
	$("#tags").autocomplete('form/tag_autocomplete', 
		{
		multiple: true,
		multipleSeparator: ';', 
		autoFill: true
		});
	
 }); // end function
 
</script>


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
	foreach($origins_query -> result_array() as $row)
	{
		$id = $row['id']; $title = $row['title'];
		$origins_ary[$id] = $title;
	}
	# Get the origin of this resource - single value
	

	# Resource types
	foreach($resource_types_query -> result_array() as $row)
	{
		$id = $row['id']; $title = $row['title'];
		$resource_types_ary[$id] = $title;
	}	
	
	# Get tags attached to this resource, combine into 
	# semicolon-delimited string for shoving into tags field
	# Use implode() to combine array elements to create a
	# delimited string to put into the tags field. 
	# NB: tags passed to this script as an array.

	$tags_str = implode(';', $tags_ary);
	
	?>
	<h1><?php echo $heading;?></h1>
    <div id="message" class="notify"><?php echo $message; ?></div>
    <div id="error" class="error"><?php echo $error; ?></div>

	<!-- FORM -->
    <form name="form1" method="post" action="">
      <p>
        <label for="title">Title</label>
        <br />
        <input name="title" type="text" id="title" value="<?php echo $resource_ary['title']; ?>" size="50">
      </p>
      <p>
        <label for="url">URL<br />
        </label>
        <input name="url" type="text" id="url" value="<?php echo $resource_ary['url']; ?>" size="50">
        	&nbsp;&nbsp;<a href="<?php echo $resource_ary['url']; ?>" target="win">Visit link (new window)</a>
      </p>
      <p>
        <label for="description">Description<br />
        </label>
        <textarea name="description" id="description" cols="45" rows="5"><?php echo $resource_ary['description']; ?></textarea>
      </p>
      <p>
        <label for="tags">Tags</label>
        <br />
		<input name="tags" type="text" id="tags" value="<?php echo $tags_str; ?>" size="30">
      </p>
      <p>
        <label for="type">Type</label><br />
      <?php
	  	# Use form helper functions to create <select> elements. The third parameter is
		# the value of the selected <option>
	  	echo form_dropdown('type', $resource_types_ary, $resource_ary['type']); 
	  ?>
      </p>
      <p>
        <label for="source">Source</label> <br />
        <?php 
		# Third param is selected item, which is ID 1 representing 'external source'
		echo form_dropdown('source', $origins_ary, $resource_ary['source']); 
		?>
        
      </p>
      <p>
        <label for="subject_area">Subject area(s)</label><br />
        <?php 
		# Display subjects as checkboxes inside a scrollable <div>. Each checkbox has the same
		# name subjects[] which returns an associative array on POST. If the subject is
		# attached to the resource, check it.
		?>
      <div id="subjects">
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
  <label for="creator">Creator<br />
  </label>
  <input name="creator" type="text" id="creator" size="30" value="<?php echo htmlspecialchars($resource_ary['creator']); ?>">
</p>
<p>
  <label for="rights">Rights<br />
  </label>
  <textarea name="rights" id="rights" cols="45" rows="3"><?php echo $resource_ary['rights']; ?></textarea>
</p>

      <p>
        <label for="restricted">Restricted</label>
        <br />
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
        <label for="visible">Visible<br />
        </label>
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
      <p>Notes<br />
        <textarea id="notes" name="notes" cols="45" rows="3"><?php echo $resource_ary['Notes']; ?></textarea>
      </p>
        <input type="submit" name="submit" id="submit" value="Submit">
      <p>&nbsp;</p>
    </form>
    <p>&nbsp;</p>
<?php $this -> load -> view('resourcedb/footer'); ?>
