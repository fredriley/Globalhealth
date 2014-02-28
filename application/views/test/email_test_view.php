<h1>Email test page</h1>
<p>An email should have been sent with the following fields:</p>

<table >
	<tr>
		<th>From email</th>
		<td><?= $from_email ?></td>
	</tr>
	<tr>
		<th>From name</th>
		<td><?= $from_name ?></td>
	</tr>
	<tr>
		<th>To email</th>
		<td><?= $to_email ?></td>
	</tr>
	
	<tr>
		<th>Subject</th>
		<td><?= $subject ?></td>
	</tr>
	
	<tr>
		<th>Message</th>
		<td><?= $message ?></td>
	</tr>
</table>