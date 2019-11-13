<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>


<?php if (!empty($model->id)):

	$type = 'Update';
	if ($model->photo) {
		$oldImg = "<img  width='250px' src='/admin/uploads/{$model->photo}'>";
	} else {
		$oldImg = null;
	}
	?>
    <h1>Edit movie</h1>

<?php
else:

	$type = 'Send';
	$oldImg = null;
	?>
    <h1>Add new movie</h1>

<?php endif; ?>


<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'moviename')->label('Name') ?>

<?= $form->field($model, 'playtime')->label('Lenght, mins') ?>

<?= $form->field($model, 'desc')->textarea()->label('Description') ?>

<?php
$parameters = [
	'6' => '6+',
	'8' => '8+',
	'10' => '10+',
	'12' => '12+',
	'16' => '16+',
	'18' => '18+',
];

echo $form->field($model, 'age')->dropDownList($parameters, ['prompt' => 'Select age']);
?>

<?= $form->field($model, 'photo')->fileInput()->label('Movie photo (jpg/png)') ?>
<?= $oldImg ?>
    <br><br>
    <div class="form-group">
		<?= Html::submitButton($type, ['class' => 'btn btn-danger']) ?>
		<?= Html::a('Back', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>