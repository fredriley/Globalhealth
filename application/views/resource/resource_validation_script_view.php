<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript">

 $(function()
 {
 
	// Validation code
	// ---------------
	// Documentation at http://docs.jquery.com/Plugins/Validation
	$("#frm_resource").validate(
	{
		rules: 
		{
			title:
			{
				required: true
			},
			url:
			{
				required: true, 
				url: true
			}, 
			description: 
			{
				//required: true
			}	
		
		}
	});	
	
 }); // end function
</script>