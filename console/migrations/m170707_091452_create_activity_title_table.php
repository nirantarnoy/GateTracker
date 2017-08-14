<?php

use yii\db\Migration;

/**
 * Handles the creation of table `activity_title`.
 */
class m170707_091452_create_activity_title_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('activity_title', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'description' => $this->string(),
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
        $this->dropTable('activity_title');
    }
}
