<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m171122_132926_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'answer_var' => $this->integer(),
            'fio' => $this->string(),
            'tel' => $this->string(),
            'email' => $this->string(),
            'org' => $this->string(),
            'delivery_var' => $this->string(),
            'delivery_city' => $this->string(),
            'delivery_contact_person' => $this->string(),
            'delivery_tel' => $this->string(),
            'delivery_address' => $this->string(),
            'order_comment' => $this->string(),

            'products' => $this->string(),

            'source' => $this->string(),
            'date' => $this->date(),
            'time' => $this->time(),
            'client_id' => $this->integer(),
            'client_ip' => $this->string(),
            'client_geolocation' => $this->string(),
            'client_shortname' => $this->string(),
            'client_fullname' => $this->string(),

            'client_inn' => $this->string(),
            'client_kpp' => $this->string(),
            'delivery_city_index' => $this->integer(),

            'is_sent_to_erp' => $this->integer(),
        ]);

        //create date index
        $this->createIndex(
            'idx-date',
            'order',
            'date'
        );

        //create delivery_city index
        $this->createIndex(
            'idx-delivery_city',
            'order',
            'delivery_city'
        );

        //create org index
        $this->createIndex(
            'idx-org',
            'order',
            'org'
        );

        //create is_sent_to_erp index
        $this->createIndex(
            'idx-is_sent_to_erp',
            'order',
            'is_sent_to_erp'
        );

    }

    /**
     * @inheritdoc
     */
    public function down()
    {


        // drops index for column `date`
        $this->dropIndex(
            'idx-date',
            'order'
        );

        // drops index for column `delivery_city`
        $this->dropIndex(
            'idx-delivery_city',
            'order'
        );

        // drops index for column `org`
        $this->dropIndex(
            'idx-org',
            'order'
        );

        // drops index for column `is_sent_to_erp`
        $this->dropIndex(
            'idx-is_sent_to_erp',
            'order'
        );

        $this->dropTable('order');
    }
}


