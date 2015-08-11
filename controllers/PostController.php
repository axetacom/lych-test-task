<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use app\models\Post;
use app\models\Comment;

class PostController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['view', 'comment'],
                        'allow' => true,
                        'roles' => ['@','?'],
                    ],
                    [
                        'actions' => ['create', 'edit'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionView($id)
    {
        return $this->render('view', $this->getPostWithComments($id));
    }
    
    public function actionComment($post)
    {
        $data = $this->getPostWithComments($post);
        $data['comment']->post = $data['post']->id;
        if ($data['comment']->load(Yii::$app->request->post()) && $data['comment']->save())
            return $this->redirect(['view', 'id' => $data['post']->id]);
        else
            return $this->render('view', $data);
    }
    
    protected function getPostWithComments($id)
    {
        $post = $this->findModel($id, true);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $post->comments,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return ['post' => $post, 'dataProvider' => $dataProvider, 'comment' => new Comment()];
    }

    public function actionCreate()
    {
        $model = new Post();
        if ($model->load(Yii::$app->request->post()) && $model->save())
            return $this->redirect(['view', 'id' => $model->id]);
        else
            return $this->render('create', ['model' => $model]);
    }

    public function actionEdit($id)
    {
        $model = $this->findModel($id);
        if (!Yii::$app->user->identity->isAdmin && $model->user != Yii::$app->user->id)
            throw new ForbiddenHttpException('Вы не можете редактировать эту статью.');
        if ($model->load(Yii::$app->request->post()) && $model->save())
            return $this->redirect(['view', 'id' => $model->id]);
        else
            return $this->render('edit', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['site/index']);
    }

    protected function findModel($id, $withComments = false)
    {
        $related = ['user0'];
        if ($withComments)
            $related[] = 'comments.user0';
        $model = Post::find()->with($related)->where(['id' => $id])->one();
        if ($model !== null)
            return $model;
        else
            throw new NotFoundHttpException('Запрошенная статья не найдена.');
    }
}
