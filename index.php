<?php
require_once ("config/config.php");
require_once($config["smarty_dir"] . "Smarty.class.php");

$smarty = new Smarty();

$smarty->template_dir = $config["template_dir"];
$smarty->compile_dir = $config["compile_dir"];
$smarty->config_dir = $config["config_dir"];
$smarty->cache_dir = $config["cache_dir"];
$smarty->caching = $config["caching"]; // Срок действия только для этой копии
$smarty->cache_lifetime = 300;
$smarty->assign('config',$config);

# Change variables for youself!
$sqlite_dbpath = $config["sqlite_dbpath"];
//$dateformat = "d.m.Y H:i:s";
#######################
# ---- START SCRIPT----
#######################
if (!file_exists($sqlite_dbpath)) {
	$smarty->assign("ErrorMessage","Error: file $sqlite_dbpath not found!");
} else {
	$dbn = "sqlite:$sqlite_dbpath";
	try {
		$dbh = new PDO($dbn);
	}
	catch (PDOException $e) {
		echo "Error: " . $e->getMessage(). "!";
	die();
	}
$sql = "SELECT sum(requestCount) FROM clients";
foreach ($dbh->query($sql) as $row) {
	$totalRequestCount = $row[0];
}
$smarty->assign("totalRequestCount",$totalRequestCount);

$sql = "SELECT clientMachineId, machineName, applicationId, skuId, licenseStatus, lastRequestTime, kmsEpid, requestCount FROM clients";

$db = $dbh->prepare($sql);
$db->execute();

$smarty->assign('query', $db->fetchAll());

/*
foreach ($dbh->query($sql) as $row) {
	echo "	<tr>
		<td>" . $row['machineName'] . "</td>
		<td>" . $row['applicationId'] . "</td>
		<td>" . $row['skuId'] . "</td>
		<td>" . $row['licenseStatus'] . "</td>
		<td>" . date($dateformat,$row['lastRequestTime']). "</td>
		<td>" . $row['requestCount'] . "</td>
	</tr>\n";
}*/
}

//** Smarty Debug, default: false
//$smarty->debugging = true;

$smarty->display('index.tpl');
?>
