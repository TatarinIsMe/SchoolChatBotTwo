<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
$form = ActiveForm::begin([
    'layout' => 'horizontal'
])?>
<br>
<h2>Редактирование</h2>
<br>
<?= $form->field($model, 'text')?>
<?= $form->field($modelOne, 'name')?>
<?php //foreach ($modelOne as $answer){
//  echo $form->field($answer, 'name');
//} ?>
<div class="form-group">
    <div class="col-lg-offset-7 col-lg-5">
<?= Html::submitButton('Сохранить ', ['class'=> 'btn btn-primary'])?>
</div>
</div>
<?php ActiveForm::end() ?>
<?php
//$formTwo = ActiveForm::begin([
//    'id' => 'login-form',
//    'options' => ['class' => 'form-horizontal'],
//])?>
<!---->
<?php //= $formTwo->field($modelOne[0], 'name')?>
<?php //= Html::submitButton('Сохранить Ответ', ['class'=> 'btn btn-primary'])?>
<?php //ActiveForm::end() ?>

