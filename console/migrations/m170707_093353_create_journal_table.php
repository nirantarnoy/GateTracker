<?php

use yii\db\Migration;

/**
 * Handles the creation of table `journal`.
 */
class m170707_093353_create_journal_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('journal', [
            'id' => $this->primaryKey(),
            'journal_no' => $this->string(),
            'trans_date' => $this->integer(),
            'car_type' => $this->integer(),
            'car_license_no' => $this->string(),
            'status' => $this->integer(),
            'status_reason' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('journal');
    }
}
