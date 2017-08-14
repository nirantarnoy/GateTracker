<?php

use yii\db\Migration;

class m170716_042148_add_trans_type_to_journal_table extends Migration
{
    public function safeUp()
    {
      $this->addColumn('journal','trans_type',$this->integer()->after('trans_date'));
    }

    public function safeDown()
    {
      $this->dropColumn('journal','trans_type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170716_042148_add_trans_type_to_journal_table cannot be reverted.\n";

        return false;
    }
    */
}
