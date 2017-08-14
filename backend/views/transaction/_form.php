<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Transaction;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\Journal;
use yii\helpers\Url;
use kartik\typeahead\Typeahead;
use yii\helpers\Json;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model backend\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
$runno = Transaction::getLastNo();
$journal = Journal::find()->where(['status'=>1])->all();
$fineinfo_url = Yii::$app->getUrlManager()->createUrl('transaction/getjournalinfo');
$approve_line_url = Yii::$app->getUrlManager()->createUrl('transaction/approveline');


$this->registerJs('
    $(function(){
      var line_del = [];
      $(document).on("click", ".remove-product", function(){
           product_data = 0;
           var p_id = $(this).closest("tr").find(".recid").val();
           line_del.push(p_id);
           
           $("#line_del").val(line_del);
           // remove item from table
           $(this).parents("tr").remove();
           var cnt = 0;
           $("#poitem >tbody >tr").each(function(){
             cnt +=1;
             $(this).find("td:first-child").text(cnt);
           });
         });

        $(".approve-line").click(function(){
          if($(this).hasClass("btn-default")){
            $(this).removeClass("btn-default");
            $(this).addClass("btn-success");
            $(this).text("Yes");
            var ids = $(this).closest("tr").find(".recid").val();
            $.ajax({
                    type: "post",
                    dataType: "html",
                    url: "/index.php?r=transaction%2Fapproveline ",
                    data: {id: ids,status: 1},
                    success: function(data){
                           // $("#carinfo").val(data);
                               //   alert(data);
                    },
                    error: function(){

                    }
            });

          }else{
            $(this).removeClass("btn-success");
            $(this).addClass("btn-default");
            $(this).text("No");
            var ids = $(this).closest("tr").find(".recid").val();
            $.ajax({
                    type: "post",
                    dataType: "html",
                    url: "/index.php?r=transaction%2Fapproveline ",
                    data: {id: ids,status: 0},
                    success: function(data){
                            //$("#carinfo").val(data);
                                  //alert(data);
                    },
                    error: function(){

                    }
            });
          }
           
        });
    });
  ',static::POS_END);
?>

<div class="transaction-form">

    <?php $form = ActiveForm::begin(); ?>
    <input type="hidden" id="line_del" name="line_del" value="">
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">ข้อมูลหลัก</div>
          <div class="panel-body">
            <div class="row">
                 <div class="col-lg-2">
                     <?= $form->field($model, 'trans_no')->textInput(['readonly'=>'readonly','value'=>$model->isNewRecord?$runno:$model->trans_no]) ?>
                 </div>
                  <div class="col-lg-2">
                     <?= $form->field($model, 'journal_id')->widget(Select2::className(),[
                        'data' => ArrayHelper::map($journal,'id','journal_no'),
                        'options'=>['placeholder'=>'เลือกรายการ',
                            'onchange'=>' 
                                    $.ajax({
                                        type: "post",
                                        dataType: "html",
                                        url: "/index.php?r=transaction%2Fgetjournalinfo ",
                                        data: {id: $(this).val()},
                                        success: function(data){
                                           $("#carinfo").val(data);
                                            //alert(data);
                                        },
                                        error: function(){

                                        }
                                    });
                            '
                         ],
                     ]) ?>
                 </div>
                 <div class="col-lg-3">
                     <?= $form->field($model, 'carinfo')->textInput(['readonly'=>'readonly','id'=>'carinfo']) ?>
                 </div>
               
                 <div class="col-lg-3">
                    <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-2">
                    <?= $form->field($model, 'contact_name')->textInput(['maxlength' => true]) ?>
                </div>
   
            </div>
            <div class="row">
                
                
                 <div class="col-lg-2">
                    <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>
                </div>
                 <div class="col-lg-2">
                    <?= $form->field($model, 'contact_emp')->textInput(['maxlength' => true]) ?>
                </div>

                 <div class="col-lg-2">
                    <?= $form->field($model, 'contact_number')->textInput(['maxlength' => true]) ?>
                </div>
                 <div class="col-lg-2">
                     <?= $form->field($model, 'document_ref')->textInput() ?>
                 </div>
            </div>

            <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
                <br />
              <div class="row">
                <div class="col-lg-3">
                <?php
              //$baseUrl = "#";
            //  $baseUrl = "/product/product/findproduct";
               //echo '<label class="control-label">Select Repository</label>';
                   //$template = '<div><p class="repo-language">{{product_code}}</p>' .
                 //  '<p class="repo-name">{{name}}</p>' .
                   '<p class="repo-description">{{name}}</p></div>';
                    echo Typeahead::widget([
                           'name' => 'products',
                           'options' => ['placeholder' => Yii::t('app', 'ค้นหารหัสสินค้า')],
                           'dataset' => [
                               [
                                 //'prefetch' => $baseUrl,
                                 'remote' => [
                                     'url' => '/index.php?r=transaction%2Ffindproduct'.'&q=%QUERY',
                                     'wildcard' => '%QUERY'
                                 ],
                                 //'prefetch' => $baseUrl . '/samples/repos.json',
                                 'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                   'display' => 'value',
                                   'limit' => '1000',
                                   'templates' => [
                                       'notFound' => '<div class="text-danger" style="padding:0 8px">Unable to find product code or name.</div>',
                                       //'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
                                       'suggestion' => new \yii\web\JsExpression("Handlebars.compile('<div><span class=\'fa fa-picture-o\' style=\'font-size:1.5em;\'></span> {{product_code}} {{name}}</div>')"),
                                   ]
                               ]
                           ],
                           'pluginEvents' => [
                               "typeahead:select" => "
                                   function(e,s) {
                                     if($(document).find('#ordered-product-id-'+s.id).length >= 1){

                                     }else{
                                       $.ajax({
                                               type: 'POST',
                                               url: '".Url::toRoute(['/product/addproduct'], true)."',
                                               data: { data:s },
                                               success: function(data){
                                                 $('.add-product-form').parent().append(data);
                                                 var cnt =0;
                                                 $('#poitem >tbody >tr').each(function(){
                                                   cnt +=1;
                                                   $(this).find('td:first-child').text(cnt);
                                                 });
                                                // totalall();
                                               }
                                             });
                                     }
                                   }
                                   "
                                 ]
                       ]);
              ?>
              </div>
          </div><br />
                <div class="row">
                    <div class="col-lg-12">
                        <table id="poitem" class="table table-bordered" >
                     <thead>
                     <tr class="active">
                         <th style="width: 5%">#</th>
                         <th style="width: 10%">รหัสสินค้า</th>
                         <th style="width: 40%">ชื่อสินค้า</th>
                         <th style="width: ">จำนวน</th>
                         <th style="width: ">ราคา</th>
                         <th style="width: ">น้ำหนัก</th>
                         <th class="action">action</th>
                         <th class="action">อนุมัติ</th>
                     </tr>
                     </thead>
                     <tbody class="add-product-form">
                       <?php if(!$model->isNewRecord):?>
                                 <?php $i = 0;?>
                                 <?php foreach($modelline as $value):?>
                                 <?php  $i+=1; ?>
                               <tr id="ordered-product-id-">
                                   <td><?php echo $i;?></td>
                                    <td>
                                     <input type="text" class="form-control product_code" name="product_code[]" value="<?=Transaction::productcode($value->product_id);?>" disabled="disabled" />
                                     <input type="hidden" class="product_id" name="product_id[]" value="<?=$value->product_id;?>"/>
                                     <input type="hidden" class="recid" name="recid[]" value="<?=$value->id;?>"/>
                                    </td>
                                    <td><input type="text" class="form-control name" name="name[]" value="<?=Transaction::productname($value->product_id);?>" disabled="disabled" /></td>
                                    <td><input type="number" class="form-control quantity" name="quantity[]" value="<?=number_format($value->quantity);?>" /></td>
                                    <td><input type="number" class="form-control price" name="price[]" value="<?=number_format($value->price);?>" /></td>
                                    <td><input type="number" class="form-control weight" name="weight[]" value="<?=number_format($value->weight);?>" /></td>

                                   <td class="action">
                                       <a class="btn btn-white remove-product" href="javascript:void(0);"><i class="fa fa-trash-o"></i></a>
                                   </td>
                                   <td class="action">
                                    <?php if($model->isNewRecord):?>
                                       <div class="btn btn-default approve-line">No</div>
                                     <?php else:?>
                                       <?php if($value->status == 1):?>
                                          <div class="btn btn-success approve-line">Yes</div>
                                       <?php else:?>
                                          <div class="btn btn-default approve-line">No</div>
                                       <?php endif;?>
                                   <?php endif;?>
                                   </td>
                               </tr>
                             <?php endforeach;?>
                             <?php endif;?>
                     </tbody>
                   </table>
                    </div>
                </div>
        </div>
    </div>
</div>
</div>

    <?php ActiveForm::end(); ?>

</div>
