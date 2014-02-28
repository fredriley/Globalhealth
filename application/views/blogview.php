<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $title; ?></title>
</head>

<body>
<h1><?php echo $heading; ?></h1>
<p>This is the viewer page views/blogview.php</p>


<?php 
# Iterate the query array coming from the controller, initialised as:
# 		$data['query'] = $this -> db -> get('entries');

foreach($query -> result() as $row) { ?>

<h3><?php echo $row -> title; ?></h3>
<p><?php echo $row -> body; ?></p>
<p><?php echo anchor('blog/comments/' . $row->id, 'Comments'); ?></p>
<hr  />

<?php
}
?>


</body>
</html>
