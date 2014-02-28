	<?php $this -> load -> view('resourcedb/header'); ?>
	<h1><?php echo $heading;?></h1>
    <div id="message" class="notify"><?php echo $message; ?></div>
    <div id="error" class="error"><?php echo $error; ?></div>

	<p>The resource was successfully updated. Would you now like to:
<p><a href="insert">add a resource?</a>	</p>
    <p><a href="edit/resource/<?php echo $resource_id; ?>">edit the resource you've just updated?</a></p>
    <p><a href="detail/record/<?php echo $resource_id; ?>">view the resource record you've just updated?</a></p>
    
    <p>Otherwise, you can carry on using the database via the menu above. </p>
    
    <?php $this -> load -> view('resourcedb/footer'); ?>
