<!-- CONTENT -->
<p>The following user groups are defined in the repository: </p>

<table class="table table-striped">
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Description</th>
	</tr>
<?php
	foreach($groups as $group)
	{ ?>
	<tr>
		<td><?= $group -> id;?></td>
		<td><?= $group -> name;?></td>
		<td><?= $group -> description;?></td>
	</tr>
	<?php
	}
?>

</table>


<!-- END CONTENT -->