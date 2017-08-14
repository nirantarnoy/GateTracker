<?php

use yii\db\Migration;

class m170715_060915_add_column_to_user_table extends Migration
{
    public function safeUp()
    {
      // $this->addColumn('user','group_id',$this->integer());
      // $this->addColumn('user','role_id',$this->integer());
    }

    public function safeDown()
    {
      // $this->dropColumn('user','group_id');
      // $this->dropColumn('user','role_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170715_060915_add_column_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
