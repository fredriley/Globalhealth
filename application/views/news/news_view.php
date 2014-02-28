<!-- CONTENT --> 
<p>News from the Global Health project. 
	<a href="news/rss"><img style="border: 0px solid ; width: 32px; height: 32px;" alt="Site RSS newsfeed" title="Site RSS newsfeed" src="img/rss_icon.png" class="social_icon"></a></p>
<table class="table table-striped">
	<tr>
		<th>Title</th>
		<th>Posted</th>
	</tr>
<?php
	# Set date format for use in mdate() calls below. Example format result:
	# 02-04-2013 21:48
	# See PHP date() function docs for format string options:
	# http://www.php.net/manual/en/function.date.php
	# mdate() is part of the CI date helper, loaded in the calling controller
	$datestring = "%d-%m-%Y %H:%i";
	foreach ($query -> result() as $row)
	{
		$view_link = "news/article/" . $row -> id;
		echo "<tr>\n";
		echo "\t<td>" . anchor($view_link, $row -> title) . "</td>\n";
		echo "\t<td>" . mdate($datestring, mysql_to_unix($row -> posted, TRUE, 'eu')) . "</td>\n";
		echo "</tr>\n";		
	}
	
?>


</table>

<!-- END CONTENT --> 