<?php
/**
/* User administration submenu
* Submenu generated dynamically from a defined array of navigation items. A foreach loop 
* goes through the array and prints list items, optionally marking one as 'active'.

*/

# Define nav items in array of arrays. The array key isn't used 'publicly' so can be owt.
$nav_items = array (
	"b" => array (
				"text" => "Balkan", 
				"title" => " Languages of the Balkans area of Europe (Albanian, Greek, etc)", 
				"accesskey" => "b", 
				"url" => "languages/balkan" ), 
	"c" => array (
				"text" => "Celtic", 
				"title" => " Languages with direct Celtic origins (Irish, Welsh etc)", 
				"accesskey" => "c", 
				"url" => "languages/celtic"), 
	"e" => array (
				"text" => "English", 
				"title" => "Mostly aimed at TEFL/TESL resources.", 
				"accesskey" => "e", 
				"url" => "languages/english" ), 

	"d" => array (
				"text" => "Dutch", 
				"title" => "Language resources for Dutch", 
				"accesskey" => "d", 
				"url" => "languages/dutch"), 
	"f" => array (
				"text" => "French", 
				"title" => "Language resources for French", 
				"accesskey" => "f", 
				"url" => "languages/french"), 
	"g" => array (
				"text" => "German", 
				"title" => "Language resources for German", 
				"accesskey" => "s", 
				"url" => "languages/german"), 		
	"ib" => array (
				"text" => "Iberian", 
				"title" => "Languages originating from the Iberian peninsula (Catalan, Spanish etc)", 
				"accesskey" => "i", 
				"url" => "languages/iberian"), 			
	"in" => array (
				"text" => "Indian", 
				"title" => "Languages of the Indian subcontinent", 
				"accesskey" => "n", 
				"url" => "languages/indian"), 	
	"it" => array (
				"text" => "Italian", 
				"title" => "Languages resources for Italian", 
				"accesskey" => "t", 
				"url" => "languages/italian"), 	
	"m" => array (
				"text" => "Middle East", 
				"title" => "Languages of the Middle East (as seen from Western eyes) (Arabic, Hebrew etc)", 
				"accesskey" => "m", 
				"url" => "languages/mideast"), 	
	"o" => array (
				"text" => "Oriental", 
				"title" => "Languages of the Far East (as seen from Western eyes) (Mandarin, Vietnamese etc)", 
				"accesskey" => "o", 
				"url" => "languages/oriental"), 	
	"s" => array (
				"text" => "Scandinavian", 
				"title" => "Languages of the Scandinavian nations (Norwegian, Swedish etc)", 
				"accesskey" => "s", 
				"url" => "languages/scandinavian"), 					
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