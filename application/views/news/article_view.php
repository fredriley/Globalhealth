<?php 
# News submenu only available to admins
if ($this -> ion_auth -> logged_in() && $this -> ion_auth -> is_admin())
{
	$this -> load -> view('news/news_submenu_view', $active_submenu); 
}
?>

<!-- CONTENT -->

		<?php
		# Get query result
		$row = $query -> row();
		
		# Set date format for use in mdate() calls below. Example format result:
		# 02-04-2013 21:48
		# See PHP date() function docs for format string options:
		# http://www.php.net/manual/en/function.date.php
		# mdate() is part of the CI date helper, loaded in the calling controller
		$datestring = "%d-%m-%Y %H:%i";

		# For end-users and non-admins, just display the article. 
		echo "<h2>" . $row -> title . "</h2>";
		echo "<p>" . $row -> text . "</p>";
		echo "<p>Posted: " . mdate($datestring, mysql_to_unix($row -> posted, TRUE, 'eu')) . "</p>";
		echo "<p>Last edited: " . mdate($datestring, mysql_to_unix($row -> edited, TRUE, 'eu')) . "</p>";
		
		# For admins, display edit and delete icons
		if ($this -> ion_auth -> logged_in() && $this -> ion_auth -> is_admin())
		{
			$edit_link = "news/edit/" . $row -> id;
			$edit_icon = "<img src=\"img/edit.png\" alt=\"Edit this article\" title=\"Edit this article\" >";
			# The user is prompted, with a Bootstrap modal dialogue, to confirm deletion.
			# This uses the jConfirm library, loaded by the controller in views/confirm_script_view
			# at the end of the page, after the closing html tag
			# http://myclabs.github.com/jquery.confirm/
			$delete_icon = "<img src=\"img/bin.png\" alt=\"Delete this article\" title=\"Delete this article\" >";
			$delete_link = "news/delete/" . $row -> id;
			$delete_confirm = "<a href=\"" . $delete_link . "\" class=\"confirm\" >". $delete_icon . "</a>";
			echo "<p>" . anchor($edit_link, $edit_icon) . nbs(3) . $delete_confirm . "</p>";	
		}
		# For the rest, just display the news home icon
		else
		{ ?>
			<p><a href="news"><img src="img/news.png" border="0" alt="News home" title="News home"><br>
			News home</a></p>
		<?php } 
		
		?>

		

		
<!-- END CONTENT -->