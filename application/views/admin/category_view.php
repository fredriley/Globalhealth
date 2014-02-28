<?php $this -> load -> view('admin/admin_submenu_view', $active_submenu); ?>
<!-- CONTENT --> 
<p>Use this interface to add, edit or delete subjects (categories) in the repository. Before deleting, bear in mind that deleting a subject may 'orphan' resources categorised under it. </p>
<p><a href="subjects/insert">Add new subject/category</a></p>
<h2>Second level categories/subjects</h2>

<table class="table table-striped">
	<tr>
		<th>ID</th>
		<th>Title</th>
		<th>Parent</th>
		<th>Categorised resources</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>
<?php
foreach ($subjects_query->result() as $data)
{
	# Get the second-level category's parent
	$parent_id = $data -> key_area;
	if (!(is_null($parent_id)))
	{
		$parent_query = $this -> ResourceDB_model -> get_key_area_record($parent_id);
		$parent_row = $parent_query -> row();
		//print_r($row);
		$parent_title = $parent_row -> title;
	}
	else
	{
		$parent_title = "";
	}

	# Get number of resources categorised under subject
	$subject_resources = $this -> ResourceDB_model -> get_subject_resources($data -> id);
	$resource_count = $subject_resources -> num_rows;
	$edit_link = "subjects/edit/" . $data -> id;
	$edit_icon = "<img src=\"img/edit.png\" alt=\"Edit this subject\" title=\"Edit this subject\" >";
	# The user is prompted, with a Bootstrap modal dialogue, to confirm deletion.
	# This uses the jConfirm library, loaded by the controller in views/confirm_script_view
	# at the end of the page, after the closing html tag
	# http://myclabs.github.com/jquery.confirm/
	$delete_icon = "<img src=\"img/bin.png\" alt=\"Delete this subject\" title=\"Delete this subject\" >";
	$delete_link = "subjects/delete/" . $data -> id;
	$delete_confirm = "<a href=\"" . $delete_link . "\" class=\"confirm\" >". $delete_icon . "</a>";
	
	echo "<tr>\n";
	echo "\t<td>" . $data -> id . "</td>\n";
	echo "\t<td>" . $data -> title . "</td>\n";
	echo "\t<td>" . $parent_title . "</td>\n";
	echo "\t<td>" . $resource_count . "</td>\n";
	echo "\t<td>" . anchor($edit_link, $edit_icon) . "</td>\n";	
	echo "\t<td>" . $delete_confirm . "</td>\n";	

	echo "</tr>\n";

}

?>


</table>




<!-- END CONTENT -->