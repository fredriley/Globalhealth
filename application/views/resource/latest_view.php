				<?php $this -> load -> view('search/search_submenu_view', $active_submenu); ?>

<!-- CONTENT --> 
<p>The <?php echo $n; ?> latest resources added to the Global Health repository:</p>

<?php
	$this -> load -> helper('date');
	foreach ($latest_query -> result() as $row)
	{
		$date_created = mysql_to_unix($row -> metadata_created);
		$date_created = date('d/m/Y', $date_created);
		echo anchor('detail/record/' . $row ->id, $row->title ) . " (" . $date_created . ")<br />\n";
	}
?>




<!-- END CONTENT -->