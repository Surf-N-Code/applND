<?php
$ignoreAllSeason = false;
// check data and normalize

//a Value of 0 will be set to false in the end. 3rd if should probably be switched with first if.
// Season values 0.75<x<1.33 are not handled
foreach ($seasonFactors as $key => $seasonValue ) {
	if ( $seasonValue == 0 ) $ignoreAllSeason = true; // dont use seasonAdaption not enough data
    if ( $seasonValue >= 1.33 ) $ignoreAllSeason = false;
    if ( $seasonValue <= 0.75 ) $ignoreAllSeason = false;
}
if ( $ignoreAllSeason ) {
    echo `Seasondata not usable.`;
    //PHP will attempt to execute the contents as a shell command. Should use single
    //or double quotes
}
?>
