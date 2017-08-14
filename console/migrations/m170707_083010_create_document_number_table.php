<?php

use yii\db\Migration;

/**
 * Handles the creation of table `document_number`.
 */
class m170707_083010_create_document_number_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('document_number', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'description' => $this->string(),
            'min_number' => $this->integer(),
            'current_number' => $this->integer(),
            'max_number' => $this->integer(),
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
        $this->dropTable('document_number');
    }
}
