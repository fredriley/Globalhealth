<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PHP test</title>
</head>

<body>
<h1>Server variables</h1>
<p>The table below shows all the keys and values in $_SERVER</p>
<p>&nbsp;  </p>
<table border="1" cellpadding="3" cellspacing="3" width="90%" bgcolor="#FFFF99">
<?php 
	foreach($_SERVER as $key => $val)
	{
		?>
		<tr>
			<th><?php echo $key ?></th>
			<td><?php echo $val ?></td>
		</tr>
		<?php
	}
?>

</table>
</body>
</html>
