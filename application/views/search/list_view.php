    

<!-- CONTENT --> 
    <div id="results">
    
		<?php
		# Get number of records returned, display to user
		echo "<p><em>Records found: " . $query -> num_rows() . "</em></p>";
		
		
			# List all search/browse results with:
			# 	- resource title (link to resource URL)
			#	- resource description 
			# 	- more/less toggle to view further info
			#		- author
			#		- resource type
			#		- subject(s) as links
			# 		- tags as links
			# 		- link to full record
			
			foreach ($query -> result() as $row)
			{
				# Print resource title as link to resource
				$url = $row -> url; 
				$text = "<p>" . $row -> title . "</p>";
				$attribs = "";
				echo anchor ($url, $text, $attribs) . "\n";
				
				# Print description
				$desc = $row -> description;
				echo "<p>$desc</p>\n";
				
				# More/less content:
				 
				# Get the resource type (FK in RESOURCE)
				$type_id = $row -> type;
				$qry = $this -> ResourceDB_model -> get_res_type($type_id);
				$type = $qry -> row() -> title;
								
				# Get subject(s) resource attached to (join with junction table)
				$resource_id = $row -> id;
				$qry = $this -> ResourceDB_model -> get_resource_subjects($resource_id);
				$subject_links = ""; 
				foreach ($qry -> result() as $subject)
				{
					$url = 'browse/list_titles/subject/' . $subject -> id;
					$text = $subject -> title;
					$subject_links .= anchor($url, $text) . "&nbsp; &nbsp;";;
				}
				
				# Get tag(s) resource tagged with
				$qry = $this -> ResourceDB_model -> get_resource_tags($resource_id);
				$tag_links = ""; 
				foreach ($qry -> result() as $tag)
				{
					$url = 'browse/list_titles/tag/' . $tag -> id;
					$text = $tag -> name;
					$tag_links .= anchor($url, $text) . "&nbsp; &nbsp;";
				}			
				
				# Print table of extended data - initially hidden
				?>
				<table class="toggle table" width="30%">
					<thead><tr><th colspan='2'>About this resource</th></tr></thead>
						<tbody>
						
						<tr>
							<th>Author</th>
							<td><?php echo $row -> author; ?></td>
						</tr>
						 <tr>
							<th>Type</th>
							<td><?php echo $type; ?></td>
						</tr>
						 <tr>
							<th>Subject</th>
							<td><?php echo $subject_links; ?></td>
						</tr>
						 <tr>
							<th>Tags</th>
							<td><?php echo $tag_links; ?></td>
						</tr>            
						 <tr>
							<th>Rights</th>
							<td><?php echo $row -> rights; ?></td>
						</tr>
						</tbody>
				</table>
                <?php

				echo anchor ("detail/record/" . $row -> id, "Full record");
				echo "<hr />";
				
			}

		
		
		
		?>	
      </div>
    
<!-- END CONTENT -->
    
    <?php
function record_to_table($row)
{

	# Call function in model directly - is this good style? 
	$resource_id = $row -> type;
	$qry = $this -> ResourceDB_model -> get_res_type($resource_id);
	$r = $qry -> row();
	$type = $r -> title;
	
	$qry = $this -> ResourceDB_model -> get_resource_subjects($resource_id);
	foreach ($qry as $row => $val)
	{
		$url = '/list_titles/subject/' . $row -> id;
		$text = $row -> title();
		$subject_link .= anchor($url, $text);
	}

	?>
    <table class="toggle">
		<thead><tr><th colspan='2'>About this resource</th></tr></thead>
			<tbody>
            
            <tr>
            	<th>Creator</th>
                <td><?php echo $row -> creator; ?></td>
            </tr>
             <tr>
            	<th>Type</th>
                <td><?php echo $type; ?></td>
            </tr>
             <tr>
            	<th>Subject</th>
                <td><?php echo $subject_link; ?></td>
            </tr>
             <tr>
            	<th>Tags</th>
                <td></td>
            </tr>            
             <tr>
            	<th>Rights</th>
                <td></td>
            </tr>
            </tbody>
    </table>


	<?php
	
}
	
	?>
