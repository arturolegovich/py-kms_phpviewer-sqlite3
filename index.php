<?php
require_once ("config/config.php");
require_once($config["smarty_dir"] . "Smarty.class.php");

$smarty = new Smarty();

$smarty->template_dir = $config["template_dir"];
$smarty->compile_dir = $config["compile_dir"];
$smarty->config_dir = $config["config_dir"];
$smarty->cache_dir = $config["cache_dir"];
$smarty->caching = $config["caching"];
$smarty->cache_lifetime = $config["cache_lifetime"];
$smarty->assign('config',$config);

$sqlite_dbpath = $config["sqlite_dbpath"];
$smarty->assign("Error", false);

if (!file_exists($sqlite_dbpath)) {
	$smarty->assign("Error", true);
	$smarty->assign("ErrorMessage", "Error: file $sqlite_dbpath not found!");
} else {
	$dbn = "sqlite:$sqlite_dbpath";
	try {
		$dbh = new PDO($dbn);
	}
	catch (PDOException $e) {
		$smarty->assign("Error", true);
		$smarty->assign("ErrorMessage", "Error: " . $e->getMessage(). "!");
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
	$db = NULL;
	$dbh = NULL;
}

//$smarty->debugging = true;
$smarty->display('index.tpl');
?>
