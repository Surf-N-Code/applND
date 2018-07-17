<?php
class Form extends Utils {
    protected $customer = "";
    protected $choosedTarif = "";
    protected $choosedTarifCounterPart = "";
    protected $newContractTerm = false;
    public $bError = "";
    public $sTemplate = "templates/form.php";
    public $class = __CLASS__;
    public $formData = [
	"router" => "",
	"sal" => "",
	"firstname" => "",
	"lastname" => '',
	"street" => '',
	"streetnumber" => "",
	"zip" => "",
	"city" => "",
	"mobile" => "",
	"email" => '',
	"birthdate_day" => '',
	"birthdate_month" => "",
	"birthdate_year" => "",
	"contractterm" => 0,
	"house_elevator" => 0,
	"isdn_ec_cash" => 0,
	"serverservice" => 0,
	"mnet_optin" => 0,
	"mnet_nl" => 0,
];
    protected $additionalFields = [
	"date_1_day" => "",
	"date_1_month" => "",
	"date_1_year" => "",
	"time-7-to-10" => 0,
	"time-10-to-13" => 0,
	"time-13-to-16" => 0,
	"time-16-to-19" => 0,
	"date_2_day" => '',
	"date_2_month" => "",
	"date_2_year" => '',
	"time-alt-7-to-10" => 0,
	"time-alt-10-to-13" => 0,
	"time-alt-13-to-16" => 0,
	"time-alt-16-to-19" => 0,
];
    protected $pdfData = [];
				
