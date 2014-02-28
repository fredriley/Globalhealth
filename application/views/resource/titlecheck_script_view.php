<script type="text/javascript">

	// Disable the check title button until there's something to check!
	$("#check_title").attr('disabled', 'disabled');
	$('#title').keyup(function(){
		if ( $("#title").val().length > 0 ) 
		{
		   	$("#check_title").removeAttr('disabled');
		} 
		else 
		{
			$("#check_title").attr('disabled', 'disabled');
		}
		//$("#check_title").removeAttr('disabled');
	});
 
 	$("#check_title").click(function()
	 {
	    // Hide the span which will contain the output of the asset title check
		$("#display_text").hide();

		
		// Send the Ajax request to match the input resource title 
		$.post("resource/title_check", { title:  $("#title").val() }, function(data)
		{
			/* Set the HTML of the span to the script output */
			$("#display_text").html(data).show();

		} );
		
	});

</script>