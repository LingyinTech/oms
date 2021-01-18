<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */


backend\assets\AppAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>
        <?php if($this->title) {echo Html::encode($this->title), ' | ';} ?>
        <?= Html::encode(app()->name) ?>
    </title>
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-blue sidebar-mini <?php if(isset($_COOKIE['sidebar-toggle-control'])):?>sidebar-collapse<?php endif;?>">
<?php $this->beginBody() ?>
<div class="wrapper">

    <?= $this->render(
        'header.php',
        ['directoryAsset' => $directoryAsset]
    ) ?>

    <?= $this->render('left.php') ?>

    <?= $this->render(
        'content.php',
        ['content' => $content]
    ) ?>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
