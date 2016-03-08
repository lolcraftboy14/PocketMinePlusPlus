<?php

/*                                                                             __
 *                                                                           _|  |_
 *  ____            _        _   __  __ _                  __  __ ____      |_    _|
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \    __ |__|  
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) | _|  |_  
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/ |_    _|
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|      |__|   
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine++ Team
 * @link http://pm-plus-plus.tk/
*/

namespace pocketmine\network\protocol;

class PlayerListPacket extends DataPacket
{
    const NETWORK_ID = Info::PLAYER_LIST_PACKET;

    const TYPE_ADD = 0;
    const TYPE_REMOVE = 1;

    //REMOVE: UUID, ADD: UUID, entity id, name, isSlim, isTansparent, skin oldclient, skinname
    /** @var array[] */
    public $entries = [];
    public $type;

    public function clean()
    {
        $this->entries = [];
        return parent::clean();
    }

    public function decode()
    {

    }

    public function encode()
    {
        $this->reset();
        $this->putByte($this->type);
        $this->putInt(count($this->entries));
        foreach ($this->entries as $d) {
            if ($this->type === self::TYPE_ADD) {
                $this->putUUID($d[0]);
                $this->putLong($d[1]);
                $this->putString($d[2]);
                if ($d[6]) {
                    $this->putByte($d[3] ? 1 : 0);
                    $this->putByte($d[4] ? 1 : 0);
                } else {
                    $this->putString($d[7]);
                }
                $this->putString($d[5]);
            } else {
                $this->putUUID($d[0]);
            }
        }
    }

}