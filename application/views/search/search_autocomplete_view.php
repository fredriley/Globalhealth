    <link rel="stylesheet" href="css/jquery.autocomplete.css"  />
<script type="text/javascript" src="js/jquery.autocomplete.js" ></script>
<script type="text/javascript" >

// $function() used as  $(document).ready(function() has already been called in the header view
 $(function()
	{
		
	// Autocomplete plugin. The autofill option places the first selected value in the field.
	$("#title").autocomplete('form/resource_autocomplete');
	
 }); // end function
 
</script>