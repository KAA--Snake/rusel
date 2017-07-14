<?php

use yii\db\Migration;


/**
 * Handles the creation of table `section`.
 */
class m170511_160509_create_section_table extends Migration
{
    public function init(){
        $this->db = 'db_postg';
        parent::init();
    }


    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('section', [
            'id' => $this->primaryKey(),
            'unique_id' => $this->integer()->notNull()->unsigned()->unique(),
            'depth_level' => $this->integer()->notNull()->unsigned(),
            'parent_id' => $this->integer(),
            'code' => $this->string(),
            'url' => $this->string(),
            'name' => $this->string(),
            'preview_text' => $this->text(),
            'detail_text' => $this->text(),
            'picture' => $this->string(),
            'menu_offlink' => $this->string(),
            'redirect_url' => $this->string(),
            'sort' => $this->integer(),

            /** ниже поле нужные для behaviourTree */
            'lft' => $this->integer(),
            'rgt' => $this->integer(),

        ]);

        $this->createIndex(
            'idx-unique-lft',
            'section',
            'lft'
        );

        $this->createIndex(
            'idx-unique-rgt',
            'section',
            'rgt'
        );


        $this->createIndex(
            'idx-unique-id',
            'section',
            'unique_id'
        );

        $this->createIndex(
            'idx-section-code',
            'section',
            'code'
            //true //unique
        );

        $this->createIndex(
            'idx-section-url',
            'section',
            'url'
        );

        $this->createIndex(
            'idx-section-parent_id',
            'section',
            'parent_id'
        );

        $this->createIndex(
            'idx-section-depth_level',
            'section',
            'depth_level'
        );

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops index for column `lft`
        $this->dropIndex(
            'idx-unique-lft',
            'section'
        );

        // drops index for column `rgt`
        $this->dropIndex(
            'idx-unique-rgt',
            'section'
        );

        // drops index for column `unique_id`
        $this->dropIndex(
            'idx-unique-id',
            'section'
        );

        // drops index for column `code`
        $this->dropIndex(
            'idx-section-code',
            'section'
        );

        // drops index for column `url`
        $this->dropIndex(
            'idx-section-url',
            'section'
        );

        // drops index for column `parent_id`
        $this->dropIndex(
            'idx-section-parent_id',
            'section'
        );

        // drops index for column `depth_level`
        $this->dropIndex(
            'idx-section-depth_level',
            'section'
        );

        $this->dropTable('section');
    }
}
