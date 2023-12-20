<h1>Чат Бот</h1>
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>
<?php

//\app\controllers\debug(Yii::$app);

//debug($model);
?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
<?php echo Yii::$app->session->getFlash('success'); ?>
<?php endif;;?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <?php echo Yii::$app->session->getFlash('error'); ?>
<?php endif;;?>


<?php //$form = ActiveForm::begin() ?>
<?php ////= Html::input('text', 'username', $model->name, []) ?>
<?php //= $form->field($model, 'name')?>
<?php //= $form->field($model, 'email')?>
<?php //= $form->field($model, 'text')?>
<?php //= Html::submitButton('Send', ['class' => 'btn btn-success'])?>
<?php //= Html::button('Кнопочка', ['class'=>'btn class here',
//    'onclick' => '',
//]);?>
<?php //= Html::a('CLick', ['post/index'], ['class' => 'btn btn-success']) ?>
<?php //ActiveForm::end() ?>

<?php Pjax::begin(); ?>
<?= Html::beginForm(['post/index'], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
<?= Html::input('text', 'string', Yii::$app->request->post('string'), ['class' => 'form-control']) ?>
<?= Html::submitButton('Отправить', ['class' => 'btn btn-lg btn-primary', 'name' => 'hash-button']) ?>
<?= Html::endForm() ?>

<h1>Бот: <?php
//foreach ($messages as $text){
//    echo "$text<br/>";
//}
    echo $messages;
    ?></h1>
<?php
echo 'Detail Order: ';
echo $testText;
?>
<?php Pjax::end(); ?>

