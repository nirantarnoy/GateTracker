<?php

use yii\db\Migration;

/**
 * Handles the creation of table `journal_trans`.
 */
class m170707_093436_create_journal_trans_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('journal_trans', [
            'id' => $this->primaryKey(),
            'journal_id' => $this->integer(),
            'contact_name' => $this->string(),
            'position' => $this->string(),
            'company' => $this->string(),
            'contact_emp' => $this->string(),
            'contact_number' => $this->string(),
            'contact_detail' => $this->text(),
            'status' => $this->integer(),
            'document_ref' => $this->string(),
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
        $this->dropTable('journal_trans');
    }
}
