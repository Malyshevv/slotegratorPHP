<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Manager Gift';
$this->params['breadcrumbs'][] = $this->title;

?>

<?php  if (Yii::$app->user->isGuest) { die('ошибка доступа'); }  ?>



<div class="site-about">
    <h1 style="display: none;"><?= Html::encode($this->title) ?></h1>
	<div class="container" style="overflow: hidden;width: 100%;">
	
	<div class="row">
	<hr>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>User Name</th>
					<th>Adress</th>
					<th>Status</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($getGift as $gift) { ?>
					<tr>
						<td><?=$gift['name']?></td>
						<td><?=$gift['adress']?></td>
						<td><?=($gift['status'] == 0) ? 'waiting send' : 'sent'?></td>
						<?php if($gift['status'] == 0) { ?>
							<td><span class="sendGiftPost btn btn-info" key="<?=$gift['userhasgift_id']?>">Send</span</td>
						<?php } ?>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>



