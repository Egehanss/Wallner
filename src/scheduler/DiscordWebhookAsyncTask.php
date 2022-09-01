<?php


declare(strict_types=1);

namespace pocketmine\scheduler;

use pocketmine\scheduler\AsyncTask;
use pocketmine\player\Player;
use pocketmine\Server;

class DiscordWebhookAsyncTask extends AsyncTask{
  
  private $webhook;
  private $data;

   public function __construct($webhook, $data) {
        $this->webhook = $webhook;
        $this->data = $data;
    }
    
  public function onRun() : void
    {

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $this->webhook);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(unserialize($this->data)));
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_exec($curl);
    curl_close($curl);
   
    }
  }