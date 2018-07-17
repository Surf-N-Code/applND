<?php
$ignoreAllSeason = false;
// check data and normalize
foreach ($seasonFactors as $key => $seasonValue ) {
	if ( $seasonValue == 0 ) $ignoreAllSeason = true; // dont use seasonAdaption not enough data
    if ( $seasonValue >= 1.33 ) $ignoreAllSeason = false;
    if ( $seasonValue <= 0.75 ) $ignoreAllSeason = false;
}
if ( $ignoreAllSeason ) {
    echo `Seasondata not usable.`;
}
?>
