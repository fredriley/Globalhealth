<?php $this -> load -> view('admin/admin_submenu_view', $active_submenu); ?>
<?php
	# Key areas
	foreach($key_areas_query -> result_array() as $key_area)
	{
		$id = $key_area['id']; $title = $key_area['title'];
		$key_areas[$id] = $title;
	}
?>
	
<!-- CONTENT -->
    <div id="message" class="notify"><?php echo $message; ?></div>
    <div id="error" class="error"><?php echo $error; ?></div>
	<!-- FORM -->
    <form name="frm_subject" id="frm_subject" method="post" action="subjects/insert" >
      <p>
        <label for="title" class="label label-important">Title</label><br />
        <input name="title" type="text" id="title" class="input-xxlarge" value="<?php echo set_value('title'); ?>" placeholder="Title of the subject" required>
     </p>
	 <p>
		<label for="description" class="label">Description</label><br />
		<textarea rows="5" class="input-xxlarge" name="description" id="description"><?= set_value('description'); ?></textarea>
	</p>
	<p>
        <label for="key_area" class="label label-important">Key Area</label><br />
      <?php
	  	# Use form helper functions to create <select> elements. The third parameter is
		# the value of the selected <option>
	  	echo form_dropdown('key_area', $key_areas); 
	  ?>
    </p>
	 <p>
		<input type="submit" value="Submit" />
	 </p>
	 
	 </form>

<!-- END CONTENT --> 