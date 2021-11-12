{* Smarty *}

<!DOCTYPE html>

<html lang=en>
<head>
<meta charset="utf-8">
<meta http-equiv="Refresh" content="300" />
<title>py-kms server</title>
<meta name="description" content="py-kms php viewer python kms server">
<meta name="keywords" content="py-kms php viewer python kms server">
<meta name="robots" content="noindex, nofollow">
<link href="templates/css/styles.min.css" rel="stylesheet">
</head>
<body>
{if $Error }
	<p>{$ErrorMessage}</p>
{else}
<table class="datatable">
	<thead class="header">
	<tr>
		<th>Machine name</th><th>App ID</th><th>App version</th><th>License status</th><th>Last request time</th><th>Request count</th>
	</tr>
	</thead>
	<tbody>
	{foreach key=value item=name from=$query}
	<tr>
		<td title={$name.clientMachineId}>{$name.machineName}</td>
		<td>{$name.applicationId}</td>
		<td>{$name.skuId}</td>
		<td title={$name.kmsEpid}>{$name.licenseStatus}</td>
		<td>{$name.lastRequestTime|date_format:$config.dateformat}</td>
		<td>{$name.requestCount}</td>
	</tr>
	{foreachelse}
    <tr>
		<td colspan=6>Database is empty</td>
	</tr>
	{/foreach}
	</tbody>
	<tfoot>
	<tr class="header">
		<td colspan=5><b>Total requests count:</b></td>
		<td>{$totalRequestCount}</td>
	</tr>
	</tfoot>
</table>
<!-- <p align="center">© 2021 arturolegovich, arturolegovich@gmail.com</p> -->
{/if}
</body>
</html>
