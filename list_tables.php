<?php
require 'vendor/autoload.php';
require 'tests/bootstrap.php';
use Cake\Datasource\ConnectionManager;
$db = ConnectionManager::get('default');
$tables = $db->getSchemaCollection()->listTables();
foreach ($tables as $table) {
    echo $table . "\n";
}
