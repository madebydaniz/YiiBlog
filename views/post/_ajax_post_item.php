<?php
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
?>

<div class="post-preview">
    <a href="<?php echo Url::to(['/post/view', 'slug' => $model->slug]); ?>">
        <h2 class="post-title">
            <?php echo Html::encode($model->title); ?>
        </h2>
        <h3 class="post-subtitle">
            <?php echo StringHelper::truncateWords( Html::encode( $model->content ) , 20 );?>
        </h3>
    </a>
    <p class="post-meta">Posted by
        <?php echo $model->createdBy->username;?>
        on
        <?php echo Yii::$app->formatter->asRelativeTime($model->created_at); ?>
    </p>
</div>