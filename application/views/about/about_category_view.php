				<?php $this -> load -> view('about/about_submenu_view', $active_submenu); ?>
<!-- CONTENT --> 
<div class="row-fluid">
<div class="span8">


<p>The key area <em><?= $title ?></em> encompasses the following categories:</p>
<ul>
<?php
foreach ($topics as $topic)
{
	echo "<li>" . $topic . "</li>\n";
}
?>
</ul>

</div>
<div class="span4 well">
<p>Latest resources in the key area <em><?= $title ?></em>:</p>
<?php
if ($query->num_rows() > 0)
{
	echo "<ul>\n";
   foreach ($query->result() as $row)
   {
		$url = 'detail/record/' . $row -> id;
		$text = $row -> title;
		echo "<li>" . anchor($url, $text) . "</li>\n";
	}
	echo "</ul>\n";
}
?>
</div>
</div>





<!-- END CONTENT -->