<h1>SHOW ACTION</h1>

<?php //$this->registerJsFile('@web/js/script.js', ['depends' => 'yii\web\YiiAsset'])?>
<button class="btn btn-success" id="btn">Click me</button>
<?php
//debug($cats);
?>
<?php
//echo count($cats[0]->product)
?>
<?php
//debug($cats);
?>
<?php
foreach ($cats as $cat){
    echo '<ul>';
     echo '<li>' . $cat->position . '</li>';
     $products = $cat->product;
     foreach ($products as $product){
         echo '<ul>';
          echo '<li>' . $product->options . '</li>';
         echo '</ul>';
     }
    echo '</ul>';
}
?>

<?php 
// $js = <<<JS 
// $('#btn').on('click',function(){
//     $.ajax({
//         url: 'index.php?r=post/index',
//         data: {test:'123'},
//         type: 'POST',
//         success: function(res){
//             console.log(res);
//         }
//         error: function(){
//             alert('Erorrrr');
//         }
//     });
// });
// JS;

//$this->registerJs($js);
$this->registerJs("$('#btn').on('click',function(){
    $.ajax({
        url: 'index.php?r=post/index',
        data: {test:'123'},
        type: 'POST',
        success: function(res){
            console.log(res);
        },
        error: function(){
            alert('Erorrrr');
        }
    });
});");
?>
