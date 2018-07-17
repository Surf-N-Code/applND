<?php
// items have productOffers or offers. Save them in one returnArray
$isProductOffer = false;

foreach ($items as $key => $value) {
    if ( sizeof($value['productOffers']) > 0 ) { //Common practice is to use count instead of sizeof
        $isProductOffer = true;
    }
    // save the product offer if element has one, else save normal offer
    if ( $isProductOffer ) {
        $returnArray[] = $value['productOffers'];
    } else {
        $returnArray[] = $value['offers'];
    }

    //shorter code
    $returnArray[] = (count($value['productOffers']) > 0 ) ? $value['productOffers'] : $value['offers'];
}
?>
