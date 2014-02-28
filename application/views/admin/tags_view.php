<?php $this -> load -> view('admin/admin_submenu_view', $active_submenu); ?>
<!-- CONTENT --> 
 <div id="infoMessage"><?php echo $this->session->flashdata('message');?></div>
<?php
if (isset($message))
{ echo "<p>" . $message . "</p>"; }
echo $page_info;
# Print pagination links and search box
echo "Pages: $links";
?>	


<table class="table table-striped">
	<tr>
		<th>ID</th>
		<th>Title</th>
		<th>Tagged resources</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>
<?php

foreach ($tags as $data)
{
	$edit_link = "tags/edit/" . $data -> id;
	$edit_icon = "<img src=\"img/edit.png\" alt=\"Edit this resource\" title=\"Edit this resource\" >";
	# The user is prompted, with a Bootstrap modal dialogue, to confirm deletion.
	# This uses the jConfirm library, loaded by the controller in views/confirm_script_view
	# at the end of the page, after the closing html tag
	# http://myclabs.github.com/jquery.confirm/
	$delete_icon = "<img src=\"img/bin.png\" alt=\"Delete this tag\" title=\"Delete this tag\" >";
	$delete_link = "tags/delete/" . $data -> id;
	$delete_confirm = "<a href=\"" . $delete_link . "\" class=\"confirm\" >". $delete_icon . "</a>";
	
	echo "<tr>\n";
	echo "\t<td>" . $data -> id . "</td>\n";
	echo "\t<td>" . $data -> name . "</td>\n";
	//echo "\t<td>" . $data -> count . "</td>\n";
	echo "\t<td>" . "" . "</td>\n";
	echo "\t<td>" . anchor($edit_link, $edit_icon) . "</td>\n";	
	echo "\t<td>" . $delete_confirm . "</td>\n";	

	echo "</tr>\n";

}

?>


</table>
<?php
# Print pagination links and search box
echo "Pages: $links";
?>


<!-- END CONTENT -->