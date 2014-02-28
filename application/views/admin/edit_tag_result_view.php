<?php $this -> load -> view('admin/admin_submenu_view', $active_submenu); ?>

<!-- CONTENT -->
    <div id="message" class="notify"><?php echo $message; ?></div>
    <div id="error" class="error"><?php echo $error; ?></div>

	<p>The tag was successfully updated. Would you now like to:
    <p><a href="tags/edit/<?php echo $tag_id; ?>">edit the tag you've just updated?</a></p>
    <p><a href="admin/tags">view all tags in the repository?</a></p>
    
    <p>Otherwise, you can carry on using the database via the menu above. </p>
    
<!-- END CONTENT -->
