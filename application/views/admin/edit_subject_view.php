<?php $this -> load -> view('admin/admin_submenu_view', $active_submenu); ?>
<!-- CONTENT --> 

<?php
	# Get subject record
	$row = $query -> row();
	
	# Key areas
	foreach($key_areas_query -> result_array() as $key_area)
	{
		$id = $key_area['id']; $title = $key_area['title'];
		$key_areas[$id] = $title;
	}	
?>
<p>Mandatory fields in <span class="label label-important">red</span></p>
    <form name="form1" method="post" action="<?php echo current_url(); ?>">
		<p><label for="id" class="label">Subject ID</label><br>
		<input name="subject_id" id="subject_id" type="text" readonly="readonly" class="input-small" value="<?php echo $row -> id; ?>" ></p>
      <p>
        <label for="title" class="label label-important">Title</label>
        <br />
        <input name="title" type="text" id="title" class="input-large" value="<?php echo $row -> title; ?>" >
      </p>
      <p>
        <label for="description" class="label ">Description</label>
        <br />
        <textarea name="description" id="description" cols="45" rows="5" class="input-xxlarge" ><?= $row -> description; ?></textarea>
      </p>
	   <p>
        <label for="key_area" class="label label-important">Key Area</label><br />
      <?php
	  	# Use form helper functions to create <select> elements. The third parameter is
		# the value of the selected <option>
	  	echo form_dropdown('key_area', $key_areas, $row -> key_area, "class=\"span4\""); 
	  ?>
      </p>
	  <p>
	         <input type="submit" name="submit" id="submit" value="Submit">
	  </p>
	
	</form>