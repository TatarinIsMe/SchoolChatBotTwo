<?php
use yii\grid\GridView;
use yii\helpers\Html;

echo Html::a("Добавить вопрос",["add"],['class'=> 'btn btn-info']);

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'text',
        ['class' => 'yii\grid\ActionColumn']
    ]
]);
//echo GridView::widget([
//    'dataProvider' => $dataProvider2,
//    'columns' => [
//        'id',
//        'name',
//        'question_id',
//        'next_question_id',
//        ['class' => 'yii\grid\ActionColumn']
//    ]
//]);