				<?php $this -> load -> view('news/news_submenu_view', $active_submenu); ?>
<!-- CONTENT -->

<?php 
# Display any form validation errors coming back from controller
echo validation_errors(); 

# Set date format for use in mdate() calls below. Example format result:
# 02-04-2013 21:48
# See PHP date() function docs for format string options:
# http://www.php.net/manual/en/function.date.php
# mdate() is part of the CI date helper, loaded in the calling controller
$datestring = "%d-%m-%Y %H:%i";
# Check both posted and edited date fields to see if they've empty dates
# strtotime() returns blank if fed an empty MySQL date string (0000-00-00 00:00:00)
# NB: can't use empty() to test the output of a function, only a variable
if (strtotime($posted) == '')
{ $posted = "unknown"; }
else
{ //$posted = mdate($datestring, mysql_to_unix($posted, TRUE, 'eu')); 
}
if (strtotime($edited) == '')
{ $edited = "unknown"; }
else
{ $edited = mdate($datestring, mysql_to_unix($edited, TRUE, 'eu')); }
?>

<?php echo form_open('news/edit/' . $id) ?>

	<label for="id">ID</label> 
	<input type="input" name="id" value = "<?php echo $id; ?>" readonly="readonly"/ class="input-mini"><br />
	
	<label for="posted">Posted</label> 
	<input type="input" name="posted" value = "<?php echo $posted; ?>" readonly="readonly"/ class="input-medium"><br />

	<label for="title">Last edited</label> 
	<input type="input" name="edited" value = "<?php echo $edited; ?>" class="input-medium" readonly="readonly" /><br />

	<label for="title">Title</label> 
	<input type="input" name="title" value = "<?php echo $news_title; ?>" class="input-large" /><br />
	
	<label for="text">Text</label>
	<textarea name="text" rows="10" class="input-xxlarge"><?php echo $text; ?></textarea><br />
	
	<input type="submit" name="submit" value="Edit news item" /> 

</form>

<!-- END CONTENT -->