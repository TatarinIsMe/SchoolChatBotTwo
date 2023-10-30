<h1>ADD Quesiton and Answer</h1>
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
<?= Html::submitButton('Send',['class' => 'btn btn-success'])?>
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
