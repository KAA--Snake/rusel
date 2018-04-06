<?php

use yii\db\Migration;

/**
 * Handles the creation of table `offers`.
 */
class m180406_153656_create_offers_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('offers', [
            'id' => $this->primaryKey(),

            'full_text' => $this->text(),
            'preview_text' => $this->text(),
            'url' => $this->string(),

            'name' => $this->string(),

            'property_ids' => $this->text(),
            'product_ids' => $this->text(),

            'sort' => $this->integer(),

            'big_img_src' => $this->string(),
            'small_img_src' => $this->string(),

            'big_img_width' => $this->integer(),
            'big_img_height' => $this->integer(),

            'small_img_width' => $this->integer(),
            'small_img_height' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('offers');
    }
}
