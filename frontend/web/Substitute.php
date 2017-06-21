<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 31.05.2017
 * Time: 22:18
 */

namespace app;


use yii\base\Exception;

class Substitute
{
    protected $url;

    protected $result;
    protected $replacedText;

    public function __construct($url){
        $this->url = $url;
        $this->replacedText = '';
    }

    public function setUrl($url){
        $this->url = $url;
    }

    public function setReplacedText($replacedText){
        $this->replacedText = $replacedText;
    }

    public function getReplacedText(){
        return $this->replacedText;
    }

    private function catchData(){

        try{

            $options = array(
                CURLOPT_URL => $this->url,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_RETURNTRANSFER => true
            );
            $ch = curl_init();
            curl_setopt_array($ch, $options);

            $this->result = curl_exec($ch);
        }catch (Exception $e){
            $this->result = '';
        }

    }

    public function setArrSubst($substs){
        $this->catchData();

        static::recSubst($this, $this->result, $substs);
    }

    public function setTwoSubst($first, $second){
        $this->catchData();

        $boths = [$first => $second];

        static::recSubst($this, $this->result, $boths);
    }


    /**
     * удаляет зацикливающие ключи
     * @param $substs
     * @return mixed
     */
    public static function clearInfinite($substs){
        $flipped = array_flip($substs);
        foreach($substs as $k=>$v){
            if(isset($flipped[$k])){
                if($flipped[$k] == $v) {
                    unset($substs[$k]);
                }
            }
        }
        return $substs;
    }


    /**
     * рекурсивный обход.
     *
     * по сути еркурсия тут не нужна, т.к. достаточно метода в строке #103....
     * @param $context
     * @param $text
     * @param $substs
     * @return bool
     */
    public static function recSubst($context, $text, $substs){

        $substs = static::clearInfinite($substs);

        $context->setReplacedText(str_replace(array_keys($substs), $substs, $text));

        if(strcmp($text,$context->getReplacedText()) !== 0){
            static::recSubst($context, $context->getReplacedText(), $substs);
        }else{
            return false;
        }

    }

    public function getResult(){
        return $this->replacedText;
    }


}

//в браузере открыть код в отладчике, а не саму страницу, т.к. замена тегов
$subst = new Substitute('http://google.ru');


$arrSubsts = [
    #'H2' => 'H1',  //---> рекурсия тут
    'BODY' => 'MODY',
    'H1' => 'H2',
];


$subst->setArrSubst($arrSubsts);
echo $subst->getResult();

echo '<br />';
echo '<br />';
echo '<hr />';


$subst->setTwoSubst('TITLE' , 'HIHLE');
echo $subst->getResult();


