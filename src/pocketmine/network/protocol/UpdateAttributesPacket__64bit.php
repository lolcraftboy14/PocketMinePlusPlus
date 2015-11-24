<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____  
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \ 
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/ 
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_| 
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 * 
 *
*/

namespace pocketmine\network\protocol;

use pocketmine\utils\Binary;











use pocketmine\entity\Attribute;

class UpdateAttributesPacket extends DataPacket{
	const NETWORK_ID = Info::UPDATE_ATTRIBUTES_PACKET;


	public $entityId;
	/** @var Attribute[] */
	public $entries = [];

	public function decode(){

	}

	public function encode(){
		$this->buffer = \chr(self::NETWORK_ID); $this->offset = 0;;

		$this->buffer .= \pack("NN", $this->entityId >> 32, $this->entityId & 0xFFFFFFFF);

		$this->buffer .= \pack("n", \count($this->entries));

		foreach($this->entries as $entry){
			$this->buffer .= (\ENDIANNESS === 0 ? \pack("f", $entry->getMinValue()) : \strrev(\pack("f", $entry->getMinValue())));
			$this->buffer .= (\ENDIANNESS === 0 ? \pack("f", $entry->getMaxValue()) : \strrev(\pack("f", $entry->getMaxValue())));
			$this->buffer .= (\ENDIANNESS === 0 ? \pack("f", $entry->getValue()) : \strrev(\pack("f", $entry->getValue())));
			$this->putString($entry->getName());
		}
	}

}