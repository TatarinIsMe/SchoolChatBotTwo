<?php

namespace app\controllers;

//use yii\web\Controller;

class MyController extends AppController {
    public function actionIndex(){
        $hi = 'hi';
        return $this->render('index', ['hell' => $hi]);
    }
}
