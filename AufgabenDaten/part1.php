<?php
$data = new Client::getClientData();

// create daily log dir
if (!is_dir('/data/dacron_log/' . date('Y-m-d h-m') . '/')) {
    mkdir('/data/dacron_log/' . date('Y-m-d h-m') . '/');
}
// many rows come from DB here

/**/
//$data is overridden or respectively the client $data varialbe is not used
while ($data = $DB_MD->fetch_row($result)) {
    $parameters = array($data['belongsToClientID'], "standard", "false");
    $logpath = '/data/dacron_log/package/' . date('Y-m-d h-m') . '/' . $data['belongsToClientID'] . '_starter.log';
    $ChildProcess->addProcess('/data/dacron/dacron_packageController.php', $parameters, $logpath);
}