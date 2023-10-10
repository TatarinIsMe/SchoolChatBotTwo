<?php

namespace app\controllers;
header("Access-Control-Allow-Origin: *");

//use yii\web\Controller;
use app\models\Category;
use app\models\Last;
use app\models\Questions;
use Yii;
use app\models\TestForm;
class PostController extends AppController {


    public $layout = 'basic';
    public $array = array();
    public $lastItem=0;

    public function getLastItem(){
        $count = Last::find()
            ->count();
        $lastItem = last::find()
            ->where(['id' => $count])
            ->one();
        return $lastItem;
    }

    public function actionIndex(){
        $array[] = 'Welcome';
        $lastItem = $this->getLastItem();
        //debug($lastItem->current);
        $question = $this->getQuestion($lastItem->current);
        $string = Yii::$app->request->post('string');
        if ($string != null){
            if ($string == 'да'){
                $question = $this->getQuestion($question->idYes);
            } else {
                $question = $this->getQuestion($question->idNo);
            }
        }



//        if (Yii::$app->request->isAjax){
//            debug(Yii::$app->request->post());
//            return 'test';
//        }
        $model = new TestForm();
        //$string = Yii::$app->request->post('string');
        //  $array[] = $string;
        //debug($array);

        //if ($model->load(Yii::$app->request->post())){
//            if ($model->valideate()){
//                Yii::$app->session->setFlash('success', 'Okay, Accepted');
//            } else{
//                Yii::$app->session->setFlash('error', 'Some error');
//            }
            //$array[] = $model->name;
        //    $array[] = 'hi';
          //  debug($array);
            //debug(Yii::$app->request->post());
            $text = Yii::$app->request->post();
//            echo $text->email;
        //}
        //return $this->render('test', compact('model'));
       // return $this->render('test', compact('model', 'array'));
        return $this->render('test', ['messages' => $question->qa]);

    }
    public function getQuestion($id){
        $qa = Questions::findOne($id);
        $this->saveIdItem($id);
        return $qa;
    }


    public function saveIdItem($id){
        $item =new Last();
        $item->current = $id;
        $item->save(false);
    }
    public function actionShow(){

        //$data = file_get_contents('/Applications/MAMP/htdocs/basic');
       // $data = 'Hello';
        //echo $data;
       // $cats = Category::find()->asArray()->where('age = 11')->all();
//        $cats = Category::find()->asArray()->all();
//        $cats = Category::find()->with('product')->where('id=1')->all();
        $cats =  Category::find()->with('product') -> all();
        return $this->render('show', compact('cats'));
        
        //return $this->render('show');
    }
}