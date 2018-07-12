<?php

use yii\db\Migration;

/**
 * Class m180712_190438_update_manufacturer
 */
class m180712_190438_update_manufacturer extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        /** @var \yii\db\Connection $db */
        //$this->db->createCommand()->alterColumn('manufacturer', 'm_group_ids', $this->string(5000));

        $this->dropTable('manufacturer');
        $this->createTable('manufacturer', [
            'id' => $this->primaryKey(),
            'm_id' => $this->integer()->notNull()->unsigned()->unique(),
            'm_name' => $this->string(),
            'm_text' => $this->string(),
            'm_group_ids' => $this->string(5000),
        ]);

        //create m_id iindex
        $this->createIndex(
            'idx-unique-m_id',
            'manufacturer',
            'm_id'
        );

        //create m_name index
        $this->createIndex(
            'idx-unique-m_name',
            'manufacturer',
            'm_name'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // drops index for column `m_id`
        $this->dropIndex(
            'idx-unique-m_id',
            'manufacturer'
        );

        // drops index for column `m_name`
        $this->dropIndex(
            'idx-unique-m_name',
            'manufacturer'
        );

        $this->dropTable('manufacturer');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180712_190438_update_manufacturer cannot be reverted.\n";

        return false;
    }
    */
}
