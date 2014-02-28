<!-- CONTENT --> 
    <div id="message" class="notify"><?php echo $message; ?></div>
    <div id="error" class="error"><?php echo $error; ?></div>

	<p>The resource was added successfully to the database. Would you now like to:
    
    <p><a href="resource/insert">add another resource?</a>	</p>
    <p><a href="resource/edit/<?php echo $resource_id; ?>">edit the resource you've just added?</a></p>
	<p><a href="resource/choose/">choose another resource to edit?</a></p>
    
    
 <!-- END CONTENT -->