    public function render()
    {
$_SESSION["choosed"] = filter_input(INPUT_POST, "tarifId");
$this->customer = new Customer(); $this->customer->loadByLogin($_SESSION["kdnr"], $_SESSION["afnr"]);
$this->choosedTarif = $_SESSION["tarife"][$_SESSION["choosed"]];
if ($this->choosedTarif->getCounterpartIndex() && $this->choosedTarif->getContractTerm !== 0) {
	$this->choosedTarifCounterPart = new Tarif();
	$this->choosedTarifCounterPart->load($this->choosedTarif->getCounterpartIndex());
} else {$this->choosedTarifCounterPart = false;}
$this->tempVars["choosedTarif"] = $this->choosedTarif;
$this->tempVars["choosedCounterTarif"] = $this->choosedTarifCounterPart;
$this->tempVars["customer"] = $this->customer;
$routerGroup = new Routergroup();
$this->tempVars["router"] = $routerGroup->loadRouter($this->choosedTarif->getNameId(), $this->customer->getGFast());
// Prefills Form Data
if ($this->customer->getCampaignName() == "Normal") {
	$this->formData = array_merge($this->formData, $this->additionalFields);
}
$this->formData["router"] = new Router();
if($post){ if($this->formData["router"] !== 0){ $this->formData["router"]->load($this->formData["router"]);	} }
$this->formData["sal"] = ($post) ? $this->formData["sal"] : $this->customer->getSalutation();
$this->formData['firstname'] = ($post) ? $this->formData["firstname"] : $this->customer->getFirstName();
$this->formData["lastname"] = ($post) ? $this->formData["lastname"] : $this->customer->getLastName();
$this->formData['street'] = ($post) ? $this->formData["street"] : $this->customer->getStreet();
$this->formData["streetnumber"] = ($post) ? $this->formData["streetnumber"] : $this->customer->getStreetNumber() . $this->customer->getStreetNumberAddition();
$this->formData['zip'] = ($post) ? $this->formData["zip"] : $this->customer->getZip();
$this->formData["city"] = ($post) ? $this->formData["city"] : $this->customer->getCity();
$this->formData["mobile"] = ($post) ? $this->formData["mobile"] : $this->customer->getMobile();
$this->formData['email'] = ($post) ? $this->formData["email"] : $this->customer->getEMail();
$this->formData["comfort"] = ($post) ? $this->formData["comfort"] : $this->customer->getConnectionType();
return $this->getContents();
    }
    public function validate()
    {
$this->customer = new Customer();
$this->customer->loadByLogin($_SESSION["kdnr"], $_SESSION["afnr"]);
$this->choosedTarif = $_SESSION["tarife"][$_SESSION["choosed"]];
if ($this->choosedTarif->getCounterpartIndex() 
				&& $this->choosedTarif->getContractTerm !== 0) {
	$this->choosedTarifCounterPart = new Tarif();
	$this->choosedTarifCounterPart->load($this->choosedTarif->getCounterpartIndex());
				} else {
	$this->choosedTarifCounterPart = false;
				}
$this->tempVars['choosedTarif'] = $this->choosedTarif;
$this->tempVars["choosedCounterTarif"] = $this->choosedTarifCounterPart;
$this->tempVars["customer"] = $this->customer;
$routerGroup = new Routergroup();
$this->tempVars["router"] = $routerGroup->loadRouter($this->choosedTarif->getNameId(), $this->customer->getGFast());
$args = $this->getFilterArgs();
$prevalidated = filter_input_array(INPUT_POST, $args);
$nullvars = [];
foreach ($prevalidated as $key => $item) {
	if($item === false){ $this->bError[$key] = true;
	}elseif($item === null){$nullvars[$key] = true;}
}
        $validationData =  [
            "prevalidate" => $prevalidated,
            "nullvars" => $nullvars,
        ];
$this->formData = $validationData["prevalidate"];
if($this->bError !== ""){return $this->getContents();}
$_SESSION["nl"] = $this->formData["mnet_nl"];
if ($this->formData['contractterm']) {
	$tarif = $this->choosedTarifCounterPart;
} else {
	$tarif = $this->choosedTarif;
}
$tarif->setConnectionTrigger($this->formData["comfort"]);
if ($this->formData["date_2_day"] && $this->formData["date_2_month"] && $this->formData["date_2_year"]) {
	if (strlen($this->formData["date_2_day"]) < 2) {
		$this->formData["date_2_day"] = "0" . $this->formData["date_2_day"];
	}
	if (strlen($this->formData["date_2_month"]) < 2) {
		$this->formData['date_2_month'] = '0' . $this->formData["date_2_month"];
	}
	$date2 = $this->formData["date_2_day"] . "." . $this->formData["date_2_month"] . "." . $this->formData["date_2_year"];
} else {
	$date2 = "";
}
        	include "templates/PDFConfig.php";
        	$this->pdfData[0]["value"] = "0092";
        	$this->pdfData[1]["value"] = $this->customer->getCustomerId();
        	$this->pdfData[2]["value"] = $this->customer->getOrderNumber();
        	$this->pdfData[3]["value"] = $this->formData["sal"];
        	$this->pdfData[4]["value"] = $this->formData["firstname"];
        	$this->pdfData[5]['value'] = $this->formData["lastname"];
if (strlen($this->formData["birthdate_day"]) < 2) {
	$this->formData["birthdate_day"] = "0" . $this->formData["birthdate_day"];
}
if (strlen($this->formData["birthdate_month"]) < 2) {
	$this->formData['birthdate_month'] = "0" . $this->formData["birthdate_month"];
}
$this->pdfData[6]["value"] = $this->formData["birthdate_day"] . "." . $this->formData["birthdate_month"] . "." . $this->formData["birthdate_year"];
$this->pdfData[7]["value"] = $this->formData["email"];
$this->pdfData[8]["value"] = $this->customer->getStreet();
$this->pdfData[9]["value"] = $this->customer->getStreetNumber();
$this->pdfData[10]['value'] = $this->customer->getStreetNumberAddition();
$this->pdfData[11]['value'] = "";
$this->pdfData[12]["value"] = "";
$this->pdfData[13]["value"] = $this->customer->getZip();
$this->pdfData[14]["value"] = $this->customer->getCity();
$this->pdfData[15]["value"] = $tarif->getRealName();
$this->pdfData[16]["value"] = $tarif->getFormattedPrice() . " €";
$this->pdfData[17]["value"] = "-" . $tarif->getFormattedDiscount() . " €";
if ($tarif->getConnectionTrigger()) {$this->pdfData[18]["value"] = "0,00 €";
} else {$this->pdfData[18]["value"] = "Nein";}
$this->pdfData[19]["value"] = "0,00 €";
$this->pdfData[20]["value"] = "0,00 €";
$this->pdfData[21]["value"] = $tarif->getPerfs($this->formData["router"]);
$this->pdfData[22]["value"] = trim($tarif->getDisclaimer());
$this->pdfData[23]["value"] = ($this->formData["house_elevator"]) ? "Ja" : "Nein";
$this->pdfData[24]['value'] = ($this->formData["serverservice"]) ? "Ja" : "Nein";
$this->pdfData[25]['value'] = ($this->formData["isdn_ec_cash"]) ? 'Ja' : "Nein";
$this->pdfData[26]["value"] = $this->customer->getTechnologie();
$this->pdfData[27]["value"] = ($this->formData["router"]->getId()) ? $this->formData["router"]->getName() . ' ' . $this->formData['router']->getFormattedPrice() . ' €' : "Eigenes Endgerät";
$this->pdfData[28]["value"] = ($this->customer->getGFast()) ? "Ja" : 'Nein';
$this->pdfData[29]["value"] = "";
	if (strlen($this->formData["date_1_day"]) < 2) {
		$this->formData["date_1_day"] = "0" . $this->formData['date_1_day'];
	}
	if (strlen($this->formData["date_1_month"]) < 2) {
		$this->formData["date_1_month"] = "0" . $this->formData["date_1_month"];
	}
	$this->pdfData[30]["value"] = $this->formData["date_1_day"] . "." . $this->formData["date_1_month"] . "." . $this->formData["date_1_year"];
	$this->pdfData[31]["value"] = ($this->formData["time-7-to-10"]) ? "Ja" : "";
	$this->pdfData[32]["value"] = ($this->formData["time-10-to-13"]) ? "Ja" : "";
	$this->pdfData[33]["value"] = ($this->formData["time-13-to-16"]) ? "Ja" : "";
	$this->pdfData[34]["value"] = ($this->formData["time-16-to-19"]) ? "Ja" : "";
	$this->pdfData[35]["value"] = $date2;
	$this->pdfData[36]["value"] = ($this->formData["time-alt-7-to-10"]) ? "Ja" : "";
	$this->pdfData[37]["value"] = ($this->formData["time-alt-10-to-13"]) ? "Ja" : "";
	$this->pdfData[38]["value"] = ($this->formData["time-alt-13-to-16"]) ? "Ja" : "";
	$this->pdfData[39]["value"] = ($this->formData["time-alt-16-to-19"]) ? "Ja" : "";
	$this->pdfData[40]["value"] = $this->formData["mobile"];
$pdfClass = new Pdf($this->pdfData);
$pdf = $pdfClass->generatePdf();
$salesforce = new Salesforce($this->formData, $this->customer, $tarif, $pdf);
$response = $salesforce->sendData();
if (!$response) {
	$this->bError["emarsys"] = true;
	return $this->getContents();
}
$AMMailer = new Phpmail($this->formData, $this->customer, $tarif, $pdf);
$AMMailer->sendMail();
return $this->redirect("Thankyou");
}
    public function checkSchedule($nullvars)
    {
if ($nullvars["time-7-to-10"] && $nullvars["time-10-to-13"] && $nullvars["time-13-to-16"] && $nullvars["time-16-to-19"]) {$this->bError["date_1_time"] = true;} if (!isset($nullvars["date_2_day"])
|| !isset($nullvars["date_2_month"])
|| !isset($nullvars["date_2_year"])
|| !isset($nullvars["time-alt-7-to-10"])
|| !isset($nullvars["time-alt-10-to-13"])
|| !isset($nullvars["time-alt-13-to-16"])
|| !isset($nullvars["time-alt-16-to-19"])
) {
if ($nullvars["date_2_day"]) {$this->bError["date_2_day"] = true;}
if ($nullvars["date_2_month"]) {$this->bError["date_2_month"] = true;}
if ($nullvars["date_2_year"]) {$this->bError['date_2_year'] = true;}
if ($nullvars["time-alt-7-to-10"] && $nullvars["time-alt-10-to-13"] && $nullvars["time-alt-13-to-16"] && $nullvars["time-alt-16-to-19"]) {
$this->bError["date_2_time"] = true;
}
}
    }

protected function getFilterArgs()
{
$validateArgs = [
"tarifId" => FILTER_SANITIZE_STRING,
"router" => [
"filter" => FILTER_CALLBACK,
"options" => [
	new CustomFilters(),
	"filterRouter",
],
],
"sal" => [
"filter" => FILTER_CALLBACK,
"options" => [
	new CustomFilters(),
	"filterSalutation",
],
],
"firstname" => [
"filter" => FILTER_CALLBACK,
"options" => [
			new CustomFilters(),
	"filterEmpty",
],
],
"lastname" => [
"filter" => FILTER_CALLBACK,
"options" => [
	new CustomFilters(),
	"filterEmpty",
],
],
"street" => FILTER_SANITIZE_STRING,
"streetnumber" => 		FILTER_SANITIZE_STRING,
"zip" => FILTER_SANITIZE_STRING,
"city" => FILTER_SANITIZE_STRING,
"mobile" => [
"filter" => FILTER_CALLBACK,
"options" => [
	new CustomFilters(),
	"filterMobileNumber",
],
],
"email" => [
"filter" => FILTER_CALLBACK,
"options" => [
	new CustomFilters(),
	"filterRealEmail",
],
],
"birthdate_day" => [
"filter" => FILTER_CALLBACK,
"options" => [
	new CustomFilters(["min" => 1, "max" => 31]),
			"filterNummericRange",
],
],
"birthdate_month" => [
"filter" => FILTER_CALLBACK,
"options" => [
		new CustomFilters(["min" => 1, "max" => 31]),
"filterNummericRange",
],
],
"birthdate_year" => [
"filter" => FILTER_CALLBACK,
"options" => [
						new CustomFilters(["length" => 4]),
		"filterNummericLength",
],
],
"contractterm" => [
"filter" => FILTER_VALIDATE_BOOLEAN,
],
"comfort" => [
"filter" => FILTER_VALIDATE_BOOLEAN,
],
"house_elevator" => FILTER_SANITIZE_STRING,
"isdn_ec_cash" => FILTER_SANITIZE_STRING,
"serverservice" => FILTER_SANITIZE_STRING,
"mnet_optin" => ["filter" => FILTER_VALIDATE_BOOLEAN,],
"mnet_nl" => FILTER_SANITIZE_STRING,
"date_2_day" => FILTER_SANITIZE_STRING,
"date_2_month" => FILTER_SANITIZE_STRING,
"date_2_year" => FILTER_SANITIZE_STRING,
"time-alt-7-to-10" => FILTER_SANITIZE_STRING,
"time-alt-10-to-13" => FILTER_SANITIZE_STRING,
"time-alt-13-to-16" => FILTER_SANITIZE_STRING,
"time-alt-16-to-19" => FILTER_SANITIZE_STRING,
];
if (filter_input(INPUT_POST, "router") !== 0) {
$validateArgs["date_1_day"] = [
"filter" => FILTER_CALLBACK,
"options" => [new CustomFilters(["min" => 1, "max" => 31]),"filterNummericRange",
],
];
$validateArgs["date_1_month"] = [
"filter" => FILTER_CALLBACK,
"options" => [
	new CustomFilters(["min" => 1, "max" => 12]),
	"filterNummericRange",
],
];
$validateArgs["date_1_year"] = ["filter" => FILTER_CALLBACK,"options" => [new CustomFilters(["length" => 4]),"filterNummericLength",],];
$validateArgs["time-7-to-10"] = ["filter" => FILTER_VALIDATE_BOOLEAN,];
$validateArgs["time-10-to-13"] = ["filter" => FILTER_VALIDATE_BOOLEAN,];
$validateArgs["time-13-to-16"] = ["filter" => FILTER_VALIDATE_BOOLEAN,];
$validateArgs["time-16-to-19"] = ["filter" => FILTER_VALIDATE_BOOLEAN,];
} else {
$validateArgs["date_1_day"] = FILTER_SANITIZE_STRING;
$validateArgs["date_1_month"] = FILTER_SANITIZE_STRING;
$validateArgs["date_1_year"] = FILTER_SANITIZE_STRING;
$validateArgs["time-7-to-10"] = FILTER_SANITIZE_STRING;
$validateArgs["time-10-to-13"] = FILTER_SANITIZE_STRING;
$validateArgs["time-13-to-16"] = FILTER_SANITIZE_STRING;
$validateArgs["time-16-to-19"] = FILTER_SANITIZE_STRING;
}
return $validateArgs;
}
}