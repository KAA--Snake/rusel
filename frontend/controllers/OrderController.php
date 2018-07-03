<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.10.17
 * Time: 13:07
 */

namespace frontend\controllers;


use common\models\erp\Export;
use common\modules\catalog\models\Order;
use common\modules\catalog\models\rabbit\Order\RabbitOrder;
use yii\web\Controller;
use Yii;

class OrderController extends Controller
{


    var $layout = '@common/modules/catalog/views/layouts/catalogDetail';


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [


            'pagination' => [
                'class' => 'common\modules\catalog\behaviours\Pagination_beh',
                'maxSizeCnt' => \Yii::$app->getModule('catalog')->params['max_products_cnt']

            ],
            'manufacturers' => [
	            'class' => 'common\modules\catalog\behaviours\Manufacturers_beh',
	            /*'in_attribute' => 'name',
				'out_attribute' => 'slug',
				'translit' => true*/
            ],
        ];
    }



    public function actionDone(){
        return $this->render('@common/modules/catalog/views/order/orderDone', []);
    }

    /**
     *  1. Принимает форму при оформлении заказа.
     *  2. Если все ок, создает заказ то выдает ОК и номер заказа для редиректа на страницу подтверждения
     *  3. Если все НЕ ок, то выдает ошибки и редиректит обратно на форму заказа.
     */
    public function actionSend(){

        //Yii::$app->session->addFlash('something', print_r(Yii::$app->request->post()['Order'], true));

        $form_model = new Order();

        if($form_model->load(Yii::$app->request->post())){
            $formData = Yii::$app->request->post()['Order'];

            /** сохраняем сессию для формы */
            Yii::$app->session->set('cartFields', json_encode($formData));
            //\Yii::$app->pr->print_r2($formData);

            if(!$form_model->validate()){

                foreach ($form_model->getErrors() as $key => $value) {
                    //echo $key.': '.$value[0];
                    Yii::$app->session->addFlash('error', $key.': '.$value[0]);
                }

                //Yii::$app->session->set('cartFields', json_encode(Yii::$app->request->post()));
                //return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
                return $this->redirect('/cart/');
            }

            /**
             * сначала сохраняем заказ в бд
             * при этом автоматически в заказ подтянутся данные по ценам при сохранении
             */
            $saveResult = $form_model->save();

            //$forRabbitSendData = $form_model->getAttributes();

            //присоединяем ее к заказу
            $forRabbitSendData= [];

            //это тут передается для того, чтобы после экспорта обновить данные в заказе
            $forRabbitSendData = $form_model->getAttributes();
            //echo 'Из формы приходят следующие данные:';
            //\Yii::$app->pr->print_r2($forRabbitSendData);

            //получаем строку для ЕРП вида ID|количество|STORAGE|цена|код_валюты&ID|количество|STORAGE|цена|код_валюты& etc...
            $forRabbitSendData['dataForErp'] = $form_model->getDataForErp();

            /** потом отправляем в очередь на отправку заказа в ЕРП! @TODO включить обратно !!!*/
            //$rabbitModel = new RabbitOrder('order_queue');
            //$rabbitModel->sendDataToRabbit(json_encode($forRabbitSendData));

            //ТЕСТОВАЯ ОТПРАВКА НАПРЯМУЮ БЕЗ РАББИТА !
            $export = new Export();
            $res = $export->exportOrder(json_encode($forRabbitSendData));

            if($res && $saveResult){
	            /** отправляем письмо о новом заказе */
	            $form_model->sendMail();

	            Yii::$app->session->addFlash('order_id', $form_model->id);
	            return $this->redirect('/order/done/');
            }else{

	            Yii::$app->session->addFlash('error', 'Не удалось отправить заказ ! Свяжитесь с администратором сайта.');
	            return $this->redirect('/cart/');

            }

            //$file = file_get_contents('/webapp/RabbitProcess');

        }

    }
}