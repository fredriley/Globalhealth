<?php

/**
* Left navigation bar view
* Display a number of navigation lists in the left navbar, optionally with an item marked 
* as 'active' (passed as $active_leftnav from controller). Which lists are displayed depend 
* on login and user status (eg admin panel only appears for logged-in admins)
* @author Fred Riley <fred.riley@gmail.com>
* @package Global Health
* @version 1.0
*/

/**
* Left navbar generated dynamically from a defined array of navigation items. A foreach loop 
* goes through the array and prints list items, optionally marking one as 'active'.

*/

# Define nav items in array of arrays. The array key isn't used 'publicly' so can be owt
$search_nav_items = array (
	"lr" => array (
				"text" => "Latest resources", 
				"title" => "Latest resources added to this repository", 
				"accesskey" => "l", 
				"url" => "search/latest" ), 
	"g" => array (
				"text" => "Browse", 
				"title" => "Browse the repository by category, resource type and tags", 
				"accesskey" => "b", 
				"url" => "browse" ), 
	"l" => array (
				"text" => "Search", 
				"title" => "Search for resources using text queries", 
				"accesskey" => "s", 
				"url" => "search"), 
	"m" => array (
				"text" => "Tags", 
				"title" => "Use a tag cloud to browse and drill down into the repository", 
				"accesskey" => "t", 
				"url" => "tags" ), 
			
	);

# User nav items - only to appear when user not logged in
$user_nav_items = array (
	"login" => array (
				"text" => "Login", 
				"title" => "Registered user login", 
				"accesskey" => "l", 
				"url" => "auth/login" ), 
	"req" => array (
				"text" => "Request registration", 
				"title" => "Request to be registered as a user/contributor to the repository", 
				"accesskey" => "r", 
				"url" => "form/request" )
);


# Contributor nav items - only to appear to contributors after login
$contrib_nav_items = array (
	"r" => array (
				"text" => "Add resource", 
				"title" => "Add a resource to the repository", 
				"accesskey" => "a", 
				"url" => "resource/insert" ), 
	"l" => array (
				"text" => "Edit resource", 
				"title" => "Edit an existing repository resource", 
				"accesskey" => "e", 
				"url" => "resource/choose"), 
	"s" => array (
				"text" => "Suggest", 
				"title" => "Suggest a resource for inclusion in the repository", 
				"accesskey" => "s", 
				"url" => "resource/suggest"), 

);
			
# Admin section nav items - only to be displayed to administrators
$admin_nav_items = array (
	"r" => array (
				"text" => "User admin", 
				"title" => "Add/delete/edit users and groups", 
				"accesskey" => "u", 
				"url" => "auth" ), 
	"l" => array (
				"text" => "Resource admin", 
				"title" => "Add/edit/delete resources, edit metadata", 
				"accesskey" => "r", 
				"url" => "admin"), 
	"n" => array (
				"text" => "News admin", 
				"title" => "Add/edit/manage site news", 
				"accesskey" => "r", 
				"url" => "news/home")
);		
?>

<!-- MAIN CONTAINER -->
<div class="container-fluid" id="main_container">
	<div class="row-fluid">
		<!-- LEFT NAVBAR -->
		<div class="span2"> 
		  <nav id="leftnav" class="well sidebar-nav"> 
			<ul class="nav nav-list">
			  <li class="nav-header"> Search <br>
			  </li>
			  <li> <br>
			  </li>
			  <?php
				/**  Create menu for search items. Function at end of script.	*/			  
				display_navbar($search_nav_items, $active_leftnav)
			  ?>
			  <li class="divider-vertical"> <br>
			  </li>
			</ul>
		  </nav>
		  
		  <?php
			/**  Create menu for non-logged-in users. Hide on login	*/			  
			if (!$this -> ion_auth -> logged_in())
			{
		  ?>
			<nav class="well sidebar-nav"> 
				<ul class="nav nav-list" id="elearningnav">
				  <li class="nav-header"> User <br></li>
				  <li> <br>  </li>
			  <?php
		  
				display_navbar($user_nav_items, $active_leftnav)
			  ?>
				</ul>
			</nav>
			<?php } ?>
		  
		  <?php
			/**  Create menu for ADMINISTER. Only display for admin user logins.	*/			  
			if ($this -> ion_auth -> logged_in() && $this -> ion_auth -> is_admin())
			{
		  ?>
			<nav class="well sidebar-nav"> 
				<ul class="nav nav-list" id="elearningnav">
				  <li class="nav-header"> Administer <br></li>
				  <li> <br>  </li>
			  <?php
		  
				display_navbar($admin_nav_items, $active_leftnav)
			  ?>
				</ul>
			</nav>
			<?php } ?>
			
		  <?php
			/**  Create menu for CONTRIBUTE. Only display for contributor user logins.	*/			  
			if ($this -> ion_auth -> logged_in() && $this -> ion_auth -> in_group('contributor'))
			{
		  ?>			
			<nav class="well sidebar-nav"> 
				<ul class="nav nav-list" id="elearningnav">
				  <li class="nav-header"> Contribute <br></li>
				  <li> <br>  </li>
			  <?php
				display_navbar($contrib_nav_items, $active_leftnav)
			  ?>
				</ul>
			</nav>
			<?php } ?>
			

		</div>
		<!-- END LEFT NAVBAR -->
		
<?php
/* -------- FUNCTIONS ---------- */

/**
* Display a navigation bar
* Output a <ul> from an array of nav items, optionally marking one item as 'active'
* @param mixed $nav_items Associative array of navigation items
* @param string $active_item The text of the navigation item to mark as 'active'

*/
function display_navbar($nav_items, $active_item)
{
	foreach ($nav_items as $key => $val)
	{ 
		$li = "<li";
		if ($active_item == $val['text']) 
		{
			$li .= " class=\"active\" ";
		}
		$li .= ">";
		$li .= "<a href=\"" . $val['url'] . "\" accesskey=\"". $val['accesskey'] . "\" title=\"" . $val['title'] . "\">";
		$li .= $val['text'] . "</a></li>\n";
		echo "\t\t" . $li;
	}



}

?>
