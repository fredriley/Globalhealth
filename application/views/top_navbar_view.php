<?php
/**
* Top navbar generated dynamically from a defined array of navigation items. A foreach loop 
* goes through the array and prints list items, optionally marking one as 'active'.

*/

# Define nav items in array of arrays. The array key isn't used 'publicly' so can be owt
$nav_items = array (
	"h" => array (
				"text" => "Home", 
				"title" => "Home page and introduction", 
				"accesskey" => "h", 
				"url" => "home" ), 
	"a" => array (
				"text" => "About", 
				"title" => "About the Global Health repository", 
				"accesskey" => "a", 
				"url" => "about"), 
	"c" => array (
				"text" => "Contact", 
				"title" => "Contact the Global Health project", 
				"accesskey" => "c", 
				"url" => "form/contact" ), 
	"n" => array (
				"text" => "News", 
				"title" => "Latest news about the Global Health project", 
				"accesskey" => "n", 
				"url" => "news" ),				
	);
			
		
?>
<!-- TOP NAVBAR -->
<div class="navbar navbar-fixed-top navbar-inverse">
      <div class="navbar-inner">
        <div class="container-fluid">
		<a class="brand" href="home">
            Global Health
          </a>
			<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse" title="Show/hide site menu" >
				<!-- show a button with 3 horizontal lines -->
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>   		  
          <div class="nav-collapse">
			<ul class="nav">
				<?php
				/**  Go through the array of navigation items, and print a list item for each one. 
				If the item text matches the text of the current section, as passed from the 
				controller as $active_topnav, set the 'active' attribute of the <li>
				*/
				foreach ($nav_items as $key => $val)
				{ 
					# start the <li> with array values...
					$li = "<li";
					# ...if the current array element (nav item) matches that passed from 
					# the controller set the <li> class attribute to 'active'...
					if ($active_topnav == $val['text']) 
					{
						$li .= " class=\"active\" ";
					}
					$li .= ">";
					$li .= "<a href=\"" . $val['url'] . "\" accesskey=\"". $val['accesskey'] . "\" title=\"" . $val['title'] . "\">";

					# ...then finish off the list item and echo it
					$li .= $val['text'] . "</a></li>\n";
					echo "\t\t" . $li;
				}
				?>

			</ul>	
          </div>
		  
			<?php
			# If the user's not logged in, display login link 
			# else display user details and logout option
			if ($this->ion_auth->logged_in())
			{
				$user = $this->ion_auth->user()->row();
				$msg = "Logged in as <strong>" . $user -> first_name . " " . $user -> last_name . "</strong>&nbsp";
				$msg .= "[ " . anchor("auth/profile", "Profile",  'title="View your user profile"') . " ]";
				$msg .= "[ " . anchor("auth/logout", "Logout",  'title="Logout from the repository"') . " ]";?>
				<div class="pull-right text-success"><?php echo $msg; ?></div>
				<?php 
			}
			else
			{
			?>
			<a href="auth/login" class="btn pull-right" >User login</a>
			<?php } ?>
	
	          <form class="navbar-form" action="search" method="post">
			<input type="hidden" name="search" value="1">
            <input name="navbar_search" id="navbar_search" placeholder="Search resource titles" class="span2 search_title" type="text" >
            <input type="submit" class="btn" value="search">
          </form>
		  

        </div>
      </div>
    </div>
<!-- END TOP NAVBAR -->


