{* Smarty *}

<!DOCTYPE html>

<html lang=en>
<head>
<meta charset=utf-8>
<meta http-equiv="Refresh" content="300" />
<title>py-kms server</title>
<meta name=description content="py-kms server">
<meta name=keywords content=php py-kms>
</head>
<body>
<table border=1 cellspacing=0 cellpadding=2 width=90% align=center>
	<thead bgcolor=silver>
	<tr>
		<th>Machine name</th><th>App ID</th><th>App version</th><th>License status</th><th>Last request time</th><th>Request count</th>
	</tr>
	<thead>
	{foreach key=value item=name from=$query}
	<tr>
		<td title={$name.clientMachineId}>{$name.machineName}</td>
		<td>{$name.applicationId}</td>
		<td>{$name.skuId}</td>
		<td title={$name.kmsEpid}>{$name.licenseStatus}</td>
		<td>{$name.lastRequestTime|date_format:$config.dateforamt}</td>
		<td>{$name.requestCount}</td>
	</tr>
	{foreachelse}
    <tr>
		<td colspan=6>Database is empty</td>
	</tr>
	{/foreach}
	<tr bgcolor=silver>
		<td colspan=5><b>Total request count:</b></td>
		<td>{$totalRequestCount}</td>
	</tr>
</table>
</body>
</html>
