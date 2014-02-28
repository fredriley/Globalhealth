	<?php $this -> load -> view('resourcedb/header'); ?>
	<h1><?php echo $heading;?></h1>
    
	    <div id="message" class="notify"><?php echo $message; ?></div>
	<p>Your password has been reset. You should receive an email with the new password shortly. If you don't, or have problems logging in with the new password, please contact the <a href="mailto:fred.riley@nottingham.ac.uk">site administrator</a>. </p>
    
    <?php $this -> load -> view('resourcedb/footer'); ?>
