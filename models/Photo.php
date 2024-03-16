<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;

class Photo extends ActiveRecord
{
  //  public $file;
    public static function tableName()
    {
        return 'photo';
    }
    public function rules()
    {
        return [
            //...
            [['file'], 'required'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function addPhoto($model){
        if (Yii::$app->request->isPost){
            $model->load(Yii::$app->request->post());
            $model->file = UploadedFile::getInstance($model, 'file');
            //$model->file = $model->file->baseName;
            //$model->file->saveAs("img/{$model->file->baseName}.{$model->file->extension}");
            $model->save(false);
        }
    }


}