<!DOCTYPE html>
<html lang="en">
<head>
<head>
	<base target="_blank">
	</head>
	<meta charset="utf-8">
	<title>Global Health repository: Codeigniter</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
    <h1>Global Health Repository: Development website</h1>
    <p>This development site for the Global Health Repository project holds documents, resources, and links to prototypes. </p>
	<h2><a href="home">Current version (beta)</a></h2>
		<p>Current version (<a href="http://localhost/globalhealth/home/">localhost, Fred's machine</a>) 
    <h2>Documents</h2>
		<p>User administration (<a href="docs/user_admin.rtf">RTF</a>) (<a href="docs/user_admin.odt">Libre Office</a>)</p>
		<p><a href="docs/sonarc-GlobalHealthrepository-140812-1552-6150.pdf">Project specification</a> (PDF)</p>
	  <h3>Resources</h3>
	      <p><a href="docs/GH repository database.xls">Resources spreadsheet</a> compiled by Rebecca Gibbs (Excel)</p>
	  <h3>Technical</h3>
		<ul>
		  <li>Technical notes (<a href="docs/technotes.rtf">RTF</a>)(<a href="docs/technotes.odt">Libre Office</a>)</li>
		  <li>To Do (<a href="docs/todo.rtf">RTF</a>)</li>
		  <li>File list (<a href="docs/filelist.rtf">RTF</a>) (<a href="docs/filelist.odt">Libre Office</a>)</li>
		  <li>Codeigniter user guide (<a href="http://localhost/globalhealth/user_guide/">localhost, Fred's machine</a>) (<a href="http://ellislab.com/codeigniter/user-guide/">online</a>)</li>
		  <li>Ion-Auth user guide (<a href="http://localhost/globalhealth/docs/ion-auth_userguide/">localhost, Fred's machine</a>) (<a href="http://benedmunds.com/ion_auth/">online</a>)</li>
		</ul>
	<h2>Databases</h2>
	<p><a href="http://www.fredriley.org.uk/phpMyAdmin/">phpMyAdmin on FR site</a> (fredriley/r****r)</p>
    <h2>Prototypes</h2>
     <p><a href="http://www.nottingham.ac.uk/~ntzrlo/resourcedb/home">Resource database on granby</a> (alpha)</p>
    <h3>Home page: layout</h3>
    <p>Links below are to possible new layouts for the home page, as designed on Jetstrap:<br>
    </p>
    <ul>
      <li><a href="http://jetstrap.com/share/7ddd9d4506/home-1">Home
          page 1</a></li>
      <li><strike><a href="http://jetstrap.com/share/f6e86498c1/home-2">Home
            page 2</a></strike></li>
      <strike> </strike>
      <li><strike><a href="http://jetstrap.com/share/008a825cc0/home-3">Home
            page 3</a></strike></li>
      <strike> </strike>
      <li><strike><a href="http://jetstrap.com/share/529496ba42/home-4">Home
            page 4</a></strike></li>
    </ul>
    <p>Home page 1 chosen by Catrin<br>
    </p>


<h2>Codeigniter</h2>
<p>Current base URL: <?php echo base_url(); ?></p>	
	<div id="body">
		<p>The page you are looking at is being generated dynamically by CodeIgniter, version  <?php echo CI_VERSION; ?>.</p>

		<p>If you would like to edit this page you'll find it located at:</p>
		<code>application/views/welcome_message.php</code>

		<p>The corresponding controller for this page is found at:</p>
		<code>application/controllers/welcome.php</code>

		<p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="user_guide/">User Guide</a>.</p>
	</div>
	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>
    <hr size="2" width="100%"><br>
    <?php    
		// last updated time of this view. Note that the view file has to 
		// be explicitly stated
        // outputs e.g. 'Last modified: March 04 1998 20:43:59.'
		$filename = "application/views/welcome_message.php"; 
		echo "Page last modified: " . date ("F d Y H:i:s.", filemtime($filename));
	?>
</body>
</html>