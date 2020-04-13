<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$tags = '';
if ($model->id) {
    if ($model->tags) {
        $tags = array();
        foreach ($model->tags as $tag) {
            $tags[] = $tag->name;
        }
        $tags = implode(',', $tags);
    }
}
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'title')->textInput() ?>

    <?= $form->field($model, 'slug')->textInput() ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <div class="form-group field-post-slug">
        <label class="control-label" for="post-tags">Tags</label>
        <input type="text" value="<?php echo $tags; ?>" name="tags" id="post-tags" data-role="tagsinput">
        <div class="help-block"></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-style']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
