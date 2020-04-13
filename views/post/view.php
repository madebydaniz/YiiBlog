<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<header class="masthead" style="background-image: url('https://source.unsplash.com/random/1900x1267')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="post-heading">
                    <h1><?= Html::encode($this->title) ?></h1>
                    <span class="meta">Posted by
                        <?php echo $model->createdBy->username;?>
                          on
                        <?php echo Yii::$app->formatter->asRelativeTime($model->created_at); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</header>

<article>
    <div class="container">
        <?php if (! Yii::$app->user->isGuest): ?>
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <p>
                    <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success btn-style']) ?>
                    <?= Html::a('Update', ['update', 'slug' => $model->slug], ['class' => 'btn btn-primary btn-style']) ?>
                    <?= Html::a('Delete', ['delete', 'slug' => $model->slug], [
                        'class' => 'btn btn-danger btn-style',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">



                <?php echo Html::encode($model->content); ?>
                <?php if ($model->tags): ?>
                    <div class="tags">
                        <p>Tags:</p>
                            <ul>
                                <?php foreach ($model->tags as $tag): ?>
                                    <li>
                                        <a href="<?php echo Url::to(['/tag/view', 'id' => $tag->id]); ?>">
                                            <?php echo Html::encode($tag->name); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</article>

