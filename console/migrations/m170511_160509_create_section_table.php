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
            'depth_level' => $this->integer()->notNull()->unsigned(),
            'parent_id' => $this->integer()->unsigned()->unique(),
            'code' => $this->string()->unique(),
            'name' => $this->string(),
            'preview_text' => $this->text(),
            'detail_text' => $this->text(),
            'picture' => $this->string(),
        ]);


        $this->createIndex(
            'idx-section-code',
            'section',
            'code',
            true //unique
        );

        $this->createIndex(
            'idx-section-parent_id',
            'section',
            'parent_id',
            true //unique
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
        // drops index for column `code`
        $this->dropIndex(
            'idx-section-code',
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
