<?php

/* @var $this yii\web\View */

$this->title = 'Home Page';
?>


<div class="site-index">

    <div class="jumbotron">
      <?php  if (Yii::$app->user->isGuest) { ?>
        <h1>Welcome!</h1>
        <p class="lead">Hi,on this site you can get gift .</p>
        <p><a class="btn btn-lg btn-success" href="./signup">Signup NOW!</a></p>
       <?php } else { ?>
       	<h1>Try your luck NOW!</h1>
       	<span id="giftBtn" class="btn btn-danger">CLICK!</span>
       <?php } ?>
    </div>

    <div class="body-content">
        <div class="row">
            <?php if (!Yii::$app->user->isGuest) { ?>
                <div id="gift"></div>
				<center><img src="https://media3.giphy.com/media/3oEjI6SIIHBdRxXI40/200.gif" alt="" style="display: none;" id="loading"></center>
           	<?php } ?>
        </div>

    </div>
</div>
