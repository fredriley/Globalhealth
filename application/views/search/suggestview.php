	<?php $this -> load -> view('resourcedb/header'); ?>
	<h1><?php echo $heading;?></h1>

    <p>If you know of a resource which might be useful to teachers, students and workers involved in healthcare, please suggest it via the form below. Each suggestion will be carefully reviewed before adding to the database. The resource must be eithe free to use, or have significant free content. Purely commercial resources will <em>not</em> be added to the database.</p>
<?php

	# See if user logged in. If yes, display a comment form; if no, prompt to register or login
	
	if ($this -> ion_auth -> logged_in())
	{
		# If form is being recreated because it's not validated, show the errors
		echo validation_errors();
		# Get user ID and name
		$user = $this -> ion_auth -> user()->row();
		$user_id = $user -> id;
		
		# Display suggestion form 
		echo form_open('suggest/submit');
		echo form_hidden('user_id', $user_id);
		echo "<p>Resource title: <br />";
		$field_data = array(
              'name'        => 'title',
              'id'          => 'title',
              'value'       => set_value('title'),
              'maxlength'   => '100',
              'size'        => '50',
            );
		//echo form_input('title', set_value('title'));
		echo form_input($field_data);
		echo '<p>URL: <br />';
		$field_data = array(
              'name'        => 'url',
              'id'          => 'url',
              'value'       => set_value('url'),
              'maxlength'   => '100',
              'size'        => '50',
            );
		echo form_input($field_data) . '</p>';
		echo '<p>Description: <br />'; 
		$field_data = array(
              'name'        => 'description',
              'id'          => 'description',
              'value'       => set_value('description'),
              'rows'   => '10',
              'cols'        => '50',
            );
		echo form_textarea($field_data) . '</p>';
		echo '<p>Suggested tags: <br />'; 
		# Use jQuery autocomplete here??
		$field_data = array(
              'name'        => 'tags',
              'id'          => 'tags',
              'value'       => set_value('tags'),
              'maxlength'   => '100',
              'size'        => '50',
            );		
		echo form_input($field_data) . '</p>';
		echo form_submit('submit', 'Submit suggestion');
		
		
		echo form_close();
	}
	else
	{
		echo "<div class=\"error\">You need to be logged in to make a suggestion. If you don't yet 
			have a login, you can <a href=\"register\">register yourself</a>.</div>";
	}
?>

    <p>This is the public interface to the database. If you'd like to enter or update existing records, please use the <a href="http://www.nottingham.ac.uk/~ntzrlo/rlos/database/resource/">contributor interface</a> (you need to be a registered user). 
	
    
    <?php $this -> load -> view('resourcedb/footer'); ?>
