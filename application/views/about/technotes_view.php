				<?php $this -> load -> view('about/about_submenu_view', $active_submenu); ?>

<!-- CONTENT -->
	<p>This repository/site is constructed to be as compliant as possible with international standards, thus enabling cross-platform and cross-browser display on desktop and mobile devices, though it's primarily aimed at desktop computers. </p>
	
	<h2>Accessibility</h2>
	<p>The site should be at least compliant to AA standards with the W3C Accessibility Guidelines, and by adhering to international standards it allows you to use browser features to customise the view to your needs.</p>
	<h2>Tools</h2>
	<p>This site has been developed using the following technologies:</p>
	
	<div class="row-fluid">
		<div class="span6 well">
		<h3>Front end</h3>
		<ul>
			<li>HTML5</li>
			<li>CSS3</li>
			<li>jQuery</li>
			<li>Bootstrap</li>
		</ul>

	
		</div>
		<div class="span6 well">
		<h3>Back end</h3>
		<ul>
			<li>PHP & Codeigniter</li>
			<li>MySQL</li>
		</ul>

	
		</div>
	</div>
	
	<?php
	# Enable access to tech documentation for admin users only
	if ($this -> ion_auth -> is_admin())
	{ ?>
		<h2>Administrator documentation</h2>
		<p>The links below are to technical and administrative documents about the repository, and are only available to logged-in administrators. Please do not circulate them as they contain information which could be used to hack the site.</p> 
		
		<p>The docs are password-protected to prevent URL hacking, so on first click you'll receive an authentication prompt: use <span class="label label-important">globalhealth/squirrels</span> when this happens. Thereafter you'll not be prompted during your current browser session. </p>
		<h3>Admin docs</h3>
			<p>User administration (<a href="docs/user_admin.rtf">RTF</a>) (<a href="docs/user_admin.odt">Libre Office</a>)</p>
			<p><a href="docs/sonarc-GlobalHealthrepository-140812-1552-6150.pdf">Project specification</a> (PDF)</p>
		<h3>Technical docs</h3>
			<p>Technical notes (<a href="docs/technotes.rtf">RTF</a>)(<a href="docs/technotes.odt">Libre Office</a>)</p>
			<p>File list (<a href="docs/filelist.rtf">RTF</a>) (<a href="docs/filelist.odt">Libre Office</a>)</p>
		<h3>Resources</h3>
			<p><a href="docs/GH repository database.xls">Resources spreadsheet</a> compiled by Rebecca Gibbs (Excel)</p>

		<?php
	
	}

	?>

	<h2>Site contacts</h2>
	<p><?= safe_mailto('catrin.evans@nottingham.ac.uk', 'Catrin Evans'); ?>, Project Manager</p>
	<noscript>Catrin Evans, catrin DOT evans AT nottingham DOT ac DOT uk</noscript>
	<p><?= safe_mailto('fred.riley@gmail.com', 'Fred Riley'); ?>, Technical developer</p>
	<noscript>Fred Riley, fred DOT riley AT gmail DOT com</noscript>
	<p><?php echo $this->site_config->output_admin_email(); ?>, Website administrator</p>




<!-- CONTENT -->