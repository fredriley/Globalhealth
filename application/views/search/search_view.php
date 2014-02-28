				<?php $this -> load -> view('search/search_submenu_view', $active_submenu); ?>

<!-- CONTENT --> 
<p>Use the search fields below to find resources by title, url or keyword.</p>
    <?php 
	# Links to possibly be used with pagination of results
	# Commented out for the now
	# echo $links; ?>
<form action="<?php echo current_url(); ?>" method="post"  >
	<label for="title" class="">Title</label>
		<input type="text" width="15" name="title" id="title" class="search_title input input-xxlarge" />
		<input type="submit" value="Search"  class="btn" /> 
</form>

<form action="<?php echo current_url();?>" method="post" >
	<label for="url">URL</label>
    <input type="text" class="input input-xxlarge" name="url" id="url"  />
    <input type="submit" value="Search" class="btn"  />
</form> 

<form action="<?php echo current_url();?>" method="post" >
	<label for="tag">Tag/keyword</label>
    <input type="text" class="input input-xxlarge" name="tag" id="tag"  />
    <input type="submit" value="Search" class="btn"  />
</form> 

    <div id="message" class="notify">
	<?php 
		if (!empty($message))
		{ echo $message;} 
	?>
	</div>
    <div id="error" class="error">
	<?php 
		if (!empty($error))
		{ echo $error; }
	?>
	</div> 
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



<!-- END CONTENT -->

