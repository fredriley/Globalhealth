
<script type="text/javascript" >
// $function() used as  $(document).ready(function() has already been called in the header view
 $(function()
	{
		
	// Autocomplete plugin. The multiple and separator options mean that the user gets
	// suggestions for strings separated by semicolons, else by default it would be 
	// the whole field string. The autofill option places the first selected tag in the field.
	$("#tags").autocomplete('resource/tag_autocomplete', 
		{
		multiple: true,
		multipleSeparator: ';', 
		autoFill: true
		});
	
 }); // end function
 
</script>