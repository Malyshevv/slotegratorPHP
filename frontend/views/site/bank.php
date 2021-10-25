<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Bank';

?>

<?php  if (Yii::$app->user->isGuest) { die('ошибка доступа'); }  ?>
<?php $this->params['breadcrumbs'][] = $this->title;?>


<div class="site-about">
    <h1 style="display: none;"><?= Html::encode($this->title) ?></h1>
	<div class="container" style="overflow: hidden;width: 100%;">
	
	<div class="row">
		
	<hr>
	
	<table class="table table-striped">
		<thead>
			<tr>
				<th>User Name</th>
				<th>Money</th>
				<th>Status</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($bankAll as $bank) { ?>
				<tr>
					<td><?=$bank['name']?></td>
					<td><?=$bank['money']?></td>
					<td><?=($bank['status'] == 0) ? 'waiting send' : 'sent'?></td>
					<?php if($bank['status'] == 0) { ?>
						<td><span class="startTransaction btn btn-info" key="<?=$bank['id']?>" userID="<?=$bank['id_user']?>">Send</span</td>
					<?php } ?>
				</tr>
			<?php } ?>	
		</tbody>
	</table>

	</div>
</div>


