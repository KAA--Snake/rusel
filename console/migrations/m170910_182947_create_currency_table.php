<?php

use yii\db\Migration;

/**
 * Handles the creation of table `currency`.
 */
class m170910_182947_create_currency_table extends Migration
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
        $this->createTable('currency', [
            'id' => $this->primaryKey(),
            'currency_id' => $this->integer()->notNull()->unsigned(),
            'course_to_rub' => $this->float(2)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('currency');
    }
}
