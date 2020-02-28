<?php

require_once 'lib/ZabbixApi.class.php';
use ZabbixApi\ZabbixApi;

try

{
	// connect to Zabbix API

	$api = new ZabbixApi('http://url_servidor/zabbix/api_jsonrpc.php', 'usuario', 'senha');

}
catch(Exception $e)
{

	echo $e->getMessage();
}


?>
