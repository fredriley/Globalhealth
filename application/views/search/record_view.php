<!-- CONTENT -->
    <?php
	# If user's in a contributory group, add Edit Record link
	if ($this->ion_auth->is_admin()  || $this->ion_auth->in_group('contributor')) 
	{ 
		$edit_icon = "<img src=\"img/edit.png\" alt=\"Edit this resource\" title=\"Edit this resource\" >" ;
		$edit_link = "resource/edit/" . $resource_id;
		echo anchor($edit_link, $edit_icon );
	}
	# If user's an admin, add Delete Record link
	if ($this -> ion_auth -> is_admin())
	{
		$delete_icon = "<img src=\"img/bin.png\" alt=\"Delete this resource\" title=\"Delete this resource\" >";
		$delete_link = "resource/delete/" . $resource_id;
		$delete_confirm = "<a href=\"" . $delete_link . "\" class=\"confirm pull-right\" >". $delete_icon . "</a>";
		echo $delete_confirm; 
	}

	?>
<div class="message"></div>
<div id="results">
    <table class="table table-striped table-bordered" >
    	<thead>
        	<tr>
            	<th colspan='2'>&nbsp;</th>
            </tr>
        </thead>

    <?php
	
	# If an error's been passed, display it and quit processing
	if (!empty($error))
	{
		echo $error;
		$this -> load -> view('resourcedb/footer'); 
		exit();
	}
	
	# Full record details passed from controller in $query as an assoc array of
	# user-friendly field names and formatted values (eg mySQL dates -> human dates)
	# Go through array and display in a table

	# Tried to use CI table class to generate a table from the array but it 
	# was too fiddly to work with a 'custom' assoc array, so back to basics ;)
	
	?>
		<?php
        foreach ($resource_detail_ary as $key => $val)
        {?> 
            <tr> 
                <th><?php echo $key; ?></th>	
                <td><?php echo $val; ?></td>
            </tr>
        <?php	
        }
        
        ?>
    
    <?php
	
	
	# Display tags and subjects as links to tag and subject browses
	# -------------------------------------------------------------
	
	# Tags
	$tags_ary = array(); 
	foreach ($resource_tags_query -> result() as $row)
	{
		$tag_id = $row -> id; $tagname = $row -> name;
		$tags_ary[] = anchor("browse/list_titles/tag/$tag_id", $tagname, 'title="Browse titles tagged with this keyword/phrase"');
	}
	echo "<tr>\n";
	echo "<th>Tags</th>\n"; 
	echo "<td>" . implode(", ", $tags_ary) . "</td>\n";
	echo "</tr>\n";
	
	# Subjects
	$subjects_ary = array(); 
	foreach ($resource_subjects_query -> result() as $row)
	{
		$subject_id = $row -> id; $subject_name = $row -> title;
		$subjects_ary[] = anchor("browse/list_titles/subject/$subject_id", $subject_name, 'title="Browse titles in this subject"');
	}
	echo "<tr>\n";
	echo "<th>Subjects</th>\n"; 
	echo "<td>" . implode(", ", $subjects_ary) . "</td>\n";
	echo "</tr>\n";
	
	
	?>
    </table>
    </div>

<!-- END CONTENT -->
