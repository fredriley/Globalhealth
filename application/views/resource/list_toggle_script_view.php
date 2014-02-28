<script type="text/javascript" >

// $function() used as  $(document).ready(function() has already been called in the header view
 $(function()
 {
	
	// Toggle more/less info
	// Code and coments from: http://andylangton.co.uk/articles/javascript/jquery-show-hide-multiple-elements/
	// NB: Set elements for toggling with class="toggle". That's it!
	// choose text for the show/hide link - can contain HTML (e.g. an image)
	var showText='more';
	var hideText='less';
	
	// initialise the visibility check
	var is_visible = false;
	
	// append show/hide links to the element directly preceding the element with a class of "toggle"
	$('.toggle').prev().append(' [<a href="#" class="toggleLink">'+showText+'</a>]');
	
	// hide all of the elements with a class of 'toggle'
	$('.toggle').hide();
	
	// capture clicks on the toggle links
	$('a.toggleLink').click(function() {
	
		// switch visibility
		is_visible = !is_visible;
		
		// change the link depending on whether the element is shown or hidden
		$(this).html( (!is_visible) ? showText : hideText);
		
		// toggle the display - uncomment the next line for a basic "accordion" style
		//$('.toggle').hide();$('a.toggleLink').html(showText);
		$(this).parent().next('.toggle').toggle(400);
		
		// return false so any link destination is not followed
		return false;
		
	});
	
}); // end $function
	
</script>