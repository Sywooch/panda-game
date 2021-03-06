<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Achievements */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="achievements-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'name_th')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description_ru')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'description_en')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'description_th')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'reward')->textInput() ?>

    <?= $form->field($model, 'status_achievement')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
