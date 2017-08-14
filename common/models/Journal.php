<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "journal".
 *
 * @property int $id
 * @property string $journal_no
 * @property int $trans_date
 * @property int $activity_id
 * @property int $car_type
 * @property string $car_license_no
 * @property int $status
 * @property string $status_reason
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Journal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'journal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_id'],'required'],
            [['activity_id', 'car_type', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by','car_state','in_date','out_date'], 'integer'],
            [['trans_date'],'safe'],
            [['status_reason'], 'string'],
            [['journal_no', 'car_license_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'journal_no' => 'เลขที่',
            'trans_date' => 'วันที่',
            'activity_id' => 'ประเภทติดต่อ',
            'car_type' => 'ประเภทรถ',
            'car_license_no' => 'ทะเบียนรถ',
            'status' => 'สถานะ',
            'car_state' => 'สถานะรถ',
            'status_reason' => 'เหตุผล',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'in_date' => 'เข้า',
            'out_date' => 'ออก',
        ];
    }
}
