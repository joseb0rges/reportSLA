<?php

require_once 'lib/ZabbixApi.class.php';
use ZabbixApi\ZabbixApi;

try

{
	// connect to Zabbix API

	$api = new ZabbixApi('http://url_server/zabbix/api_jsonrpc.php', 'usernae', 'password');

}
catch(Exception $e)
{

	echo $e->getMessage();
}


?>
