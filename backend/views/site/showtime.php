<?php

use common\models\Movie;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin(); ?>

<?php if (!empty($model->id)):

	$type = 'Update';
	?>
    <h1>Edit show</h1>

<?php
else:

	$type = 'Send';
	?>
    <h1>Add new show</h1>

<?php endif; ?>

<?php echo $form->field($model, 'movie_id')->dropdownList(
	Movie::find()->select(['moviename', 'id'])->indexBy('id')->column(),
	['prompt' => 'Select movie']
);
?>


<?= $form->field($model, 'date')->widget(yii\jui\DatePicker::className()) ?>

<?php
$parameters = [
	'10' => '10:00',
	'12' => '12:00',
	'14' => '14:00',
	'16' => '16:00',
	'18' => '18:00',
	'20' => '20:00',
	'22' => '22:00',
];

echo $form->field($model, 'time')->dropdownList($parameters, ['prompt' => 'Select time']);
?>

<?= $form->field($model, 'price') ?>
    <div class="form-group">
		<?= Html::submitButton($type, ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>