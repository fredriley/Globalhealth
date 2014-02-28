	<?php $this -> load -> view('resourcedb/header'); ?>
	<h1><?php echo $heading;?></h1>
    <div id="message" class="notify"><?php echo $message; ?></div>
    <div id="error" class="error"><?php echo $error; ?></div>

	<p>The resource was added successfully to the database. Would you now like to:
    
    <p><a href="insert">add another resource?</a>	</p>
    <p><a href="edit/resource/<?php echo $resource_id; ?>">edit the resource you've just added?</a></p>
    
    <p>Otherwise, you can carry on using the database via the menu above. </p>
    
    <?php $this -> load -> view('resourcedb/footer'); ?>
