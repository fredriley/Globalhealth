<?php $this -> load -> view('resourcedb/header'); ?>

<h1><?php echo $heading;?></h1>
    <?php 
	
	# Display all comments for this resource, above the comment form
	# First check that there are comments to display, and if not skip the foreach
	if ($comments_query -> num_rows() > 0)
	{
		foreach ($comments_query -> result() as $row)
		{
			echo "<p><strong>Comment: </strong>" . $row -> body . " </p> ";
			# Comment author is returned as a person ID, so get the person details
			# from the model. This may be a breach of strict MVC? WTF, it works for now.
			//$author_qry = $this -> ResourceDB_model -> get_person($row -> author);
			//$author_row = $author_qry -> row();
			$user = $this -> ion_auth -> get_user($row -> author);
			//$author = $author_row -> firstname . " " . $author_row -> lastname;
			echo "<p><strong>Author: </strong>" . $user -> first_name . " " . $user -> last_name . " </p> ";
			
			# Use date helper functions to present the date the comment was written in the form:
			# "Sun, 14 Aug 2005 16:13:03 UTC"
			$format = 'DATE_RFC822';
			# Need to convert from mySQL date format to Unix, to use in standard_date()
			$date = mysql_to_unix($row -> date);
			echo "<p><em>" . standard_date($format, $date) . "</em></p>";
			echo "<hr />";
		}
	}
	else
	{
		echo "<p>No comments posted so far. </p>";
	}
	
	# See if user logged in. If yes, display a comment form; if no, prompt to register or login
	
	if ($this -> ion_auth -> logged_in())
	{
		# URL helper function to open a form using POST
		echo form_open('comment/insert/' . $resource_id);
		# Get resource ID to pass on.   
		echo form_hidden('resource_id', $resource_id); 
		# Use date helper function to format current timestamp for mySQL
		$now = time();
		# unix_to_human() will return a timestamp of the form YYYY-MM-DD HH:MM:SS 
		# which fits a mySQL DATETIME data type
		$date = unix_to_human($now, TRUE, 'eu');
		# Get user email/username to store as author of comment
		$user = $this -> ion_auth -> user()->row();
		$email = $user -> email;
		$user_id = $user -> id;
		?>
		<p>Username<br /><input type="text" readonly="readonly" id="author" name="author" value="<?php echo $email; ?>"  /></p>
		<p>Comments<br /><textarea name="comment" id="comment" rows="10" cols="50" >Enter your comments here</textarea></p>
		<p><input type="hidden" name="date" value="<?php echo $date; ?>"  />
        <p><input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>"  />
		<p><input type="submit" value="Submit comment"  /></p>
     	</form>
     	<?php
	}
	else
	{
		$msg = "<p>You need to be logged in to post a comment. </p>";
		$msg .= "<p>" . anchor('auth/login', 'Login', '') . " | " . anchor('register', 'Register', '') . "</p>";
		echo $msg;
	}
	
	
		
	
	
	?> 
	
</body>
</html>
