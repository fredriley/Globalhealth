	<?php $this -> load -> view('resourcedb/header'); ?>
    
<h2>Ajax/JSON test</h2>
 <p>Ajax/JSON test from <a href="http://geekhut.org/2009/06/how-to-codeigniter-jquery-json/">tutorial at geekhut</a>. Any text entered into the field should be 'alerted' by the controller 'test'. </p>

<link rel="stylesheet" href="assets/css/jquery.autocomplete.css"  />
<script type="text/javascript" src="assets/jquery/jquery.autocomplete.js" ></script>
<script type="text/javascript" >

// $function() used as  $(document).ready(function() has already been called in the header view

 $(function()
{
		
	// Use jQuery to get and display text entered in the field 'item'		
	$("#submit_item").click(function()
	{
		var item = $("#item").val();	
		/* jquery.post sends and receives data from the server
		Call the 'ajax' method in the 'test' controller, specifying JSON as the data return format, 
		and if any data comes back do summat wi' it. 
		*/
		$.post("test/ajax", { "item": item },
		   function(data){
			   alert(data.result);
		   }, "json");
		
	});
	
	// Autocomplete plugin. The multiple and separator options mean that the user gets
	// suggestions for strings separated by semicolons, else by default it would be 
	// the whole field string. The autofill option places the first selected tag in the field.
	$("#tags").autocomplete('test/tag_autocomplete', 
		{
		multiple: true,
		multipleSeparator: ';', 
		autoFill: true
		});
	
 }); // end function


</script>

<input type="text" id="item" name="item" >
<input type="submit" value="Submit item" id="submit_item" name="submit">
<h2>Autocomplete test</h2>
<p>Using the jquery <a href="http://plugins.jquery.com/project/autocompletex">autocomplete plugin</a>, with jquery.post, to provide an 'auto-suggest' field filled from the keywords table. Based on an <a href="http://codeigniter.com/forums/viewthread/103439/">article on automplete with jQuery and CI</a>. </p>

<p>Start typing: <input name="tags" type="text" id="tags" size="30" ></p>

<?php $this -> load -> view('resourcedb/footer'); ?>
