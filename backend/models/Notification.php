<?php
namespace backend\models;
use yii\db\ActiveRecord;
use common\models\Journal;
use backend\models\Transaction;

date_default_timezone_set('Asia/Bangkok');
class Notification extends \common\models\Notification
{
  public function behaviors()
{
    return [
        'timestampcdate'=>[
            'class'=> \yii\behaviors\AttributeBehavior::className(),
            'attributes'=>[
            ActiveRecord::EVENT_BEFORE_INSERT=>'created_at',
            ],
            'value'=> time(),
        ],
        'timestampudate'=>[
            'class'=> \yii\behaviors\AttributeBehavior::className(),
            'attributes'=>[
            ActiveRecord::EVENT_BEFORE_INSERT=>'updated_at',
            ],
          'value'=> time(),
        ],
        'timestampupdate'=>[
            'class'=> \yii\behaviors\AttributeBehavior::className(),
            'attributes'=>[
            ActiveRecord::EVENT_BEFORE_UPDATE=>'updated_at',
            ],
            'value'=> time(),
        ],
    ];
 }
 public function getJournalinfo(){
    return $this->hasOne(Journal::className(),['id'=>'refid']);
 }
 public function getJournaltransinfo(){
    return $this->hasOne(Transaction::className(),['id'=>'refid']);
 }


}
