<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "journal_trans_detail".
 *
 * @property int $id
 * @property int $journal_trans_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class JournalTransDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'journal_trans_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['journal_trans_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by','product_id','quantity','price'], 'integer'],
            [['weight'],'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'journal_trans_id' => 'Journal Trans ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
