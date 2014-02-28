

				<?php $this -> load -> view('resource/contribute_submenu_view', $active_submenu); ?>
<!-- CONTENT --> 
<p>Mandatory fields in <span class="label label-important">red</span>. Please fill in as many other fields as you can.</p>

    <?php
	# Get subjects, origins, clinical procedures and resource types for <select>
	# elements. 
	/* foreach($subjects_query -> result_array() as $row)
	{
		$id = $row['id']; $title = $row['title'];
		$subjects_ary[$id] = $title;
	}
	*/


	# Get resource types likewise
	foreach($resource_types_query -> result_array() as $row)
	{
		$id = $row['id']; $title = $row['title'];
		$resource_types_ary[$id] = $title;
	}	
	?>
    <div id="message" class="notify"><?php echo $message; ?></div>	
    <div id="error" class="error"><?php echo $error; ?></div>

	<!-- FORM -->
    <form name="frm_resource" id="frm_resource" method="post" action="<?= current_url(); ?>" >
      <p>
        <label for="title" class="label label-important" data-toggle="tooltip" title="Enter a unique title for the resource. Use the Check Title button to see if the title already exists in the repository">Title</label>
        <br />
        <input name="title" type="text" id="title" class="input-xxlarge" value="<?php echo set_value('title'); ?>" placeholder="Title of the resource" required>
		<input type="button" name="check_title" id="check_title" value="Check title" class="btn" ><br>
		<span id="display_text" class="label label-info" ></span> 
     </p>
      <p>
        <label for="url" class="label label-important" >URL</label><br />
        
        <input name="url" type="text" id="url" class="input-xxlarge" value="<?php echo set_value('url'); ?>" placeholder="URL (web address) of the resource" required>
      </p>
      <p>
        <label for="description" class="label label-important" data-toggle="tooltip" title="Type a brief description of the resource. You can use rich text for formatting.">Description</label><br />
        
        <textarea name="description" id="description" class="input-xxlarge" rows="5" placeholder="Brief description of the resource"><?php echo set_value('description'); ?></textarea>
      </p>
     <p>
        <label for="subject_area" class="label label-important" data-toggle="tooltip" title="Select one or more categories for the resource">Categories</label><br />
		<div class="row-fluid">
		<div class="span8">
		<table class="table table-bordered"  >
			<tr>
				<th>Key area</th>
				<th>Categories</th>
			</tr>
			<tbody>
			
		<?php
		foreach ($keyarea_query->result() as $area)
		{
			$key_area_id = $area -> id;
			$key_area_title = "<strong>" . $area -> title . "</strong>"; ?>
			<tr>
				<td style="width: 40%"><?= $key_area_title; ?></td>
				<td style="width: 60%">
				<?php

				# Get child categories
				$child_query = $this -> ResourceDB_model -> get_key_area_children($key_area_id);
				foreach ($child_query -> result() as $child)
				{
					echo form_checkbox("subjects[]", $child ->id, FALSE) . "&nbsp;&nbsp;" . $child -> title . "<br />\n";	
				} ?>
				</td>
			</tr> <?php
		} ?>
			</tbody>
		</table>
		</div>
		</div>
      </p>
      <p>
        <label for="tags" class="label" data-toggle="tooltip" title="Type a keyword or phrase followed by a comma to enter the tag. To remove a tag, just click x on the right of the tag box.">Tags</label>
        <br />
		<input name="tags" type="text" id="tags" class="input-xxlarge" value="<?php echo set_value('tags'); ?>" >
      </p>
      <p><label for="type" class="label" data-toggle="tooltip" title="Choose one resource type">Type</label><br />
      <?php
	  	# Use form helper functions to create <select> elements. The third parameter is
		# the value of the selected <option>
	  	echo form_dropdown('type', $resource_types_ary, 1); 
	  ?>
      </p>
 

	<p>
	  <label for="author" class="label" data-toggle="tooltip" title="Enter the author name(s), if known.">Author</label><br />
	  
	  <input name="author" type="text" id="author" class="input-xlarge" value="<?php echo set_value('author'); ?>">
	</p>
	<p>
	  <label for="rights" class="label" data-toggle="tooltip" title="Details of usage rights (eg Creative Commons) if known">Rights</label><br />
	  
	  <textarea name="rights" id="rights" class="input-xlarge" rows="3"><?php echo set_value('rights'); ?></textarea>
	</p>

	  <p>
        <label for="restricted" class="label">Restricted</label><br />
        Yes <input type="radio" name="restricted" value="1"  />&nbsp; &nbsp;No <input type="radio" name="restricted" value="0" checked="checked"  />      </p>
      <p>
        <label for="visible" class="label">Visible</label><br>
        Yes <input type="radio" name="visible" value="1" checked="checked"  />&nbsp; &nbsp;No <input type="radio" name="visible" value="0"  />      
	  </p>


      <p>
	    <label for="notes" class="label" data-toggle="tooltip" title="Private notes about the resource. These will not be visible to repository users, only to contributors">Notes</label><br />
        <textarea id="notes" name="notes" class="input-xlarge" rows="3"><?php echo set_value('notes'); ?></textarea>
      </p>
        <input type="submit" name="submit" id="submit" value="Submit" class="btn">
      <p>&nbsp;</p>
    </form>
    <p>&nbsp;</p>
<!-- END CONTENT -->
