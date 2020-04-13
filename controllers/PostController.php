<?php

namespace app\controllers;

use app\models\Comment;
use app\models\CommentSearch;
use app\models\PostTag;
use app\models\Tag;
use app\models\TagSearch;
use Codeception\Lib\Generator\Helper;
use Yii;
use app\models\Post;
use app\models\PostSearch;
use yii\filters\AccessControl;
use yii\helpers\StringHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $total = Post::find()->count();
        $limit = Yii::$app->params['showPostLimit'];
        $pages = ceil($total / $limit);
        $models = Post::find()
//            ->orderBy('created_at DESC')
            ->limit($limit)
            ->all();
        return $this->render('index', [
            'models' => $models,
            'total' => $total,
            'pages' => $pages
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        $searchModel = new CommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $commentModel = new Comment();

        if ($commentModel->load(Yii::$app->request->post()) && $commentModel->save()) {
            $post = $this->findModel($slug);
            return $this->redirect(['view', 'slug' => $post->slug]);
        }


        return $this->render('view', [
            'model' => $this->findModel($slug),
            'dataProvider' => $dataProvider,
            'commentModel' => $commentModel
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();
        $request = Yii::$app->request->post();
        $tags = array();
        if ($request) {
            if (isset($request['tags']) AND !empty($request['tags']))
            {
                $tags = explode(',', $request['tags']);
            }

        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $ids = array();
            foreach ($tags as $item) {
                $tagName = strtolower(trim($item));
                $newTag = Tag::find()->where(['name' => $tagName])->limit(1)->exists();
                if( !$newTag ) {
                    $tag = new Tag();
                    $tag->name = $tagName;
                    $tag->slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $tagName);
                    $tag->save();
                    $ids[] = $tag->id;
                } else {
                    $oldTag = Tag::findOne(['name' => $tagName]);
                    $ids[] = $oldTag->id;
                }
            }

            if (count($ids)) {
                foreach ($ids as $tag_id) {
                    $postTag = new PostTag();
                    $postTag->post_id = $model->id;
                    $postTag->tag_id = $tag_id;
                    $postTag->save();
                }
            }

            return $this->redirect(['view', 'slug' => $model->slug]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($slug)
    {
        $model = $this->findModel($slug);

        $request = Yii::$app->request->post();

        if ($request) {
            if (isset($request['tags']) AND !empty($request['tags']))
            {
                $postTags = explode(',', $request['tags']);

                //TODO: Update Tags
            }

        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'slug' => $model->slug]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($slug)
    {
        $model = $this->findModel($slug);
        $model->delete();

        //TODO: Post Tags Delete

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($slug)
    {
        if (($model = Post::findOne(['slug'=> $slug])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
