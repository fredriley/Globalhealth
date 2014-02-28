	<?php $this -> load -> view('resourcedb/header'); ?>

<link rel="stylesheet" href="assets/css/jquery.autocomplete.css"  />
<script type="text/javascript" src="assets/jquery/jquery-1.4.2.min.js" ></script>
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
	# Get subjects, origins, clinical procedures and resource types for <select>
	# elements. 
	foreach($subjects_query -> result_array() as $row)
	{
		$id = $row['id']; $title = $row['title'];
		$subjects_ary[$id] = $title;
	}
	# Get origins of resource likewise
	foreach($origins_query -> result_array() as $row)
	{
		$id = $row['id']; $title = $row['title'];
		$origins_ary[$id] = $title;
	}	

	# Get resource types likewise
	foreach($resource_types_query -> result_array() as $row)
	{
		$id = $row['id']; $title = $row['title'];
		$resource_types_ary[$id] = $title;
	}	
	?>
	<h1><?php echo $heading;?></h1>
    <div id="message" class="notify"><?php echo $message; ?></div>
    <div id="error" class="error"><?php echo $error; ?></div>

	<!-- FORM -->
    <form name="form1" method="post" action="">
      <p>
        <label for="title">Title</label>
        <br />
        <input name="title" type="text" id="title" value="<?php echo set_value('title'); ?>" size="50">
      {Add title check!}</p>
      <p>
        <label for="url">URL<br />
        </label>
        <input name="url" type="text" id="url" value="<?php echo set_value('url'); ?>" size="50">
      </p>
      <p>
        <label for="description">Description<br />
        </label>
        <textarea name="description" id="description" cols="45" rows="5"><?php echo set_value('description'); ?></textarea>
      </p>
      <p>
        <label for="tags">Tags</label>
        <br />
		<input name="tags" type="text" id="tags" value="<?php echo set_value('tags'); ?>" size="30">
      </p>
      <p>Type<br />
      <?php
	  	# Use form helper functions to create <select> elements. The third parameter is
		# the value of the selected <option>
	  	echo form_dropdown('type', $resource_types_ary, 1); 
	  ?>
      </p>
      <p>
        <label for="origin">Origin</label> <br />
        <?php 
		# Third param is selected item, which is ID 1 representing 'external source'
		echo form_dropdown('origin', $origins_ary, 1); 
		?>
        
      </p>
      <p>
        <label for="subject_area">Subject area(s)</label><br />
        <?php 
		# Display subjects as checkboxes inside a scrollable <div>. Each checkbox has the same
		# name subjects[] which returns an associative array on POST
		?>
      <div id="subjects">
		<?php
		foreach ($subjects_ary as $key => $val)
		{
			echo form_checkbox("subjects[]", $key, FALSE) . "&nbsp;&nbsp;" . $val . "<br />\n";	
		}
		?>
      </div>
      </p>

<p>
  <label for="creator">Creator<br />
  </label>
  <input name="creator" type="text" id="creator" size="30" value="<?php echo set_value('creator'); ?>">
</p>
<p>
  <label for="rights">Rights<br />
  </label>
  <textarea name="rights" id="rights" cols="45" rows="3"><?php echo set_value('rights'); ?></textarea>
</p>

      <p>
        <label for="restricted">Restricted</label>
        <br />
<select name="restricted" id="restricted">
  <option value="1">Yes</option>
  <option value="0" selected="selected">No</option>
</select>
      </p>
      <p>
        <label for="visible">Visible<br />
        </label>
        <select name="visible" id="visible">
          <option value="1">Yes</option>
          <option value="0">No</option>
        </select>
      </p>
      <p>Notes<br />
        <textarea id="notes" name="notes" cols="45" rows="3"><?php echo set_value('notes'); ?></textarea>
      </p>
        <input type="submit" name="submit" id="submit" value="Submit">
      <p>&nbsp;</p>
    </form>
    <p>&nbsp;</p>
<?php $this -> load -> view('resourcedb/footer'); ?>
