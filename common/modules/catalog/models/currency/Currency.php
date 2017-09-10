<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 05.09.2017
 * Time: 18:29
 */

namespace common\modules\catalog\models\currency;


class Currency extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'public.currency';
    }


    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return \Yii::$app->get('db_postg');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['currency_id', 'course_to_rub'], 'required'],
            [['currency_id', ], 'integer'],
            //[['course_to_rub', ], 'integer|float'],
        ];
    }

    public function attributes(){
        return [
            'id',
            'currency_id',
            'course_to_rub',

        ];
    }


    /**
     * получает валюты с центробанка на текущий день
     * @return array
     */
    public static function updateCurrencies(){
        $file = @simplexml_load_file("http://www.cbr.ru/scripts/XML_daily.asp?date_req=".date("d/m/Y"));

        foreach ($file AS $el){

            $selfCurrency = static::find()->andWhere(['currency_id' => intval($el->NumCode)])->one();

            if(!$selfCurrency){
                $selfCurrency = new static();
            }
            $price = str_replace(',','.',$el->Value);

            $attr= [
                'currency_id' => intval($el->NumCode),
                'course_to_rub' => floatval($price),
            ];
            $selfCurrency->setAttributes($attr);

            //print_r($attr);
            $trn = \Yii::$app->db_postg->beginTransaction();
            try{
                if ($selfCurrency->save(true)) {

                    $trn->commit();

                }

            }catch(Exception $e){
                $trn->rollback();

                /*$error = '<br />' . $e->getMessage() . '<br />';
                Yii::$app->session->setFlash('error_'.intval($group->id), $error);*/
            }

        }
        return true;

    }


    /**
     * Отдает цену умноженную на текущий курс, в зависимости от выбранного ИД валюты
     *
     * @TODO СДЕЛАТЬ КЕШИРОВАНИЕ !!!
     *
     * @param bool|false $currencyId
     * @param $price
     * @param bool|false $precision
     * @return float|int|mixed
     */
    public static function getPriceForCurrency($currencyId=false, $price, $precision=false){

        if(!$currencyId) return (1 * $price);


        $currency = static::find()->where([
            'currency_id' => $currencyId
        ])->one();

        if($precision){
            return floor($currency->course_to_rub * $price);
        }

        return $currency->course_to_rub * $price;

    }

    public static function showCurrencies(){
        $model = static::find()->where([])->asArray()->all();

        print_r($model);
    }

    public static function getCurrencyName($currencyCode){

        return 'p';
    }

}