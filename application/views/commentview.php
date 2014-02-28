<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $title; ?></title>
</head>

<body>
<h1><?php echo $heading; ?></h1>
<p>This is the viewer page views/commentview.php</p>

<?php 
# Iterate the query array coming from the controller, initialised as:
# 		$data['query'] = $this -> db -> get('entries');

# Check that the query's returned values before hitting the foreach
if 	($query -> num_rows() > 0 )
{
	foreach($query -> result() as $row)
	 { ?>
	
	<p><?php echo $row -> body; ?></p>
	<p><?php echo $row -> author; ?></p>
	
	<hr  />
	
	<?php
	}
} ?>

<p><?php echo anchor('blog', 'Back to blog'); ?></p>


<?php 
# Use helper file loaded in controller to create a simple HTML form

echo form_open('blog/comment_insert');
# Print hidden field for the comment id, using the uri class to get the
# third segment - in this case, the comment id - from this file's URL
echo form_hidden('entry_id', $this -> uri->segment(3));

?>

<p><textarea name="body" rows="10"></textarea></p>
<p><input type="text" name="author"  /></p>
<p><input type="submit" value="Submit comment"  /></p>



</body>
</html>
