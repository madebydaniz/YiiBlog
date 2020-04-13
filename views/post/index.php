<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<header class="masthead" style="background-image: url('https://source.unsplash.com/random/1900x1267')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h1>Interview Blog</h1>
                    <span class="subheading">A simple Blog</span>
                </div>
            </div>
        </div>
    </div>
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
            <?php foreach ($models as $model): ?>
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

            <div id="ajax-posts-container"></div>

            <?php if ($total > count($models) ): ?>
                <div class="container text-center">
                    <a class="df-load-more" data-total="<?php echo $total;?>" data-totalpage="<?php echo $pages; ?>" data-page="2">
                        <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                        <span class="text">Load More</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>