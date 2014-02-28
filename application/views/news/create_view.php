<?php 
	$this -> load -> view('news/news_submenu_view', $active_submenu); 
?>

<!-- CONTENT --> 

<?php echo validation_errors(); ?>

<?php echo form_open(base_url() . 'news/create') ?>

	<label for="title">Title</label> 
	<input type="input" name="title" value="<?php echo set_value('title'); ?>" class="input-large" /><br />

	<label for="text">Text</label>
	<textarea name="text"  class="input-xxlarge" ><?php echo set_value('text'); ?></textarea><br />
	
	<input type="submit" name="submit" value="Create news item" /> 

</form>

<!-- END CONTENT --> 