<?php

error_reporting(E_ALL);

class dmPDO extends PDO {
	const DATABASE = 'dataManager';
	const USER = 'compmanager';
	const PASS = 'C0mp3t1t10n!';

	public function __construct() {
		parent::__construct('mysql:host=localhost;dbname='.self::DATABASE.';charset=utf8', self::USER, self::PASS);
		$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	}
}

$db = new dmPDO();

// Ensure we've got all future scheduled content
$_GET['preview'] = '2020-01-01';

include('includes/common.constants.php');

// Get the year from the last 4 letters of the database name for the current page
$DMtable = 'competitionData' . substr($siteDetails['database'], -4);
// Get the table name for the current page/brand
$DMkeyField = $siteDetails['table'][$brand];

$data = array(
	'campaign' => $campaign,
	'url' => str_replace("http://win.","",$siteDetails['baseURL']),
	'brand' => $brand,
	'client' => $client['name'],
	'tableName' => $siteDetails['table'][$brand],
	'database' => $siteDetails['database'],
	'startDate' => $text['competition']['starts'],
	'endDate' => $text['competition']['ends']
);

$fields = implode("`,`",array_keys($data));
$tokens = implode(",:",array_keys($data));
$pairs = "";
foreach ($data as $key => $val) {
	$pairs .= '`'.$key.'`=:'.$key.',';
}
$fields = '`'.$fields.'`';
$tokens = ':'.$tokens;
$pairs = substr($pairs,0,-1);

// Try to select the row in the competitionData table that contains the table name for the current page
$q = $db->prepare('SELECT * FROM '.$DMtable.' WHERE `tableName`="'.$DMkeyField.'"');
$q->execute();
$result = $q->fetchAll();

if( !empty($result) ) { // If the row exists, update it
	$q = $db->prepare('UPDATE '.$DMtable.' SET '.$pairs.' WHERE `id`=' . $result[0]['id']);
	$q->execute($data);
} else { //If the row doesn't exist, insert it
	$q = $db->prepare('INSERT INTO '.$DMtable.' ('.$fields.') VALUES ('.$tokens.')');
	$q->execute($data);
}

if ($q->errorCode() != '00000') {
	print_r($q->errorInfo());
} else {
	echo '<h2>'.$DMtable.' table updated with the following data</h2>';
	echo '<pre>';
	print_r($data);
	echo '</pre>';
}

?>