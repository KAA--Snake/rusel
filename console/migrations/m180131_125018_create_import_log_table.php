<?php

use yii\db\Migration;

/**
 * Handles the creation of table `import_log`.
 */
class m180131_125018_create_import_log_table extends Migration
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
        $this->createTable('import_log', [
            'id' => $this->primaryKey(),
            'import_status' => $this->integer()->notNull(),
            'imported_cnt' => $this->integer(),
            'import_file_name' => $this->string()->notNull(),
            'start_date' => $this->dateTime(),
            'end_date' => $this->dateTime(),
            'errors_log' => $this->text(),

        ]);



        $this->createIndex(
            'idx-start_date',
            'import_log',
            'start_date'
        );

        $this->createIndex(
            'idx-import_file_name',
            'import_log',
            'import_file_name'
        );




    }

    /**
     * @inheritdoc
     */
    public function down()
    {


        $this->dropIndex(
            'idx-start_date',
            'import_log'
        );

        $this->dropIndex(
            'idx-import_file_name',
            'import_log'
        );


        $this->dropTable('import_log');
    }
}
