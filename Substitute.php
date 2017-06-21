<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 31.05.2017
 * Time: 22:18
 */

namespace app;


class Substitute
{
    protected $url;

    public function __construct($url){
        $this->url = $url;
    }

    public function setUrl($url){
        $this->url = $url;
    }


    public function setArrSubst($substs){
        $this->getData();
    }

    public function setTwoSubst($first, $second){
        $this->getData();
    }


    private function getData(){

        $params =['name'=>'John', 'surname'=>'Doe', 'age'=>36];
        $options = array(
            CURLOPT_URL => $this->url,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10
        );
        $ch = curl_init();
        curl_setopt_array($ch, $options);

        $responce =  json_decode(curl_exec($adb_handle),true);

        echo "Responce from DB: \n";
        print_r($responce);

    }
}


$subst = new Substitute('http://mail.ru');

$subst->setArrSubst();
