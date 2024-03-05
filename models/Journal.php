<?php

namespace app\models;

use yii\db\ActiveRecord;

class Journal extends ActiveRecord
{
    public static function tableName()
    {
        return 'journal';
    }

    public function createNew(){
            $item =new Journal();
            $item->text = "Заявка: ";
            $item->save(false);
    }
    public function addNumber($num){
        $lastItem = $this->getLastItem();
        $lastItem->number = $num;
        $lastItem->save();
    }

    public function addText($text){
        $lastItem = $this->getLastItem();
        $lastItem->text = $text;
        $lastItem->date = date('l jS \of F Y h:i:s A');
        $lastItem->save();
    }
    public function addRoom($room){
        $lastItem = $this->getLastItem();
        $lastItem->room = $room;
        $lastItem->save();
    }
    public function addDate(){
        $lastItem = $this->getLastItem();
//        $lastItem->room = $room;
        $lastItem->save();
    }
    public function addWorker($id){
        $lastItem = $this->getLastItem();
        $lastItem->id_worker = $id;
        $lastItem->save();
    }

    public function getLastItem(){
        $count = Journal::find()
            ->count();
        $lastItem = Journal::find()
            ->where(['id' => $count])
            ->one();
        return $lastItem;
    }

}