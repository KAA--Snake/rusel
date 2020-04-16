<?php

use yii\db\Migration;

/**
 * Handles the creation of table `review`.
 */
class m200416_203521_create_review_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('review', [
            'id' => $this->primaryKey(),

            'full_text' => $this->text(),
            'preview_text' => $this->text(),
            'url' => $this->string(),

            'type' => $this->string(),

            'name' => $this->string(),

            'date' => $this->date(),

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
        $this->dropTable('review');
    }
}
