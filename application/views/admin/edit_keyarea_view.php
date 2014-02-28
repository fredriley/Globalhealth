<?php $this -> load -> view('admin/admin_submenu_view', $active_submenu); ?>
<!-- CONTENT --> 

<?php
	# Get key area record
	$row = $query -> row();
	
?>
<p>Mandatory fields in <span class="label label-important">red</span></p>
    <div id="message" class="notify"><?php echo $message; ?></div>
    <div id="error" class="error"><?php echo $error; ?></div>
    <form name="form1" method="post" action="<?php echo current_url(); ?>">
		<p><label for="id" class="label">ID</label><br>
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
	    <input type="submit" name="submit" id="submit" value="Submit">
	  </p>
	
	</form>
	
<!-- END CONTENT --> 