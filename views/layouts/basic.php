<?php

use app\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title>Document</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <div class="wrap">
        <div class="container">
            <ul class="nav nav-pills">
<!--                <li role="presentation" class="active">--><?php //= Html::a('Главная','/web/')?><!--</li>-->
                <li role="presentation" ><?= Html::a('Чат Бот ',['post/index'])?></li>
                <li role="presentation" ><?= Html::a(' Админ страница ',['post/show'])?></li>
            </ul>
            <?= $content?>
        </div>
    </div>
    
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>