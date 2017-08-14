<?php
namespace backend\models;

use yii\db\ActiveRecord;
use backend\models\Product;
date_default_timezone_set('Asia/Bangkok');
class Transaction extends \common\models\JournalTrans
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
    public function getJournal(){
      return $this->hasOne(\backend\models\Journal::className(),['id'=>'journal_id']);
    }
    public static function getLastNo(){
      $model = Transaction::find()->MAX('trans_no');
      if($model){
        $prefix ="REC";
        $cnum = substr((string)$model,2,strlen($model));
        $len = strlen($cnum);
        $clen = strlen($cnum + 1);
        $loop = $len - $clen;
        for($i=1;$i<=$loop;$i++){
          $prefix.="0";
        }
        $prefix.=$cnum + 1;
        return $prefix;
      }else{
          $prefix ="REC".substr(date('Y'),2,2);
          return $prefix.'000001';
      }
  }
  public static function productcode($id){
    $model = Product::find()->where(['id'=>$id])->one();
    return count($model)>0?$model->product_code:'';
  }
  public static function productname($id){
    $model = Product::find()->where(['id'=>$id])->one();
    return count($model)>0?$model->name:'';
  }
}
