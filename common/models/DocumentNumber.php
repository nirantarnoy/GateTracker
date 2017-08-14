<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "document_number".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $min_number
 * @property int $current_number
 * @property int $max_number
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class DocumentNumber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'document_number';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['min_number', 'current_number', 'max_number', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'min_number' => 'Min Number',
            'current_number' => 'Current Number',
            'max_number' => 'Max Number',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
