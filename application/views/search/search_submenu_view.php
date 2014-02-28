<?php
/**
* Submenu generated dynamically from a defined array of navigation items. A foreach loop 
* goes through the array and prints list items, optionally marking one as 'active'.

*/

# Define nav items in array of arrays. The array key isn't used 'publicly' so can be owt.
# No access keys are defined for the submenu, unlike the main and side navs, 
# to avoid the risk of 'collision' and because they'd likely be unnecessary for a subsection
$nav_items = array (
	"l" => array (
				"text" => "Latest", 
				"title" => "Latest resources added to the repository", 
				"url" => "search/latest" ), 
	"b" => array (
				"text" => "Browse", 
				"title" => "Browse the repository by subjects, tags and resource types", 
				"url" => "browse"), 
	"s" => array (
				"text" => "Search", 
				"title" => "Search the repository ", 
				"url" => "search" ), 
	"t" => array (
				"text" => "Tags", 
				"title" => "Browse the repository by tag cloud (keywords)", 
				"url" => "tags" ), 
	);
?>
			
				<!-- SUBMENU --> 
			    <ul class="nav nav-tabs">
				<?php
				/**  Go through the array of navigation items, and print a list item for each one. 
				If the item text matches the text of the current section, as passed from the 
				controller as $active_submenu, set the 'active' attribute of the <li>
				*/
				foreach ($nav_items as $key => $val)
				{ 
					# start the <li> with array values...
					$li = "<li";
					# ...if the current array element (nav item) matches that passed from 
					# the controller set the <li> class attribute to 'active'...
					if ($active_submenu == $val['text']) 
					{
						$li .= " class=\"active\" ";
					}
					$li .= ">";
					$li .= "<a href=\"" . $val['url'] . "\" title=\"" . $val['title'] . "\">";

					# ...then finish off the list item and echo it
					$li .= $val['text'] . "</a></li>\n";
					# a couple of tab chars to aid readability in the HTML source
					echo "\t\t" . $li;
				}
				
				?>
				</ul>
			  
				  <!-- END SUBMENU -->
				  