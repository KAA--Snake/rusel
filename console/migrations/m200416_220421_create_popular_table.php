<?php

use yii\db\Migration;

/**
 * Handles the creation of table `popular`.
 */
class m200416_220421_create_popular_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('popular', [
            'id' => $this->primaryKey(),

            'name' => $this->string(),

            'url' => $this->string(),

            'date' => $this->date(),

            'sort' => $this->integer(),

            'target' => $this->string(),

            'html_width' => $this->integer(),

            'html_height' => $this->integer(),



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
        $this->dropTable('popular');
    }
}
