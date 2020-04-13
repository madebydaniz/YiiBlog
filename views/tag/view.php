<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tag */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<header class="masthead" style="background-image: url('https://source.unsplash.com/random/1900x1267')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h1>Tag: <?= Html::encode($this->title) ?></h1>
                </div>
            </div>
        </div>
    </div>
    <?php if (! Yii::$app->user->isGuest): ?>
    <div class="action-wrapper">
        <?= Html::a('Update Tag', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-style']) ?>
        <?= Html::a('Delete Tag', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-style',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </div>
    <?php endif; ?>
</header>




<div class="container">

    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="search-wrapper">

                <div class="search-input">
                    <input id="txt_search" name="txt_search" type="text" placeholder="Type Keywords">
                    <div class="icon-wrap">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 20 20">
                            <path d="M18.869 19.162l-5.943-6.484c1.339-1.401 2.075-3.233 2.075-5.178 0-2.003-0.78-3.887-2.197-5.303s-3.3-2.197-5.303-2.197-3.887 0.78-5.303 2.197-2.197 3.3-2.197 5.303 0.78 3.887 2.197 5.303 3.3 2.197 5.303 2.197c1.726 0 3.362-0.579 4.688-1.645l5.943 6.483c0.099 0.108 0.233 0.162 0.369 0.162 0.121 0 0.242-0.043 0.338-0.131 0.204-0.187 0.217-0.503 0.031-0.706zM1 7.5c0-3.584 2.916-6.5 6.5-6.5s6.5 2.916 6.5 6.5-2.916 6.5-6.5 6.5-6.5-2.916-6.5-6.5z"></path>
                        </svg>
                    </div>
                </div>
                <ul id="searchResult"></ul>
                <div class="clear"></div>
                <div id="userDetail"></div>
            </div>
        </div>
    </div>

    <?php if (! Yii::$app->user->isGuest): ?>
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto mt-4">
                <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success btn-style']) ?>
                <?php echo Html::a('Manage Tags', '/tag', ['class' => 'btn btn-primary btn-style'])?>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <?php foreach ($queryPosts as $model): ?>
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
            <?php endforeach; ?>
        </div>
    </div>
</div>
