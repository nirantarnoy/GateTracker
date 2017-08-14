<?php

namespace backend\controllers;

use Yii;
use backend\models\Journal;
use backend\models\JournalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use backend\helpers\NotificationType;
use backend\helpers\CarState;

/**
 * JournalController implements the CRUD actions for Journal model.
 */
class JournalController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Journal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $search = '';
        $sdate = '';
        $ndate = '';
        $apptype = '';
        $searchModel = new JournalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->pagination->pageSize = 5;

        $count_noti = \backend\models\Notification::find()->where(['status'=>0])->count();

        if(Yii::$app->request->isGet){
          $search = Yii::$app->request->get('search');
          $sdate = strtotime(Yii::$app->request->get('s_date'));
          $ndate = strtotime(Yii::$app->request->get('n_date'));
          $apptype = Yii::$app->request->get('approve_type');
          if($search!='' || $sdate != '' || $ndate != '' || $apptype !=''){
            //echo strtotime($sdate);return;
            $dataProvider->query->andFilterWhere(['or',
                ['like','journal_no',$search],
                ['like','car_license_no',$search]
              ]);
              // $dataProvider->query->andFilterWhere(['and',
              //     ['>=','created_at',$sdate],
              //     ['<=','created_at',$ndate]
              //   ]);
              $dataProvider->query->andFilterWhere(['between','created_at',$sdate,$ndate]);

              $dataProvider->query->andFilterWhere(['status'=>$apptype]);
          }

        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'search'=> $search,
            'sdate'=> $sdate,
            'ndate'=> $ndate,
            'apptype'=> $apptype,
            'count_noti' => $count_noti,
        ]);
    }

    public function actionJournalin()
    {
        $model = new Journal();

        return $this->render('journalin', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Journal model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Journal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Journal();

        if ($model->load(Yii::$app->request->post())) {
            $model->car_state = CarState::CAR_STATE_WAIT_IN;
            if($model->save()){
                $session = new Session();
                $session->open();
                $message = 'ทะเบียนรถ '.$model->car_license_no. ' วัน-เวลา '.date('d-m-Y H:i');
                $this->notify_message($message);

                $noti_type = 0;
                // if(isset($session['roleaction'])){
                //   if($session['roleaction']==1){
                //     $noti_type = NotificationType::SEND_BACK_APPROVE;
                //   }else{
                //     $noti_type = NotificationType::SEND_TO_APPROVE;
                //   }
                // }

                $model_notification = new \backend\models\Notification();
                $model_notification->title = $model->contacttype->name;
                $model_notification->type = 1;
                $model_notification->refid = $model->id;
                $model_notification->reftype = 1;
                $model_notification->status = 0;
                $model_notification->description = $model->cartype->name.' ทะเบียน '.$model->car_license_no;
                $model_notification->save(false);

                return $this->redirect(['index']);
            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
                'runno' => Journal::getLastNo(),
            ]);
        }
    }

    /**
     * Updates an existing Journal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Journal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Journal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Journal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Journal::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function notify_message($message)
    {
        $line_api = 'https://notify-api.line.me/api/notify';
        $line_token = 'PsfKlrLokRQRBUBmW3Gc784bcKkf07ORFXH5hk05eSc';

      //  $message = 'Test send notify from line notify';
        $queryData = array('message' => $message);
        $queryData = http_build_query($queryData,'','&');
        $headerOptions = array(
            'http'=>array(
                'method'=>'POST',
                'header'=> "Content-Type: application/x-www-form-urlencoded\r\n"
                    ."Authorization: Bearer ".$line_token."\r\n"
                    ."Content-Length: ".strlen($queryData)."\r\n",
                'content' => $queryData
            )
        );
        $context = stream_context_create($headerOptions);
        $result = file_get_contents($line_api, FALSE, $context);
        $res = json_decode($result);
        return $res;
    }
}
