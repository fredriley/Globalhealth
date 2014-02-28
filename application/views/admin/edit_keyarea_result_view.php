<?php $this -> load -> view('admin/admin_submenu_view', $active_submenu); ?>

<!-- CONTENT -->
    <div id="message" class="notify"><?php echo $message; ?></div>
    <div id="error" class="error"><?php echo $error; ?></div>

	<p>The key area was successfully updated. Would you now like to:
    <p><a href="keyareas/edit/<?php echo $keyarea_id; ?>">edit the key area you've just updated?</a></p>
    <p><a href="admin/keyareas">view all key areas in the repository?</a></p>
    
    <p>Otherwise, you can carry on using the database via the menu above. </p>
    
<!-- END CONTENT -->
