<?php
# Check if custom confirmation text has come from the controller, and 
# if not stick a default in. 
if (!isset($text))
{
	$text = "\"Do you really want to do this?\"";
}
?>

<script src="js/jquery.confirm.js"></script>
<script>
$(".confirm").confirm({
	text: <?php echo $text; ?>
});
</script>