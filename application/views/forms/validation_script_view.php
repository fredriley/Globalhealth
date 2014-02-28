<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript">

 $(document).ready(function()
 {
 
	// Validation code
	// ---------------
	// Documentation at http://docs.jquery.com/Plugins/Validation
	$("#frm_email").validate(
	{
		rules: 
		{
			email:
			{
				required: true,
				email: true
			},
			realname: 
			{
				required: true
			},
			message: 
			{
				required: true			
			}		
		
		}
	});	
	
 }); // end document ready
</script>