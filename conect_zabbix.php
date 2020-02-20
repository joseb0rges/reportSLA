<?php

require_once 'lib/ZabbixApi.class.php';
use ZabbixApi\ZabbixApi;

try

{
	// connect to Zabbix API

	$api = new ZabbixApi('http://172.20.3.23/zabbix/api_jsonrpc.php', 'jose.borges@sefaz.ma.gov.br', 'borges@123');


}
catch(Exception $e)
{

	echo $e->getMessage();
}


?>
