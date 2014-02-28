	
	<script type="text/javascript" src="js/jquery.tagsinput.min.js">
	/* Tags input plugin for prettified tags. 
	   See http://xoxco.com/projects/code/tagsinput/ for demo and docs
	   See http://bassistance.de/jquery-plugins/jquery-plugin-autocomplete/ for autocomplete plugin
	   Works with autocomplete plugin. Tag separator is comma. Requires CSS file. 
	   Tags POSTed as comma-separated string. 
	*/
	</script>
	<link rel="stylesheet" type="text/css" href="css/jquery.tagsinput.css" />
	<script type="text/javascript">

		$(function() 
		{
			$('#tags').tagsInput({
				height:'100px',
				width:'500px', 
				/* autocomplete_url:'resource/tag_autocomplete', 
				autocomplete:
					{
						selectFirst:true,
						multiple: false, 
						width: '100px', 
						autoFill:true 
					}*/
				});
		});
	</script>