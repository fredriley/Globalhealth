<?php 
/**  View template 1
* Hero unit, three span-4 cols below. Used on home page
* This is a template view, called from a controller which passes a data
* array to it with vars such as page title, active menu items, etc. 
* This view loads the basic elements of a page - header, navbar, etc - as views and 
* when loaded in the controller the vars pass to these views. The page content view is
* loaded in the controller into a variable, which is then passed to this view as $data['content'] to 
* display the page. Hence the echo statement. 

* @author Fred Riley <fred.riley@gmail.com>
* @version 1.0
* @package Global Health
*/

$this -> load -> view('header_view');
$this -> load -> view('top_navbar_view');
$this -> load -> view('left_navbar_view');
# Display content passed from controller loading this view. The content in turn 
# is from a view (eg about_view.php)
echo $content;
$this -> load -> view('footer_view');
?>

