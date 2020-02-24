<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\web\View;
use <?= ltrim($generator->modelClass, '\\').";\n" ?>

/* @var $this View */
/* @var $model <?= array_slice(explode('\\', $generator->modelClass), -1)[0] ?> */
/* @var $form ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form <?= '<?= ' ?> Yii::$app->request->isAjax ? '' : 'box box-primary' ?>">
    <?= "<?php " ?>$form = ActiveForm::begin(); ?>
    <div class="box-body no-padding">

<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        echo "        <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
    }
} ?>
    </div>
    <div class="box-footer">
        <?= "<?= " ?>Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i> ' . <?= $generator->generateString('Save') ?> : '<i class="fa fa-refresh"></i> ' . <?= $generator->generateString('Update') ?>, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?= "<?php " ?>ActiveForm::end(); ?>
</div>
