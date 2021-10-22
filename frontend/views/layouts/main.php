<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="gd9mFD75nLcbD4bmbPvf_tZX6vlcWVw6oqZnaqrPoEo" />
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
			

	    	$username = Yii::$app->user->identity->username;
	    	$id_user = Yii::$app->user->identity->id;
	    	$avatar_user = Yii::$app->user->identity->avatar;
	    		#$menuItems[] =  '<li><a href="/profile?id='.$id_user.'">Профиль</a></li>';
	    	$menuItems[] =  [
		    	'encode'=>false,
		    	'label' => '<span id="nickname">'.$username.'</span><img class="img-circle" width="30" height="30" src="'.$avatar_user.'">', 
		    	'url' => ['/site/profile'], 
		    	'options'=>['class'=>'profile_link dropdown'],
		    	'items' => [
		    		['label' => 'Профиль', 'url' => './profile'],
		    		['encode'=>false, 'label' => '<li>'
		        . Html::beginForm(['/site/logout'], 'post')
		        . Html::submitButton(
		            'Выход (' . Yii::$app->user->identity->username . ')',
		                ['class' => 'btn btn-link logout']
		            )
		        . Html::endForm()
		        . '</li>', 'url' => ''],
		    	]
	    	];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>

</body>
</html>

<?php $this->endPage() ?>

