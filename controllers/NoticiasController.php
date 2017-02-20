<?php

namespace app\controllers;

use Yii;
use app\models\Noticia;
use app\models\TipoNoticia;
use app\models\NoticiaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Comentario;
use yii\filters\AccessControl;

/**
 * NoticiasController implements the CRUD actions for Noticia model.
 */
class NoticiasController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'delete', 'index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create','update', 'view', 'delete', 'index'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->esAdmin;
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'view'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return !Yii::$app->user->isGuest;
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Noticia models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NoticiaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Noticia model.
     * @param int $id
     * @return mixed
     */
    public function actionView($id)
    {
        $comentarioNuevo = new Comentario(['id_noticia' => $id]);

        if ($comentarioNuevo->load(Yii::$app->request->post())) {
            $comentarioNuevo->id_usuario = Yii::$app->user->id;
            $comentarioNuevo->id_noticia = $id;
            if ($comentarioNuevo->save()) {
                return $this->redirect(['../noticias/view', 'id' => $id]);
            }
        }


        $comentarios = Comentario::findAll(['id_noticia' => $id]);
        $numComentarios = count($comentarios);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'comentarios' => $comentarios,
            'numComentarios' => $numComentarios,
            'comentarioNuevo' => $comentarioNuevo,
        ]);
    }

    /**
     * Creates a new Noticia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Noticia();

        if ($model->load(Yii::$app->request->post())) {
            $model->id_usuario = Yii::$app->user->id;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $tipos = TipoNoticia::find()->select('tipo, id')->orderBy('tipo')->indexBy('id')->column();
            return $this->render('create', [
                    'model' => $model,
                    'tipos' => $tipos,
                ]);
        }
    }

    /**
     * Updates an existing Noticia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $tipos = TipoNoticia::find()->select('tipo, id')->orderBy('tipo')->indexBy('id')->column();
            return $this->render('update', [
                'model' => $model,
                'tipos' => $tipos,
            ]);
        }
    }

    /**
     * Deletes an existing Noticia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Noticia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Noticia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Noticia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
