<?php

use yii\db\Migration;

/**
 * Handles the creation of table `manufacturer`.
 */
class m171031_072348_create_manufacturer_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('manufacturer', [
            'id' => $this->primaryKey(),
            'm_id' => $this->integer()->notNull()->unsigned()->unique(),
            'm_name' => $this->string(),
        ]);

        //create m_id iindex
        $this->createIndex(
            'idx-unique-m_id',
            'manufacturer',
            'm_id'
        );


    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops index for column `m_id`
        $this->dropIndex(
            'idx-unique-m_id',
            'manufacturer'
        );

        $this->dropTable('manufacturer');
    }
}
