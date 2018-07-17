<?php
// get all agencies with its clients
$result = $DB->query("SELECT agenturID, kundenID
                      FROM `Client`
                      GROUP BY `agenturID`, kundenID
                      HAVING COUNT( 1 ) > 0
                      ORDER BY agenturID DESC ");

//HAVING has no effect here since it always evaluates to true. Usually having acts as an additional filter after group by
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
//Code in if will only be executed if there are consecutive datasets within the db that have the same agencyID
//No hours and minutes in date. Log files could be overridden.
?>
