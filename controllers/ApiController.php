<?php


namespace app\controllers;

use app\models\Post;
use Yii;
use yii\db\conditions\LikeCondition;
use yii\rest\ActiveController;

class ApiController extends ActiveController
{
    public $modelClass = 'app\models\PostSearch';

    public function actions()
    {
        $action= parent::actions();
        unset($action['index']);
        unset($action['create']);
        unset($action['update']);
        unset($action['delete']);
    }

    public function actionSearch($keyword)
    {
        return Post::find()
            ->where(['like', 'title', $keyword])
            ->select('title, slug')
            ->asArray()
            ->all();
    }

    public function actionGetpost($pagenumber)
    {
        $total = Post::find()->count();

        $limit = Yii::$app->params['showPostLimit'];
        $pages = ceil($total / $limit);
        $page = min($pages, $pagenumber);
        $offset = ($page - 1) * $limit;

        $start = $offset + 1;
        $end = min(($offset + $limit), $total);

        if ( $pages >= $page AND $page == $pagenumber )
        {
            $models = Post::find()
//                ->orderBy('created_at DESC')
                ->limit($limit)
                ->offset($offset)
                ->all();

            $html = '';
            foreach ($models as $model) {
                $html .= $this->renderPartial('//post/_ajax_post_item', ['model'=>$model]);
            }

            return $html;
        } else {
            return '';
        }

    }
}