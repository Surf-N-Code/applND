<?php
    $reader = $this->getReader($filename);
	$this->data = array();
	$xlr = $reader->load($filename);

	// store meta information and the sheet handle!
	$this->sheet         = $xlr->getSheet(0);
	$this->highestRow    = $this->sheet->getHighestRow();
	$this->highestColumn = $this->sheet->getHighestColumn();

	// skip first row if keys are contained in file

    //maybe consider using $this instead of self
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
	//No switch default or final
	for (; $i<=$this->highestRow; $i++) {
		$dataContainer = new $classname();
		$data = array();
		for ($j=0; $j<count($fields); $j+) {
		    //$j++
			$key = $fields[$j+1];
			//$key is not used again
//			$charIndex = chr(97 + $j);
//			$index = $charIndex . $i;
//			$value = $this->getCellValue($index);
//			$data[$j] = $value; //Could be simplified to one line
            $data[$j] = $this->getCellValue(chr(97 + $j) . $i);
		}
//		$dataContainer->setData($data);
//		$this->data[] = $dataContainer; //Could be simplified to one line
        $this->data[] = $dataContainer->setData($data);
		unset($dataContainer); //Possibly better for memory usage
	}

	$result = $this->storeData($type);
	return $result;