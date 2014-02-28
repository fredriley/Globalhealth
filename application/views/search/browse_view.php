				<?php $this -> load -> view('search/search_submenu_view', $active_submenu); ?>
				
<!-- CONTENT --> 

<p>You can browse the repository by subject/category, resource type, tag or title.</p>
   
	<div class="row-fluid">
		<div class="span4" id="leftcol">
			<h2>Subjects</h2>
			<p>
			<?php
				foreach ($subjects_query -> result() as $row)
				{
					echo anchor('browse/list_titles/subject/' . $row ->id, $row->title ) . "<br />\n";
				}?>
			<p>
		</div>
		<div class="span4" id="midcol">
			<h2>Popular tags</h2>
			<p>
				<?php
				foreach ($tags_query -> result() as $row)
				{
					echo anchor('browse/list_titles/tag/' . $row ->id, $row->tagname ) . " (" . $row->count . ")" . "<br />\n";
				}?>
				
			</p>

		</div>
		<div class="span4" id="rightcol">
			<h2>Resource types</h2>
			<?php
			foreach ($types_query -> result() as $row)
			{
				echo anchor('browse/list_titles/type/' . $row ->id, $row->title ) . "<br />\n";
			}
			?>
		</div>
	</div>
</div><!-- end span10 -->	


<?php
function print_tag_cloud($tags_query, $min_count)
{
	// check that there are tags defined!
	if ($tags_query -> num_rows() > 0)
	{
		foreach ($tags_query -> result() as $row)
		{
			if($row->count >= $min_count)
			{
				$tags_array [$row->tagname] = $row->count;
			}
			$tags_id_array [$row->tagname] = $row ->id;
		}

		// change these font sizes if you will
		$max_size = 250; // max font size in %
		$min_size = 100; // min font size in %

		// get the largest and smallest array values
		$max_qty = max(array_values($tags_array));
		$min_qty = min(array_values($tags_array));

		// find the range of values
		$spread = $max_qty - $min_qty;
		if (0 == $spread) { // we don't want to divide by zero
			$spread = 1;
		}

		// determine the font-size increment
		// this is the increase per tag quantity (times used)
		$step = ($max_size - $min_size)/($spread);

		// loop through our tag array
		foreach ($tags_array as $key => $value) 
		{

			// calculate CSS font-size
			// find the $value in excess of $min_qty
			// multiply by the font-size increment ($size)
			// and add the $min_size set above
			$size = $min_size + (($value - $min_qty) * $step);
			$id = $tags_id_array[$key];
			// uncomment if you want sizes in whole %:
			// $size = ceil($size);

			$url = 'browse/list_titles/tag/' . $id; 
			$text = $key . "\n"; 
			$tag_style = "font-size: " . $size . "%; text-decoration: none;";
			$attrs = array ('title' => "Resources tagged with $key", 'style' => $tag_style);
			echo anchor($url, $text, $attrs);
			//echo anchor('resourcedb/tag/') . $id . '" style="font-size: ' . $size . '%; text-decoration: none;"';

		}
	} // end if tags > 0
	else
		{
			echo "No tags defined!";
		}

} // end function


?>
