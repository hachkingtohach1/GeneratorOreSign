<?php

/**
 * Copyright 2018-2020 DragoVN
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace hachkingtohach1\GeneratorOreSign;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\level\Position;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\tile\Sign;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\utils\Config;
use pocketmine\scheduler\Task;

use hachkingtohach1\GeneratorOreSign\GeneratorOreSign;

class GeneratorOreSign extends PluginBase implements Listener {	
	
	// static plugin
    public static $call;
	
	public function onEnable(){
        self::$call = $this;		
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getScheduler()->scheduleRepeatingTask(new class extends Task {			
		public function onRun(int $currentTick) {
			$time = 0;
            foreach (Server::getInstance()->getOnlinePlayers() as $player) {					
			    foreach ($player->getLevel()->getTiles() as $tile) {
					if($tile instanceof Sign) {
					    $text = $tile->getText();
						$pos = $tile->asVector3();
						// some things
					    $ore = ["§eGold", "§bDiamond", "§aEmerald"];
					    $signText = ["§bGenerator"];
						if($text[0] == "Generator") {
							if($text[1] == "Gold"){
							    $tile->setText($signText[0], $ore[0]);	            
							}
						    if($text[1] == "Diamond"){
							    $tile->setText($signText[0], $ore[1]);	            
							}
						    if($text[1] == "Emerald"){
							    $tile->setText($signText[0], $ore[2]);
							}
						}
						if($text[0] == $signText[0]) {
							if($text[1] == $ore[0]){
								$player->getLevel()->dropItem($pos->add(0.5, 0, 0.5), Item::get(Item::GOLD_INGOT), new Vector3());
							}
							if($text[1] == $ore[1]){
								$player->getLevel()->dropItem($pos->add(0.5, 0, 0.5), Item::get(Item::DIAMOND), new Vector3());
							}
							if($text[1] == $ore[2]){
								$player->getLevel()->dropItem($pos->add(0.5, 0, 0.5), Item::get(Item::EMERALD), new Vector3());
							}
						}
					}
				}								
			}
	}}, 250);}
}