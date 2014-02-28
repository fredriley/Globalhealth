<?php $this -> load -> view('admin/admin_submenu_view', $active_submenu); ?>
<!-- CONTENT --> 
<div id="infoMessage"><?= $this->session->flashdata('message');?></div>
<?php
echo $page_info;
# Print pagination links and search box
echo "Pages: $links";
?>	


<table class="table table-striped">
	<tr>
		<th>ID</th>
		<th>Title</th>
		<th>Created</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>
<?php
# Set date format for use in mdate() calls below. Example format result:
# 02-04-2013 21:48
# See PHP date() function docs for format string options:
# http://www.php.net/manual/en/function.date.php
# mdate() is part of the CI date helper, loaded in the calling controller
$datestring = "%d-%m-%Y %H:%i";

foreach ($results as $data)
{
	$view_link = "detail/record/" . $data -> id;
	$edit_link = "resource/edit/" . $data -> id;
	$edit_icon = "<img src=\"img/edit.png\" alt=\"Edit this resource\" title=\"Edit this resource\" >";
	# The user is prompted, with a Bootstrap modal dialogue, to confirm deletion.
	# This uses the jConfirm library, loaded by the controller in views/confirm_script_view
	# at the end of the page, after the closing html tag
	# http://myclabs.github.com/jquery.confirm/
	$delete_icon = "<img src=\"img/bin.png\" alt=\"Delete this resource\" title=\"Delete this resource\" >";
	$delete_link = "resource/delete/" . $data -> id;
	$delete_confirm = "<a href=\"" . $delete_link . "\" class=\"confirm\" >". $delete_icon . "</a>";
	
	echo "<tr>\n";
	echo "\t<td>" . $data -> id . "</td>\n";
	echo "\t<td>" . anchor($view_link, $data -> title) . "</td>\n";
	echo "\t<td>" . mdate($datestring, mysql_to_unix($data -> metadata_created, TRUE, 'eu')) . "</td>\n";
	echo "\t<td>" . anchor($edit_link, $edit_icon) . "</td>\n";	
	echo "\t<td>" . $delete_confirm . "</td>\n";	

	echo "</tr>\n";

}

?>


</table>

<form class="" action="<?php echo current_url(); ?>" method="post"  >
	
	<input type="text" width="15" name="search_title" id="search_title" class="search_title input-large" placeholder="Search resource titles" />
	<input type="submit" value="Title search"  /> 
</form>
<?php
if (isset($query))
{
	echo "  <h3>Search results</h3>";
	if ($query -> num_rows() > 0)
	{
		echo $query -> num_rows() . " records found:";
		foreach ($query -> result() as $row)
		{
			$url = "detail/record/" . $row -> id;
			$title = $row -> title;	
			$attrs = "";
			echo "<p>" . anchor ($url, $title, $attrs) . "</p>\n";
			
		}
	}
	else
	{
		echo "<p>No results for your search term - bummer. </p>";
	}
}
?>

<?php
# Reprint page links and info
echo $page_info;
echo "Pages: $links";
?>	


<!-- END CONTENT -->