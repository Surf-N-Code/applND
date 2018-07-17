<?php
// get all agencies with its clients
$result = $DB->query("SELECT agenturID, kundenID
                      FROM `Client`
                      GROUP BY `agenturID`, kundenID
                      HAVING COUNT( 1 ) > 0
                      ORDER BY agenturID DESC ");

$agency = '';
while ($data = $DB->fetch_row($result)) {
    if($data['agencyID'] == $agency){
        $parameters = array("placement", $data['agencyID'], $data['clientID']);
        $logpath = "/data/plcmtStarter_{$data['clientID']}_" . date('Y-m-d') . ".log";
        $Process->executes("/data/main.Starter.php", $parameters, $logpath); // call shell with params
    }else{
        $agency = $data['agencyID'];
    }
}
?>
