<?php

namespace app\controllers;
header("Access-Control-Allow-Origin: *");

//use yii\web\Controller;
use app\models\Answer;
use app\models\Category;
use app\models\History;
use app\models\Last;
use app\models\LastOrder;
use app\models\Questions;
use Yii;
use app\models\TestForm;
use app\models\AddForm;
use app\models\ChangeForm;
//use app\models\History;
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

    public function actionMail(){
        $result = Yii::$app->mailer->compose()
            ->setFrom('ibnrinat02@mail.ru')
            ->setTo('ibnrinat02@mail.ru')
            ->setSubject('Session')
            ->setTextBody('Hi there')
            ->setHtmlBody('<b>Text Html</b>')
            ->send();
        debug($result);
        die;
    }


    public function actionIndex(){
        $textOutputTest ='';
        $history = new History();
        $string = Yii::$app->request->post('string');
//        $answers = Questions::find()->with('answer')->all();

        if ($string != null){
            $history->saveHistory($string);
            if ($string == 'да' || $string == 'нет'){
                //$question = $this->getYesNo($string);
                $this->getYesNo($string);
                //обнуление заказа
            } else if ($string != ''){
                 $textOutputTest = $this->getStrictAnswer($string);
            }
        }
        $lastItem = $this->getLastItem();
        $question = $this->getQuestion($lastItem->current_row)->text;
//        if (Yii::$app->request->isAjax){
//            debug(Yii::$app->request->post());
//            return 'test';
//        }
        $model = new TestForm();
        //$string = Yii::$app->request->post('string');
        //  $array[] = $string;
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
        //return $this->render('test', ['messages' => $question->text]);
        $history->saveHistory($question);
        return $this->render('test', ['messages' => $question, 'testText' => $textOutputTest]);
    }
    public function getYesNo($answer){
        $current = $this->getLastItem();
        $answers = Questions::find()->with('answer')->where(['id' => $current->current_row])->all();
        if ($answer == 'да'){
            $this->saveIdItem($answers[0]->answer[0]->next_question_id);
            //Описание заявки
            $textOrder = $answers[0]->answer[0]->name;
            $message = '';
            $lastItem = $this->getLastOrder();
            $message .= $lastItem;
            $message .=$textOrder;
            $this->updateLastOrder($message);
           // return $answers[0]->text;
        }  else {
            $this->saveIdItem($answers[0]->answer[1]->next_question_id);
            $text = 'Заявка: ';
            $this->updateLastOrder($text);
            //return $answers[0]->text;
        }
    }
    public function getStrictAnswer($answer){
        $history = new History();
        $message = '';
        $lastItem = $this->getLastOrder();
        $message .= $lastItem;
        $message .=$answer;

        $current = $this->getLastItem();
        $answers = Questions::find()->with('answer')->where(['id' => $current->current_row])->all();
        $temp = $answers[0]->answer[0]->name;
        $message .= $temp;//приписываем ответ с ответа на вопрос
        //обновляем значение в бд
        $history->saveHistory($message);
        $this->updateLastOrder($message);


        //Прописываем проверку на пустое (то есть конец)
        if ($answers[0]->answer[0]->next_question_id == null){
            //$specialist = $answers[0]->answer[0]->name;
           // $this->sentToSpecialist($message);
            $this->saveIdItem(1);
            $text = 'Заявка  ';
            $this->updateLastOrder($text);
            $history->addHistory();
            return $message;

        }
        $this->saveIdItem($answers[0]->answer[0]->next_question_id);
        return $message;
    }

    public function getLastOrder(){
        $count = LastOrder::find()
            ->count();
        $lastItem = LastOrder::find()
            ->where(['id' => $count])
            ->one();
        return $lastItem->text;
    }
    //Обновление последнего заказа в бд, заказ - это заявка для спецалиста
    public function updateLastOrder($text){
        $count = LastOrder::find()
            ->count();
        $post = LastOrder::find()->where(['id' =>$count])->all();
        $post[0]->text = $text;
        $post[0]->save();
    }

    public function sentToSpecialist($message){
        Yii::$app->mailer->compose('cart', ['message' => $message])
            ->setFrom('ibnrinat02@mail.ru')
            ->setTo('ibnrinat02@mail.ru')
            ->setSubject('Session')
            ->send();
//        Yii::$app->mailer->compose()
//            ->setFrom('ibnrinat02@gmail.com')
//            ->setTo('ibnrinat02@gmail.com')
//            ->setSubject('Session')
//            ->setTextBody('Hi there')
//            ->setHtmlBody('<b>Text Html</b>')
//            ->send();

    }

    public function getQuestion($id){
        $qa = Questions::findOne($id);
        $this->saveIdItem($id);
        return $qa;
    }


    public function saveIdItem($id){
        $post = Last::find()->where(['id' =>'1'])->all();
        $post[0]->current_row = $id;
        $post[0]->save();
//        $item =new Last();
//        $item->current_row = $id;
//        $item->save(false);
    }
    public function addQuestion($text){
        $item =new Questions();
        $item->text = $text;
        $item->save(false);
        $count = Questions::find()
            ->count();
        return $count;

    }
    public function addAnswer($count,$idNext){
        $itemYes =new Answer();
        $itemYes->name = 'Да';
        $itemYes->question_id = $count;
        $itemYes->next_question_id = $count;
        $itemYes->save(false);

        $itemNo =new Answer();
        $itemNo->name = 'Нет';
        $itemNo->question_id = $count;
        $itemNo->next_question_id = $idNext;
        $itemNo->save(false);
    }
    public function addAnswerStrict($count,$idNext){
        $itemYes =new Answer();
        $itemYes->name = 'Ответ';
        $itemYes->question_id = $count;
        $itemYes->next_question_id = $idNext;
        $itemYes->save(false);
    }
    public function changeAnswer($id,$nextId){
        $post = Answer::find()->where(['question_id' =>$id])->all();
        $post[1]->next_question_id = $nextId;
        $post[1]->save();
    }
    public function changeAnswerStrict($id,$nextId){
        $post = Answer::find()->where(['question_id' =>$id])->all();
        $post[0]->next_question_id = $nextId;
        $post[0]->save();
    }
    public function actionShow(){
        $model = new AddForm();
        $modelChange = new ChangeForm();
        if ($model->load(Yii::$app->request->post())){

            $idQuestion = $model->id;
        if ($model->answer == 'да-нет'){
            $answer = Questions::find()->with('answer')->where(['id' => $idQuestion])->all();
            $next_id = $answer[0]->answer[1]->next_question_id;
        } else {
            $answer = Questions::find()->with('answer')->where(['id' => $idQuestion])->all();
            $next_id = $answer[0]->answer[0]->next_question_id;
        }
        $count = $this->addQuestion($model->question);
        if ($model->answer == 'да-нет'){
            $this->addAnswer($count,$next_id);
            $this->changeAnswer($idQuestion,$count);
        } else {
            $this->addAnswerStrict($count,$next_id);
            $this->changeAnswerStrict($idQuestion,$count);
        }
        }
        if ($modelChange->load(Yii::$app->request->post())){
            $modelChange->addQuestions();
            $modelChange->addAnswers();



        }
//        $answer = Questions::find()->with('answer')->where(['id' => 11])->all();
//            $next_id = $answer[0]->answer[1]->next_question_id;
//            debug($next_id);
//        $model->load(Yii::$app->request->post());
//        $idQuestion = $model->id;
//        if ($model->answer == 'да-нет'){
//            $answer = Questions::find()->with('answer')->where(['id' => $idQuestion])->all();
//            $next_id = $answer[0]->answer[1]->next_question_id;
//        }
//        $count = $this->addQuestion($model->question);
//        $this->addAnswer($count,$next_id);
        //change previous question


        //$data = file_get_contents('/Applications/MAMP/htdocs/basic');

       // $cats = Category::find()->asArray()->where('age = 11')->all();
//        $cats = Category::find()->asArray()->all();
//        $cats = Category::find()->with('product')->where('id=1')->all();
        $answers = Questions::find()->all();
        $cats = Category::find()->with('product') -> all();
        return $this->render('show', compact( 'model', 'answers', 'modelChange'));
    }
}