<?php

namespace app\controllers;
header("Access-Control-Allow-Origin: *");

//use yii\web\Controller;
use app\models\Answer;
use app\models\Category;
use app\models\History;
use app\models\Journal;
use app\models\Last;
use app\models\LastOrder;
use app\models\Photo;
use app\models\Questions;
use Yii;
use app\models\TestForm;
use app\models\AddForm;
use app\models\ChangeForm;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\web\UrlManager;
use yii\helpers\Url;
use yii\filters\Cors;
//use app\models\History;
class PostController extends AppController {

    public $layout = 'basic';
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];
        return $behaviors;
    }
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionAjax() {

        if(\Yii::$app->request->isPost){
           $param = Yii::$app->request->post();
            $output = $this->mainIndex($param['param1']);
            return $output;
        }

    }

    public function mainIndex($answer){
        $textOutputTest ='';
        $history = new History();
        $questionclass = new Questions();
        $last = new Last();
        $string = $answer;
        if ($string != null){
            $history->saveHistory($string);
            if ($string == 'да' || $string == 'нет'|| $string == 'Да'|| $string == 'Нет'){
                $this->getYesNo($string);
                //обнуление заказа
            } else if ($string != ''){
                if ($this->checkAnswer()){
                    $last->saveIdItem(1);
                    return "Поле не должно быть пустым";
                }
                $textOutputTest = $this->getStrictAnswer($string,$model);
            }
        }
        $lastItem = $this->getLastItem();
        $question = $questionclass->getQuestion($lastItem->current_row)->text;
        $history->saveHistory($question);
        if ($this->isNextStrict()){
            if ($textOutputTest != 'Конец')
            $textOutputTest = 'Strict';} else
                $textOutputTest ='YesNo';
        return json_encode(['text'=> $question, 'type' => $textOutputTest]);
//        return $question;
    }
    public function isNextStrict(){
        $current = $this->getLastItem();
        $answers = Questions::find()->with('answer')->where(['id' => $current->current_row])->all();
        if (count($answers[0]->answer)==1)
            return true; else
                return false;

    }


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
        $model = new Photo();
        $textOutputTest ='';
        $history = new History();
        $questionclass = new Questions();
        $last = new Last();
        $string = Yii::$app->request->post('string');
        if ($string != null){
            $history->saveHistory($string);
            if ($string == 'да' || $string == 'нет' || $string == 'Да' || $string == 'Нет'){
                $this->getYesNo($string);
                //обнуление заказа
            } else if ($string != ''){
                if ($this->checkAnswer()){
                     $last->saveIdItem(1);
                    return $this->render('test', ['messages' => "Wrong answer", 'testText' => $textOutputTest, 'model' => $model]);
                }
                $textOutputTest = $this->getStrictAnswer($string,$model);
            }
        }
        $lastItem = $this->getLastItem();
        $question = $questionclass->getQuestion($lastItem->current_row)->text;
            $text = Yii::$app->request->post();
        $history->saveHistory($question);
        return $this->render('test', ['messages' => $question, 'testText' => $textOutputTest, 'model' => $model]);
    }
    public function getYesNo($answer){
        $lastOrder = new LastOrder();
        $last = new Last();
        $current = $this->getLastItem();
        $answers = Questions::find()->with('answer')->where(['id' => $current->current_row])->all();
        if ($answer == 'да' || $answer == 'Да' ){
            $last->saveIdItem($answers[0]->answer[0]->next_question_id);
            //Описание заявки
            $textOrder = $answers[0]->answer[0]->name;
            $message = '';
            $lastItem = $lastOrder->getLastOrder();
            $message .= $lastItem;
            $message .=$textOrder;
            $lastOrder->updateLastOrder($message);
           // return $answers[0]->text;
        }  else {
            $last->saveIdItem($answers[0]->answer[1]->next_question_id);
            $text = 'Заявка: ';
            $lastOrder->updateLastOrder($text);
            //return $answers[0]->text;
        }
    }
    public function getStrictAnswer($answer,&$photo){
        $history = new History();
        $journal =  new Journal();
        $question = new Questions();
        $lastOrder = new LastOrder();
        $last = new Last();
        $message = '';
        $lastItem = $lastOrder->getLastOrder();
        $message .= $lastItem;
       // $message .=$answer;
        $current = $this->getLastItem();
        $answers = Questions::find()->with('answer')->where(['id' => $current->current_row])->all();
        $temp = $answers[0]->answer[0]->name;
        $temp = $this->checkForJournal($temp,$message, $answer, $photo);
        $message .= $temp;//приписываем ответ с ответа на вопрос
        //обновляем значение в бд
        $history->saveHistory($message);
        $lastOrder->updateLastOrder($message);

        //Прописываем проверку на пустое (то есть конец)
        if ($answers[0]->answer[0]->next_question_id == 1){ //тут должен быть проверка на null
            //$specialist = $answers[0]->answer[0]->name;
           // $this->sentToSpecialist($message);
            $last->saveIdItem(1);
            $text = 'Заявка  ';
            $lastOrder->updateLastOrder($text);
            $history->addHistory();
            $journal->createNew();
            $message = '';
//            return $message;
//            return ['text' => $message, 'type' => ''];
        }
        //сделать проверкку на значние "Конец", далее передать выше в главный метод
        if ($question->isLast($answers[0]->answer[0]->next_question_id)){
            $message = 'Конец';
        } else {
            $message = 'Strict';
        }
        $last->saveIdItem($answers[0]->answer[0]->next_question_id);
        return $message;
//        return ['text' => $message, 'type' => $type];
    }


    public function checkForJournal($answer,$message , $value, &$photo){
        $model = new Journal();
        $test = new Photo();
        $temp = '';
        $tempNum = '';
        if ($answer == 'количество'){
//            $temp .= $message;
            $tempNum = $value;
//            $temp .= '- количество нобходимых деталей';
            $model->addNumber($tempNum);
            return '';
        } else if ($answer == 'кабинет') {
            $tempNum = $value;
            $model->addRoom($tempNum);
            //$temp .= '- кабинет в котором неисправность';
//            return $temp;
        } else if ($answer == 'фото'){
          //  $this->addPhoto($test);
        } else if ($answer == 'Конец'){
            return "Конец";

        } else {
            $temp .= $message;
            $model->addText($temp);
            return $temp;
        }
        $temp .= $message;
        $model->addText($temp); //здесь измненеия
        return $temp;
    }

    public function checkAnswer(){
        $current = $this->getLastItem();
        $answers = Questions::find()->with('answer')->where(['id' => $current->current_row])->all();
        if (count($answers[0]->answer)>1 && $answers[0]->answer[1]->name == 'Нет'){
            return true;
        } else
            return false;
    }

    //Обновление последнего заказа в бд, заказ - это заявка для спецалиста


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

    public function addQuestion($text){
        $item =new Questions();
        $item->text = $text;
        $item->save(false);
        $count = Questions::find()
            ->count();
        return $count;

    }
    public function addAnswer($count,$idNext, $text){
        $itemYes =new Answer();
        $itemYes->name = $text;
        $itemYes->question_id = $count;
        $itemYes->next_question_id = $count;
        $itemYes->save(false);

        $itemNo =new Answer();
        $itemNo->name = 'Нет';
        $itemNo->question_id = $count;
        $itemNo->next_question_id = $idNext;
        $itemNo->save(false);
    }
    public function addAnswerStrict($count,$idNext, $text){
        $itemYes =new Answer();
        $itemYes->name = $text;
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
            $this->addAnswer($count,$next_id, $model->answer);
            $this->changeAnswer($idQuestion,$count);
        } else {
            $this->addAnswerStrict($count,$next_id, $model->answer);
            $this->changeAnswerStrict($idQuestion,$count);
        }
        }
        if ($modelChange->load(Yii::$app->request->post())){
            $modelChange->addQuestions();
            $modelChange->addAnswers();
        }


        $answers = Questions::find()->all();
        $cats = Category::find()->with('product') -> all();
        return $this->render('show', compact( 'model', 'answers', 'modelChange'));

    }
    public function actionEdit(){
        $dataProvider = new ActiveDataProvider([
           'query' => Questions::find(),
           'pagination' => [
               'pageSize' => 20,
           ]
        ]);
        $dataProvider2 = new ActiveDataProvider([
            'query' => Answer::find(),
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);
        return $this->render('question', ['dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2]);
    }
    public function actionUpdate($id){
        //нужно задействовать класс AddForm
        $model = Questions::findOne($id);
        $modelOne = $model->answer;
        if($modelOne[0]->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())){
            $modelOne[0]->save();
            $model->save();
        }

        return $this->render('edit', ['model'=> $model, 'modelOne' => $modelOne[0]]);
    }
    public function actionJournal(){
        $item = Journal::find()->all();
        return $this->render('journal',['applications'=> $item]);
    }
    public function actionAdd(){
        $model = new AddForm();
        //Сначала находим  id вопроса полсе которого нужно добавить вопрос
        // Используем класс AddForm
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
        return $this->render('add', ['model'=> $model]);
    }
}