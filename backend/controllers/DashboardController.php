<?php

namespace backend\controllers;
use yii\web\Controller;
use yii\web\Session;
use backend\models\Journal;

class DashboardController extends Controller
{
  public function actionIndex(){
  	$session = new Session();
  	$session->open();
  	if(isset($session['roleaction'])){
  		if($session['groupid']==1){


           $model1 = Journal::find()->where(['activity_id'=>1])->count();
           $model2 = Journal::find()->where(['activity_id'=>2])->count();
           $model3 = Journal::find()->where(['activity_id'=>3])->count();
           $model4 = Journal::find()->where(['activity_id'=>4])->count();

           $model = '';

  			return $this->render('index',[
            'model1' => $model1,
            'model2' => $model2,
            'model3' => $model3,
            'model4' => $model4,
          ]);
  		}else{
  			return $this->redirect(['journal/index']);
  		}
  	}
  }
}
