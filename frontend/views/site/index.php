<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>

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
