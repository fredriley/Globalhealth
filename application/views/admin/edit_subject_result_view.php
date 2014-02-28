<?php $this -> load -> view('admin/admin_submenu_view', $active_submenu); ?>

<!-- CONTENT -->
    <div id="message" class="notify"><?php echo $message; ?></div>
    <div id="error" class="error"><?php echo $error; ?></div>

	<p>The subject/category was successfully updated. Would you now like to:
    <p><a href="subjects/edit/<?php echo $subject_id; ?>">edit the category you've just updated?</a></p>
    <p><a href="admin/categories">view all categories in the repository?</a></p>
    
    <p>Otherwise, you can carry on using the repository via the menu above. </p>
    
<!-- END CONTENT -->
