<?php

use yii\db\Migration;

class m170715_061932_add_column_to_user_table extends Migration
{
    public function safeUp()
    {
      $this->addColumn('user','fname',$this->string());
      $this->addColumn('user','lname',$this->string());
    }

    public function safeDown()
    {
      $this->dropColumn('user','fname');
      $this->dropColumn('user','lname');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170715_061932_add_column_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
