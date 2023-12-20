<h1>ADD Quesiton and Answer</h1>
<h5>Под Id имеется ввиду после какого вопроса хотим добавить вопрос</h5>
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>
<?php //$this->registerJsFile('@web/js/script.js', ['depends' => 'yii\web\YiiAsset'])
//debug($model);?>
<?php $form = ActiveForm::begin() ?>
<?= $form->field($model,'question')?>
<?= $form->field($model,'answer')?>
<?= $form->field($model,'id')?>
<?= Html::submitButton('Add',['class' => 'btn btn-success'])?>
<?php ActiveForm::end()?>
<h1>Change Quesiton and Answer</h1>
<h3>Вместо пропусков ставим "-"</h3>
<?php $formAdd = ActiveForm::begin() ?>
<?= $formAdd->field($modelChange,'question')?>
<?= $formAdd->field($modelChange,'answerYes')?>
<?= $formAdd->field($modelChange,'answerNo')?>
<?= $formAdd->field($modelChange,'answerStrict')?>
<?= $formAdd->field($modelChange,'id')?>
<?= Html::submitButton('Change',['class' => 'btn btn-success'])?>
<?php ActiveForm::end()?>
<?php
//debug($cats);
?>
<?php
//echo count($cats[0]->product)
?>
<?php
//debug($cats);
?>
<?php
foreach ($answers as $cat){
    echo '<ul>';
     echo '<li>' . $cat->id . '</li>';
    echo '<li>' . $cat->text . '</li>';
     $products = $cat->answer;
     foreach ($products as $product){
         echo '<ul>';
          echo '<li>' . $product->name . '</li>';
         echo '</ul>';
     }
    echo '</ul>';
}
?>

<?php 
// $js = <<<JS 
// $('#btn').on('click',function(){
//     $.ajax({
//         url: 'index.php?r=post/index',
//         data: {test:'123'},
//         type: 'POST',
//         success: function(res){
//             console.log(res);
//         }
//         error: function(){
//             alert('Erorrrr');
//         }
//     });
// });
// JS;

//$this->registerJs($js);
$this->registerJs("$('#btn').on('click',function(){
    $.ajax({
        url: 'index.php?r=post/index',
        data: {test:'123'},
        type: 'POST',
        success: function(res){
            console.log(res);
        },
        error: function(){
            alert('Erorrrr');
        }
    });
});");
?>
