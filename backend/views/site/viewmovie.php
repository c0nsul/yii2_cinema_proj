<?php

/* @var $this yii\web\View */

$this->title = 'Admin Secure Area';
?>

<h1>View Movie:</h1>

Name: <?= $model->moviename ?></br></br>
Description: <?= $model->desc ?></br></br>
Age: <?= $model->age ?>+</br></br>
Lenght: <?= $model->playtime ?> min</br></br>
<img width="250px" src="../uploads/<?= $model->photo ?>">

