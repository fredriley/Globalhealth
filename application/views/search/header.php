<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<base href="<?php echo base_url(); ?>"  />
<head>
<link rel="stylesheet"  type="text/css" href="css/resourcedb.css"  />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<script type="text/javascript" src="jquery/jquery-1.4.2.min.js" ></script>
<script type="text/javascript" > 

$(document).ready(function()
{
	
	// Dynamic menu highlighting
	// Set 'current' class on menu item if the link matches the 
	// current page name
	// Simple code from http://www.cybervaldez.com/
	// Might need to amend for CI purposes - see DOM reference at
	// https://developer.mozilla.org/en/DOM/document.location
	var loc = document.location.toString().split("/");
    loc = loc[loc.length-1];
    $("#menu li a[href=\""+loc+"\"]").addClass("current");
	
	
});
	
</script>
</head>

<?php
# Create message for login area in top right, in the menu <div>
if ($this -> ion_auth -> logged_in())
{
	$user = $this->ion_auth->user()->row();
	$fullname = $user -> first_name . " " . $user -> last_name;
	$login_status = "Logged in as <strong>$fullname</strong> [ " . anchor('auth/logout', 'logout', '') 
		. ' ] [ ' . anchor('auth/profile', 'profile', '') . ' ]';
}
else
{
	$login_status = "Not logged in [ " . anchor('auth/login', 'login', '') . ' ] [ ' 
					. anchor('register/', 'register') . ' ]';
}

# If running on localhost, show this in the header to avoid confusion with live appl
# Assign env var to PHP var as putting $_SERVER into strrpos() generates error.
$server_name = $_SERVER['SERVER_NAME'];

# Display relevant server the application's running on
# If the 
if ($_SERVER['HTTP_HOST'] == 'localhost')
{
	$status = " (localhost) ";
}

elseif ($_SERVER['HTTP_HOST'] == 'www.nottingham.ac.uk')
{
	$status = " (granby) ";
}

elseif ($_SERVER['HTTP_HOST'] == 'www.fredriley.org.uk')
{
	$status = " (FR site) ";
}
?>

<body>
<div id="banner">
  <div style="float: right;">
  <form action="search" method="post" >
    <input type="text" width="15" name="search_term" id="search_term" />
    <input type="submit" value="Quick search"  />
  </form>  
    </div>
  <p>Global Health Repository <?php echo $status; ?></p>
</div>
<div id="menu">
    <ul>
      <li><a href="home">Home</a></li>
      <li><a href="browse">Browse</a></li>
      <li><a href="search">Search</a></li>
      <li><a href="suggest">Suggest</a></li>
      <li><a href="about">About</a></li>
      <?php
	  # If user's logged in, and a contributor or an admin, add record edit options
	  if (  $this -> ion_auth -> logged_in() && 
	  		( $this->ion_auth->in_group('contributor') || $this -> ion_auth->in_group('admin') ))
	  { ?>
      	<li><a href="insert">Insert</a></li>
        <li><a href="edit">Edit</a></li>
        <?php
	  }
	  # if user's an admin, show admin options
	  if ($this -> ion_auth-> logged_in() && $this -> ion_auth->in_group('admin'))
	  { ?>
		<li><a href="admin" title="Administration console">Admin</a></li>
		<?php	  
	  }

	  ?>
    </ul>
    <div style="float:right"><span class="logintext"><?php echo $login_status; ?></span></div>
</div>
    <p>&nbsp;</p>
