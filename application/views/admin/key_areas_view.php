<?php $this -> load -> view('admin/admin_submenu_view', $active_submenu); ?>
<!-- CONTENT --> 
<p>The key areas - top-level categories - of the repository are listed below. You can only edit existing key areas, not delete or add. To add a key area, contact the repository administrator. To move a child category into a key area, edit the child category</p>

<table class="table table-striped">
	<tr>
		<th>ID</th>
		<th>Title</th>
		<th>Child categories</th>
		<th>Edit</th>
	</tr>

<?php	


foreach ($query->result() as $data)
{
	$children = "";	
	$key_area_id = $data -> id;
	# Get child categories
	$qry = $this -> ResourceDB_model -> get_key_area_children($key_area_id);
	foreach ($qry -> result() as $child)
	{
		//$children .= $child -> title . ", ";
		$children .= anchor("subjects/edit/" . $child -> id, $child -> title . ", ", "title='Edit subject'");
		
	
	}
	# Get number of resources categorised under subject
	//$subject_resources = $this -> ResourceDB_model -> get_subject_resources($data -> id);
	//$resource_count = $subject_resources -> num_rows;
	$resource_count = "loads";
	$edit_link = "keyareas/edit/" . $data -> id;
	$edit_icon = "<img src=\"img/edit.png\" alt=\"Edit this key area\" title=\"Edit this key area\" >";
	
	echo "<tr>\n";
	echo "\t<td>" . $data -> id . "</td>\n";
	echo "\t<td>" . $data -> title . "</td>\n";
	echo "\t<td>" . $children . "</td>\n";
	echo "\t<td>" . anchor($edit_link, $edit_icon) . "</td>\n";	
	echo "</tr>\n";
}
?>
	
</table>

<!-- END CONTENT --> 