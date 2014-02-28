
<p>A test to display key areas and child categories in a table, and using Bootstrap rows and spans. Scroll down for Aaron's static example, and the table</p>

<h2>Bootstrap</h2>
<h3>Dynamic span generation</h3>
<p>The controller is passing a query of the key areas table. This view goes through each area and creates a Bootstrap <em>span</em> for each. The number of cols can be set to any divisor of 12 (the number of Bootstrap spans available). </p>

<?php
# Set the number of columns
$cols = 2;
# We've got 12 grid cells across to fill, so set the Bootstrap span accordingly
# NB: This only works for divisors of 12! So setting cols to 5 will fail
$span = "span" . abs(12 / $cols);
# Start off the first row-fluid ?>
<div class="row-fluid">	<?php
echo "\n";
# initialise column count
$count = 0; 

foreach ($query->result() as $key_area)
{
	$key_area_id = $key_area -> id;
	$key_area_title = $key_area -> title;

	# If we've reached the last col in a row, end the row-fluid
	# and start another
	if ($count % $cols == 0)
	{
		echo "\n";?>
		</div> <!-- end row --> <?php
		# Start off the row-fluid ?>
		<div class="row-fluid">	<?php
		echo "\n";
		# reset the count
		$count = 1;
	}
	else
	{
		# increment the column count
		$count++;
	}

	# Start off a 'cell' (span) 
	echo "\n";
	?>
	<div class="alert <?= $span ?>"> 
		<p><strong><?= $key_area_title; ?></strong><p>
		<p>count: <?= $count ?></p>
		<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</p>
	<?php
	# End the 'cell' ?>
	</div> <!-- end span --> <?php

} // end foreach

# If we've finished on an odd key area, end the row-fluid
	if ($count % $cols != 0)
	{
		echo "\n";?>
		</div> <!-- end row --> <?php
	}
?>



<h3>Aaron's static example</h3>
<div class="row-fluid">

	<div class="alert span6">

		<p><strong>Global health topics</strong><p>

		<input name="subjects[]" value="79" type="checkbox">&nbsp;&nbsp;Child health<br>

		<input name="subjects[]" value="44" type="checkbox">&nbsp;&nbsp;Communicable diseases<br>

		<input name="subjects[]" value="56" type="checkbox">&nbsp;&nbsp;Determinants of health<br>

		<input name="subjects[]" value="77" type="checkbox">&nbsp;&nbsp;Epidemiology and burden of disease<br>

		<input name="subjects[]" value="81" type="checkbox">&nbsp;&nbsp;Gender and health<br>

		<input name="subjects[]" value="55" type="checkbox">&nbsp;&nbsp;Global health issues<br>

		<input name="subjects[]" value="78" type="checkbox">&nbsp;&nbsp;Health systems and models of service delivery<br>

		<input name="subjects[]" value="80" type="checkbox">&nbsp;&nbsp;Maternal health<br>

		<input name="subjects[]" value="57" type="checkbox">&nbsp;&nbsp;Millennium Development Goals<br>

		<input name="subjects[]" value="58" type="checkbox">&nbsp;&nbsp;Non-communicable diseases<br>

		<input name="subjects[]" value="83" type="checkbox">&nbsp;&nbsp;Poverty and inequality<br>

		<input name="subjects[]" value="82" type="checkbox">&nbsp;&nbsp;Unintentional injuries<br>

	</div>

	<div class="alert span6">

	<p><strong>Globalisation and social change</strong></p>

	<input name="subjects[]" value="39" type="checkbox">&nbsp;&nbsp;Climate change and sustainability<br>

	<input name="subjects[]" value="41" type="checkbox">&nbsp;&nbsp;Global economy and health<br>

	<input name="subjects[]" value="76" type="checkbox">&nbsp;&nbsp;Global health governance<br>

	<input name="subjects[]" value="45" type="checkbox">&nbsp;&nbsp;New and emerging infectious diseases<br>

	<input name="subjects[]" value="75" type="checkbox">&nbsp;&nbsp;Population growth<br>

	<input name="subjects[]" value="60" type="checkbox">&nbsp;&nbsp;Population migration and health<br>

	<input name="subjects[]" value="74" type="checkbox">&nbsp;&nbsp;Social justice, human rights and health<br>

	<input name="subjects[]" value="61" type="checkbox">&nbsp;&nbsp;Technology<br>

	<input name="subjects[]" value="59" type="checkbox">&nbsp;&nbsp;Theories of globalisation<br>

	<input name="subjects[]" value="38" type="checkbox">&nbsp;&nbsp;Urbanisation<br>

	</div>

	</div>

	<div class="row-fluid">                                                

	<div class="alert span6">

	<p><strong>Health professions in a global context </strong></p>

	<input name="subjects[]" value="66" type="checkbox">&nbsp;&nbsp;Education<br>

	<input name="subjects[]" value="63" type="checkbox">&nbsp;&nbsp;Human resource status and policies<br>

	<input name="subjects[]" value="64" type="checkbox">&nbsp;&nbsp;Leadership<br>

	<input name="subjects[]" value="51" type="checkbox">&nbsp;&nbsp;Migration of health professionals<br>

	<input name="subjects[]" value="65" type="checkbox">&nbsp;&nbsp;Regulation and governance<br>

	</div>

	<div class="alert span6">

	<p><strong>Overseas electives</strong></p>

	<input name="subjects[]" value="73" type="checkbox">&nbsp;&nbsp;Effective learning from an overseas placement<br>

	<input name="subjects[]" value="72" type="checkbox">&nbsp;&nbsp;Planning a clinical placement  overseas<br>

	</div>

	</div>

	<div class="row-fluid">

	<div class="alert span6">

	<p><strong>Teaching global health</strong></p>

	<input name="subjects[]" value="68" type="checkbox">&nbsp;&nbsp;Cultural competence<br>

	<input name="subjects[]" value="67" type="checkbox">&nbsp;&nbsp;Global citizenship<br>

	<input name="subjects[]" value="69" type="checkbox">&nbsp;&nbsp;Global health course design<br>

	<input name="subjects[]" value="70" type="checkbox">&nbsp;&nbsp;Global health teaching<br>

	<input name="subjects[]" value="71" type="checkbox">&nbsp;&nbsp;Supporting international students<br>

	</div>

</div>

<h3>Table</h3>
<table align="left" border="1" cellspacing="3" cellpadding="3" width="90%">
	<tr align="left" valign="top">
		<th>Key area</th>
		<th>Categories</th>
	</tr>
	
<?php
foreach ($query->result() as $data)
{
	$key_area_id = $data -> id;
	$key_area_title = $data -> title;
	echo "<tr>\n";
		echo "<td>" . $key_area_title . "</td>";
		echo "<td>";

		# Get child categories
		$qry = $this -> ResourceDB_model -> get_key_area_children($key_area_id);
		$table_row = array();
		foreach ($qry -> result() as $child)
		{
			echo form_checkbox("subjects[]", $child ->id, FALSE) . "&nbsp;&nbsp;" . $child -> title . "<br />\n";	
		}
		echo "</td>\n";
	echo "</tr>\n";
}

?>
</table>

