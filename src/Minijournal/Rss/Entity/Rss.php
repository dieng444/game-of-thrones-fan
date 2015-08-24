<?php
namespace Minijournal\Rss\Entity;

use Slyboot\Main\Entity\MainEntity;

class Rss extends MainEntity
{
    public static function getRss()
    {
        $url ="http://www.lemonde.fr/m-actu/rss_full.xml";
        $proxy = "http://proxy.unicaen.fr:3128";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_PROXY, $proxy);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_ENCODING, " ");
        $data = curl_exec($curl);
      
        return $data;
     
    }
}
