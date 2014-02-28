<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <base href="<?php echo base_url(); ?>"  />
	<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<body>


<h1>Test page</h1>
<p>Testing various CI functions and whatnot</p>
<p><a href="test/email">Email test</a> - clicking the link should send an email from fred.riley@gmail.com and load a view with the email data. Clicking <a href="test/email2">email test2</a> should send an email from fred.riley@fredriley.org.uk. </p>
<p>Tooltip test - <a href="#" data-toggle="tooltip" title="first tooltip">hover over me</a>. Or try an image - <a href="#" id="help" title="should be hovering now"><img src="img/blue-question-mark.png" alt="" ></a></p>
</body>
</html>

<script type="text/javascript">
	$("help").tooltip();
</script>