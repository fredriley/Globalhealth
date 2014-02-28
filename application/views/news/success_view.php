				<?php $this -> load -> view('news/news_submenu_view', $active_submenu); ?>
<!-- CONTENT -->

<?php
echo "<p>" . $message . "</p>";
?>

<table class="table">
	<tr>
		<th>Title</th>
		<th>Text</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>
	<?php
	# Display edited/added record
	 $row = $query->row(); 
	$view_link = "news/article/" . $row -> id;
	$edit_link = "news/edit/" . $row -> id;
	$edit_icon = "<img src=\"img/edit.png\" alt=\"Edit this article\" title=\"Edit this article\" >";
	# The user is prompted, with a Bootstrap modal dialogue, to confirm deletion.
	# This uses the jConfirm library, loaded by the controller in views/confirm_script_view
	# at the end of the page, after the closing html tag
	# http://myclabs.github.com/jquery.confirm/
	$delete_icon = "<img src=\"img/bin.png\" alt=\"Delete this article\" title=\"Delete this article\" >";
	$delete_link = "news/delete/" . $row -> id;
	$delete_confirm = "<a href=\"" . $delete_link . "\" class=\"confirm\" >". $delete_icon . "</a>";

	echo "<tr>\n";
	echo "\t<td>" . anchor($view_link, $row -> title) . "</td>\n";
	echo "\t<td>" . $row -> text . "</td>\n";
	echo "\t<td>" . anchor($edit_link, $edit_icon) . "</td>\n";	
	echo "\t<td>" . $delete_confirm . "</td>\n";	

	echo "</tr>\n";
?>
</table>
