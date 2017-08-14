<?php

namespace backend\controllers;

use Yii;
use backend\models\Transaction;
use backend\models\TransactionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Journal;
use backend\models\Product;
use yii\helpers\Json;
use common\models\JournalTransDetail;
use backend\models\Notification;

/**
 * TransactionController implements the CRUD actions for Transaction model.
 */
class TransactionController extends Controller
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
                    'delete' => ['POST','GET'],
                   // 'findproduct' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Transaction models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Transaction model.
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
     * Creates a new Transaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Transaction();

        if ($model->load(Yii::$app->request->post())) {
            
            $product = Yii::$app->request->post('product_id');
            $name = Yii::$app->request->post('name');
            $quantity = Yii::$app->request->post('quantity');
            $price = Yii::$app->request->post('price');
            $weight = Yii::$app->request->post('weight');

            if($model->save()){
                if(count($product)>0){
                    for($i=0;$i<=count($product)-1;$i++){
                        $modelline = new \common\models\JournalTransDetail();
                        $modelline->journal_trans_id = $model->id;
                        $modelline->status = 0;
                        $modelline->product_id = $product[$i];
                        $modelline->quantity = $quantity[$i];
                        $modelline->price = $price[$i];
                        $modelline->weight = $weight[$i];
                        if($modelline->save(false)){

                        }
                    }
                }
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Transaction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelline = \common\models\JournalTransDetail::find()->where(['journal_trans_id'=>$id])->all();

        if ($model->load(Yii::$app->request->post())) {
            //$line_del = Yii::$app->request->post('line_del');

            $product = Yii::$app->request->post('product_id');
            $name = Yii::$app->request->post('name');
            $quantity = Yii::$app->request->post('quantity');
            $price = Yii::$app->request->post('price');
            $weight = Yii::$app->request->post('weight');
            //print_r($line_del);return;
            // if(count($line_del)>0){
            //     for($i=0;$i<=count($line_del)-1;$i++){
            //         \common\models\JournalTransDetail::deleteAll(['id'=>$line_del[$i]]);
            //     }
            // }
            if($model->save()){
                if(count($product)>0){
                    \common\models\JournalTransDetail::deleteAll(['journal_trans_id'=>$model->id]);
                    for($i=0;$i<=count($product)-1;$i++){
                        $modelline = new \common\models\JournalTransDetail();
                        $modelline->journal_trans_id = $model->id;
                        $modelline->status = 0;
                        $modelline->product_id = $product[$i];
                        $modelline->quantity = $quantity[$i];
                        $modelline->price = $price[$i];
                        $modelline->weight = $weight[$i];
                        if($modelline->save(false)){

                        }
                    }
                }
                return $this->redirect(['index']);
            }
            
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelline' => $modelline,
            ]);
        }
    }

    public function actionGetjournalinfo(){
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post('id');
            //echo $id;return;
            if($id != ''){
                $model = Journal::find()->where(['id'=>$id])->one();
                echo count($model)>0?$model->car_license_no:'';return;
            }
        }
    }
    public function actionFindproduct($q){
        $query = $q;
       // return Json::encode([['id'=>1,'product_code'=>'AX300','name'=>'test']]);
    //  $query = Yii::$app->request->get("q");
       // $model = Product::find()->select(['id','sku','name','price'])->where(['like','sku',$query])->andFilterWhere(['tenant_id'=>Yii::$app->tenant->identity->id,'status'=>1])->all();
        $model = Product::find()->select(['id','product_code','name','price','weight'])->where(['like','product_code',$query])->orFilterWhere(['like','name',$query])->all();
        //$model = Product::find()->all();
        if($model){
            return Json::encode($model);
        }
    }
    public function actionApproveline(){
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post('id');
            $status = Yii::$app->request->post('status');
            
            if($id!=''){
                //echo $status;return;
                $model = JournalTransDetail::find()->where(['id'=>$id])->one();
                if($model){
                    $model->status = $status;
                    $model->save(false);
                    return true;
                }
            }
        }
    }
    public function actionApprovetrans(){
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->post('id');
           // $status = Yii::$app->request->post('status');
            $res = 0;
            if(count($id)>0){
                for($i=0;$i<=count($id)-1;$i++){
                    $model = Transaction::find()->where(['id'=>$id[$i]])->one();
                    if($model){
                       // echo $model->id;return;
                        $model->status = 1;
                        if($model->save(false)){
                            $res +=1;
                            $model_notification = new Notification();
                            $model_notification->title = 'แจ้งรถออก ทะเบียน ';//.$model->car_license_no;
                            $model_notification->type = 0;
                            $model_notification->refid = $model->id;
                            $model_notification->reftype = 2;
                            $model_notification->status = 0;
                            $model_notification->description = '';//$model->cartype->name.' ทะเบียน '.$model->car_license_no;
                            $model_notification->save(false);
                        }
                    }
                }
                if($res >0){
                    $session = Yii::$app->session;
                    $session->setFlash('msg','ตรวจสอบใบรับสินค้าเรียบร้อยแล้ว');
                    return $this->redirect(['transaction/index']);
                }else{
                    return $this->redirect(['transaction/index']);
                }
            }
        }
    }

    /**
     * Deletes an existing Transaction model.
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
     * Finds the Transaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transaction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
