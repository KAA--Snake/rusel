<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news`.
 */
class m180327_135208_create_news_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),

            'full_text' => $this->text(),
            'preview_text' => $this->text(),

            'url' => $this->string(),

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
        $this->dropTable('news');
    }
}
