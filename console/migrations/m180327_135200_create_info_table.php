<?php

use yii\db\Migration;

/**
 * Handles the creation of table `info`.
 */
class m180327_135200_create_info_table extends Migration
{

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('info', [
            'id' => $this->primaryKey(),

            'big_img_src' => $this->string(),
            'small_img_src' => $this->string(),

            'big_img_width' => $this->integer(),
            'big_img_height' => $this->integer(),

            'small_img_width' => $this->integer(),
            'small_img_height' => $this->integer(),

            'sort' => $this->integer(),

            'text' => $this->text(),

            'url' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('info');
    }
}
