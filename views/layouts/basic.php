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
    <title>Chat Bot 97</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <div class="wrap">
        <div class="container">
<!--            <ul class="nav nav-pills">-->
<!--                <li class="nav-item">--><?php //= Html::a('Чат Бот ',['post/index'])?><!--</li>-->
<!--                <li class="nav-item">--><?php //= Html::a(' Админ страница ',['post/show'])?><!--</li>-->
<!--                <li class="nav-item" >--><?php //= Html::a(' Журнал ',['post/show'])?><!--</li>-->
<!--                <li class="nav-item" ><a class="nav-link active" href="show">Exapmle</a></li>-->
<!--            </ul>-->

            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" href="index">Чат Бот</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="show">Админ страница</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="edit">Админ страница 2</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link " href="journal">Журнал</a>
                </li>
            </ul>
            <?= $content?>
        </div>
    </div>
    
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>