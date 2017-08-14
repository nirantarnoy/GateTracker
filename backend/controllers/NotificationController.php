<?php

namespace backend\controllers;

use Yii;
use backend\models\Notification;
use backend\models\NotificationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use common\models\Journal;
use yii\web\Session;
use backend\helpers\CarState;
/**
 * NotificationController implements the CRUD actions for Notification model.
 */
class NotificationController extends Controller
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
     * Lists all Notification models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session = Yii::$app->session;
        $typenoti = 0;
        if(isset($session['roleaction'])){
            $typenoti = $session['roleaction'];
        }
        $searchModel = new NotificationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['status'=>0]);
        $dataProvider->query->andFilterWhere(['type'=>$typenoti])->orderBy(['created_at'=>SORT_DESC]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionShowlist(){
      $modelupdate = Notification::find(['type'=>0,'status'=>0])->all();
      if(count($modelupdate)>0){
        foreach($modelupdate as $data){
          $data->status = 1;
          $data->save(false);
        }
      }

     $query =null;
     $textsearch = '';
     if(Yii::$app->request->isPost){
       $txt = Yii::$app->request->post('noti-search');
       $textsearch = $txt;
     //  echo $txt;return;
       $query = Notification::find()->where(['!=','status',100])
                                  //  ->andFilterWhere(['like','title',$txt])->andFilterWhere(['like','description',$txt]);
                                    ->andFilterWhere(['or',
                                           ['like','title',$txt],
                                           ['like','description',$txt]]
                                         )
                                    ->andFilterWhere(['type'=>0])
                                    ->orderBy(['created_at'=>SORT_DESC]);
     }else{
       $query = Notification::find()->where(['!=','status',100])->andFilterWhere(['type'=>0])->orderBy(['created_at'=>SORT_DESC]);
     }
      $countQuery = clone $query;
      $pages = new Pagination([
        'defaultPageSize'=>30,
        'totalCount'=>$countQuery->count()
      ]
      );
      //$pages->limit = 2;
      $model = $query->offset($pages->offset)->limit($pages->limit)->orderBy(['created_at'=>SORT_DESC])->all();
      //$model = $query->limit(2)->orderBy(['created_at'=>SORT_DESC])->all();
      return $this->render('_index',[
        'model'=>$model,
        'pages'=>$pages,
        'textsearch'=>$textsearch,

      ]);
    }

    public function actionApprovenoti(){
        if(Yii::$app->request->isAjax){
            $approvelist = Yii::$app->request->post('approvelist');
            $approvetext = Yii::$app->request->post('approvetext');
            $approvestatus = Yii::$app->request->post('approvestatus');
            if(count($approvelist)>0){
                $res = 0;
                for($i=0;$i<=count($approvelist)-1;$i++){
                    $modelrefid = Notification::find()->where(['id'=>$approvelist[$i]])->one();
                    if($modelrefid){
                        $model = Journal::find()->where(['id'=>$modelrefid->refid])->one();
                        $model->status = $approvestatus == 1?1:2;
                        $model->in_date = $approvestatus == 1?time():NULL;
                        $model->car_state = $approvestatus == 1?CarState::CAR_STATE_IN:CarState::CAR_STATE_WAIT_IN;
                        $model->status_reason = $approvetext;
                        if($model->save(false)){
                            $res +=1;

                            $model_notification = new Notification();
                            $model_notification->title = 'ผลอนุมัติการแจ้งรถเข้าทะเบียน '.$model->car_license_no;
                            $model_notification->type = 0;
                            $model_notification->refid = $model->id;
                            $model_notification->reftype = 1;
                            $model_notification->status = 0;
                            $model_notification->description = '';//$model->cartype->name.' ทะเบียน '.$model->car_license_no;
                            $model_notification->save(false);
                        }

                        $modelrefid->status = 1;
                        $modelrefid->save(false);
                    } 

                }
                
                if($res >0){
                    $session = Yii::$app->session;
                    $session->setFlash('msg','อนุมัติใบแจ้งเรียบร้อยแล้ว');
                    return $this->redirect(['notification/index']);
                }else{
                    return $this->redirect(['notification/index']);
                }
            }
        }
    }

    /**
     * Displays a single Notification model.
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
     * Creates a new Notification model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Notification();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Notification model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Notification model.
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
     * Finds the Notification model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notification the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notification::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
