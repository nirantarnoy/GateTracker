<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "journal_trans".
 *
 * @property int $id
 * @property int $journal_id
 * @property string $contact_name
 * @property string $position
 * @property string $company
 * @property string $contact_emp
 * @property string $contact_number
 * @property string $contact_detail
 * @property int $status
 * @property string $document_ref
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class JournalTrans extends \yii\db\ActiveRecord
{
    public $carinfo;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'journal_trans';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['journal_id','trans_no'],'required'],
            [['journal_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['contact_detail'], 'string'],
            [['contact_name', 'position', 'company', 'contact_emp', 'contact_number', 'document_ref','carinfo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trans_no' => 'เลขที่รับ',
            'journal_id' => 'เลขที่ใบแจ้ง',
            'contact_name' => 'ผู้ติดต่อ',
            'position' => 'ตำแหน่ง',
            'company' => 'บริษัท',
            'contact_emp' => 'บุคคลติดต่อ',
            'contact_number' => 'เบอร์ติดต่อ',
            'contact_detail' => 'รายละเอียด',
            'status' => 'สถาณะ',
            'document_ref' => 'เอกสารอ้างอิง',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'carinfo' => 'ทะเบียนรถ'
        ];
    }
}
