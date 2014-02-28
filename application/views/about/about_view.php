				<?php $this -> load -> view('about/about_submenu_view', $active_submenu); ?>

<!-- CONTENT -->


    <p>The Global Health Repository is aimed at students and teachers of Nursing, Midwifery and the Allied Health Professions. The primary aims of the Global Health Repository are:  </p>
	<ul>
		<li>to provide a framework for sharing information, learning resources and teaching resources on global health issues</li>
		<li>to highlight the critical contribution and role of Nursing, Midwifery and the Allied Health Professions to promoting global health</li>
	</ul>
	

	
	
	<h2>Site contacts</h2>
	<p><?= safe_mailto('catrin.evans@nottingham.ac.uk', 'Catrin Evans'); ?>, Project Manager</p>
	<noscript>Catrin Evans, catrin DOT evans AT nottingham DOT ac DOT uk</noscript>
	<p><?= safe_mailto('fred.riley@gmail.com', 'Fred Riley'); ?>, Technical developer</p>
	<noscript>Fred Riley, fred DOT riley AT gmail DOT com</noscript>
	<p><?php echo $this->site_config->output_admin_email(); ?>, Website administrator</p>






<!-- CONTENT -->