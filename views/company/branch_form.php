<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 11.01.2018
 * Time: 16:50
 */
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

Pjax::begin(['id' => 'banner-form']) ?>
<?php $form = ActiveForm::begin([
    'id' => 'banner-form',
    'options' => [
        'data-pjax' => true,
        'enctype' => 'multipart/form-data'
    ]
]);
?>
<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'file')
    ->fileInput([
        "accept"=>"image/*"
    ])
?>

<?= Html::submitButton(Yii::t('app', 'Create') , ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>