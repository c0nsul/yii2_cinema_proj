<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Admin Secure Area';
?>


<a href="<?= Url::toRoute(['/site/movie']) ?>" class="btn btn-link logout">Add Movie</a>
<br>
<a href="<?= Url::toRoute(['/site/showtime']) ?>" class="btn btn-link logout">Add ShowTime</a>
<br>
<br><br>
<h1>ShowTime listing:</h1>

<?php if (!empty($shows)): ?>
	<?php foreach ($shows as $show): ?>


        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
					<?= $show->movie->moviename ?>
                </h3>

                <span style="float: right"><?= date("d-m-Y", $show->date) ?></span>
                <br>
                <a href="<?= Url::toRoute(['/site/showtime', 'id' => $show->id]) ?>">[Edit Show]</a>
                <a onclick="return confirm('Deleting this show?');"
                   href="<?= Url::toRoute(['/site/delshow', 'id' => $show->id]) ?>">[Delete Show]</a>

                --

                <a href="<?= Url::toRoute(['/site/viewmovie', 'id' => $show->movie_id]) ?>">[View Movie]</a>
                <a href="<?= Url::toRoute(['/site/movie', 'id' => $show->movie_id]) ?>">[Edit Movie]</a>
                <a onclick="return confirm('Deleting this movie and all related showtimes?');"
                   href="<?= Url::toRoute(['/site/delmovie', 'id' => $show->movie_id]) ?>">[Delete Movie]</a>
            </div>
            <div class="panel-body">
                <span style="float: right">Show time: <?= $show->time . ":00" ?></span>

                Price: <?= $show->price ?> rub<br/>
                Lenght: <?= $show->movie->playtime ?> min
            </div>
            <div class="panel-body">
                Poster: <img width="250px" src="/admin/uploads/<?= $show->movie->photo ?>">
            </div>
        </div>
	<?php endforeach; ?>
<?php else: ?>
    Sorry, no show in DB!
<?php endif; ?>
