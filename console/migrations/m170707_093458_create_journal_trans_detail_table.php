<?php

use yii\db\Migration;

/**
 * Handles the creation of table `journal_trans_detail`.
 */
class m170707_093458_create_journal_trans_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('journal_trans_detail', [
            'id' => $this->primaryKey(),
            'journal_trans_id' => $this->integer(),
            'status' => $this->integer(),
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
        $this->dropTable('journal_trans_detail');
    }
}
