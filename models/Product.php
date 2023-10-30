<?php

namespace app\models;
use yii\db\ActiveRecord;


class Product extends ActiveRecord
{
    public static function tableName()
    {
        return 'Product';
    }
//
//    public function  getCategories(){
//        return $this->hasOne(Category::className(), ['id' => 'age']);
//    }

}