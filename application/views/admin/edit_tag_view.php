<?php $this -> load -> view('admin/admin_submenu_view', $active_submenu); ?>
<!-- CONTENT --> 

<?php
	# Get tag record
	$row = $query -> row();
?>

    <form name="form1" method="post" action="<?php echo current_url(); ?>">
		<p><label for="id" class="label">Tag ID</label><br>
		<input name="tag_id" id="tag_id" type="text" readonly="readonly" class="input-small" value="<?php echo $row -> id; ?>" ></p>
      <p>
        <label for="title" class="label label-important">Title</label>
        <br />
        <input name="tagname" type="text" id="tagname" class="input-large" value="<?php echo $row -> name; ?>" >
      </p>
	  <p>
	         <input type="submit" name="submit" id="submit" value="Submit">
	  </p>
	
	</form>