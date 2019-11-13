<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Admin Secure Area';
?>
<h1>Movies:</h1>

<?php if (!empty($movies)): ?>
	<?php foreach ($movies as $movie): ?>


		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					<?= $movie->moviename ?>
				</h3>

				<a href="<?= Url::toRoute(['/site/viewmovie', 'id' => $movie->id]) ?>">[View Movie]</a>
				<a href="<?= Url::toRoute(['/site/movie', 'id' => $movie->id]) ?>">[Edit Movie]</a>
				<a onclick="return confirm('Deleting this movie and all related showtimes?');"
				   href="<?= Url::toRoute(['/site/delmovie', 'id' => $movie->id]) ?>">[Delete Movie]</a>
			</div>
            <div class="panel-body">
                <img width="150px" src="/admin/uploads/<?= $movie->photo ?>">
            </div>
		</div>
	<?php endforeach; ?>
<?php else: ?>
	Sorry, no show in DB!
<?php endif; ?>

<?= \yii\helpers\Html::a( 'Back', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>


