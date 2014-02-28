	<?php $this -> load -> view('resourcedb/header'); ?>
	<h1><?php echo $heading;?></h1>
 	<p>A database error has occurred - sorry. Further details below, perhaps: </p>
   <div id="message" class="notify"><?php echo $message; ?></div>
    <div id="error" class="error"><?php echo $error; ?></div>

    
    <?php $this -> load -> view('resourcedb/footer'); ?>
