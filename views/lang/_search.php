<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LangSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lang-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'local') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'logo') ?>

    <?php // echo $form->field($model, 'default') ?>

    <?php // echo $form->field($model, 'date_update') ?>

    <?php // echo $form->field($model, 'date_create') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
