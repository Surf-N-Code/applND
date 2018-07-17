<?php
    $reader = $this->getReader($filename);
	$this->data = array();
	$xlr = $reader->load($filename);

	// store meta information and the sheet handle!
	$this->sheet         = $xlr->getSheet(0);
	$this->highestRow    = $this->sheet->getHighestRow();
	$this->highestColumn = $this->sheet->getHighestColumn();

	// skip first row if keys are contained in file
	$i = self::KEYS_CONTAINED ? 2 : 1;
	switch($type) {
	case self->DELIVERY_STATUS:
		$classname = 'DeliveryStatus';
		$tablename = self->DELIVERY_STATUS_TABLE;
		$fields = $this->fields[self->DELIVERY_STATUS];
		break;
	case self->CONTACT_LEVEL:
		$class = 'ContactLevel';
		$tablename = self->CONTACT_LEVEL_TABLE;
		$fields = $this->fields[self->CONTACT_LEVEL];
		break;
	case self->FORMATS:
		$classname = 'Format';
		$tablename = self->FORMAT_TABLE;
		break;
	}
	for (; $i<=$this->highestRow; $i++) {
		$dataContainer = new $classname();
		$data = array();
		for ($j=0; $j<count($fields); $j+) {
			$key = $fields[$j+1];
			$charIndex = chr(97 + $j);
			$index = $charIndex . $i;
			$value = $this->getCellValue($index);
			$data[$j] = $value;
		}
		$dataContainer->setData($data);
		$this->data[] = $dataContainer;
	}

	$result = $this->storeData($type);
	return $result;