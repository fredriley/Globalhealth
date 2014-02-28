<?php $this -> load -> view('admin/admin_submenu_view', $active_submenu); ?>

<!-- CONTENT -->
    <div id="message" class="notify"><?php echo $message; ?></div>
    <div id="error" class="error"><?php echo $error; ?></div>

	<p>The subject was successfully added. Would you now like to:
    <p><a href="subjects/edit/<?php echo $subject_id; ?>">edit the subject you've just added?</a></p>
    <p><a href="admin/categories">view all subjects in the repository?</a></p>
    
    <p>Otherwise, you can carry on using the database via the menu above. </p>
    
<!-- END CONTENT -->
