<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Profile';

?>

<?php  if (Yii::$app->user->isGuest) { die('ошибка доступа'); }  ?>
<?php $this->params['breadcrumbs'][] = $this->title; ?>
<!-- Modal -->

<div class="modal fade" id="exampleModalBank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h5 class="modal-title" id="exampleModalLabel">Withdraw money on visa/MasterCard</h5>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	    <div class="modal-body">
			<form>
				<p>Your can  withdraw money: <?=$getAll['cash']?> $</p>
				<input class="form-control"  type="number" value="" id="bank_send" name="bank_send" placeholder="Enter how much withdraw" required>
				<br>
				<span class="bank_send_btn btn btn-info">Send!</span>
			</form>
		</div>
		 <div class="modal-footer">
		    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		  </div>
	  </div>
	</div>
</div>

<div class="modal fade" id="exampleModalConvert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h5 class="modal-title" id="exampleModalLabel">Convert Money to Points / Convert Points to Money</h5>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	    <div class="modal-body">
			<form>
				<p><input id="convertcash" type="checkbox" name="cash" balance="<?=$getAll['cash']?> "> I want convert money to points: <?=$getAll['cash']?> $</p>
				<p><input id="convertpoint" type="checkbox" name="Points" balance="<?=$getAll['Points']?>"> I want  convert ponts to money: <?=$getAll['Points']?> p.</p>
				
				<input type="hidden" class="form-control" id="sumConvert" name="convert">
				<input type="number" class="form-control" id="convert" name="convert" placeholder="Enter how much withdraw" required>
				<br>
				
				<p>You get on your blanace: <span id="yourGet"><b></b></span></p>
				
				<br>
				<span class="cashConvert btn btn-info" id="cashConvert'" disabled="disabled">Send!</span>
			</form>
		</div>
		 <div class="modal-footer">
		    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		  </div>
	  </div>
	</div>
</div>
<!--END Modal -->


<div class="site-about">
	<div class="container" style="overflow: hidden;width: 100%;">
	
	<div class="row">
		
		<img src="<?=$getAll['avatar']?>" style="width: 150px;margin-right: 10px;" align="left">	
		<h2><?=$getAll['username']?></h2>
		<p>User type: <?=$getAll['type']?></p>
		<?php
			if($getAll['type'] == 'admin') {
				print '<a href="./manager" class="btn btn-primary" style="float: right;">Manager WOW Gift</a>  
				<a href="./bank" class="btn btn-primary" style="float: right; margin-right: 15px;">Bank</a> 
				';
			}
		?>
		<p>Total gifts: <?=count($getGift);?></p>

		<p>Money: <?=$getAll['cash']?> $ 
			<span style="color: blue; cursor: pointer;" data-toggle="modal" data-target="#exampleModalBank">
				<u><i>Withdraw money on visa/MasterCard</i></u>
			</span>
			<span style="color: orange; cursor: pointer;" data-toggle="modal" data-target="#exampleModalConvert">
				<u><i>Convert to points</i></u>
			</span>
		</p>

		<p>Ponts: <?=$getAll['Points']?> p. 
			<span style="color: blue; cursor: pointer;" data-toggle="modal" data-target="#exampleModalConvert">
			<u><i>Convert to money</i></u>
		</p>
	</div>
	<hr>
	
	<?php
		if(count($getGift) > 0) {
			foreach ($getGift as $keyGift) {
				switch($keyGift['send']) {
					case 0:
						$stauts = '<b style="color:red;">waitng send..</b>';
					break;
					case 1:
						$stauts = '<b style="color:green;">Received</b>';
					break;
				}
			
				print '<div class="alert alert-info" style="font-size:17pt;">
					<img 
						src="'.$keyGift['img'].'" 
						width="40" 
						align="left"
					>
					'.$keyGift['name'].'('.$keyGift['quantity'].') - Status ('.$stauts.')
				</div>';	
			}
		}
		else {
			echo "<i>Gifts have not yet been received</i>";
		}
		
	?>

	</div>
</div>


