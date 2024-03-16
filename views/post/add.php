<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
$form = ActiveForm::begin([
    'layout' => 'horizontal'
])?>
<br>
<h2>Добавление</h2>
<br>

<?= $form->field($model, 'id')?>
<?= $form->field($model, 'question')?>
<?= $form->field($model, 'answer')?>
<?php //foreach ($modelOne as $answer){
//  echo $form->field($answer, 'name');
//} ?>
<div class="form-group">
    <div class="col-lg-offset-7 col-lg-5">
        <?= Html::submitButton('Добавить ', ['class'=> 'btn btn-primary'])?>
    </div>
</div>
<?php ActiveForm::end() ?>
