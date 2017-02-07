[1mdiff --git a/controllers/NoticiasController.php b/controllers/NoticiasController.php[m
[1mindex 090127e..4443061 100644[m
[1m--- a/controllers/NoticiasController.php[m
[1m+++ b/controllers/NoticiasController.php[m
[36m@@ -4,6 +4,7 @@[m [mnamespace app\controllers;[m
 [m
 use Yii;[m
 use app\models\Noticia;[m
[32m+[m[32muse app\models\TipoNoticia;[m
 use app\models\NoticiaSearch;[m
 use yii\web\Controller;[m
 use yii\web\NotFoundHttpException;[m
[36m@@ -34,12 +35,20 @@[m [mclass NoticiasController extends Controller[m
                 'rules' => [[m
                     [[m
                         'allow' => true,[m
[31m-                        'actions' => ['update', 'view', 'delete', 'index'],[m
[32m+[m[32m                        'actions' => ['create','update', 'view', 'delete', 'index'],[m
                         'roles' => ['@'],[m
                         'matchCallback' => function ($rule, $action) {[m
                             return Yii::$app->user->esAdmin;[m
                         }[m
                     ],[m
[32m+[m[32m                    [[m
[32m+[m[32m                        'allow' => true,[m
[32m+[m[32m                        'actions' => ['create', 'view'],[m
[32m+[m[32m                        'roles' => ['@'],[m
[32m+[m[32m                        'matchCallback' => function ($rule, $action) {[m
[32m+[m[32m                            return !Yii::$app->user->isGuest;[m
[32m+[m[32m                        }[m
[32m+[m[32m                    ],[m
                 ],[m
             ],[m
         ];[m
[36m@@ -85,13 +94,18 @@[m [mclass NoticiasController extends Controller[m
     public function actionCreate()[m
     {[m
         $model = new Noticia();[m
[32m+[m[32m        $tipos = TipoNoticia::find()->all();[m
 [m
[31m-        if ($model->load(Yii::$app->request->post()) && $model->save()) {[m
[31m-            return $this->redirect(['view', 'id' => $model->id]);[m
[32m+[m[32m        if ($model->load(Yii::$app->request->post())) {[m
[32m+[m[32m            $model->id_usuario = Yii::$app->user->id;[m
[32m+[m[32m            if ($model->save()) {[m
[32m+[m[32m                return $this->redirect(['view', 'id' => $model->id]);[m
[32m+[m[32m            }[m
         } else {[m
             return $this->render('create', [[m
[31m-                'model' => $model,[m
[31m-            ]);[m
[32m+[m[32m                    'model' => $model,[m
[32m+[m[32m                    'tipos' => $tipos,[m
[32m+[m[32m                ]);[m
         }[m
     }[m
 [m
[36m@@ -105,11 +119,14 @@[m [mclass NoticiasController extends Controller[m
     {[m
         $model = $this->findModel($id);[m
 [m
[32m+[m
         if ($model->load(Yii::$app->request->post()) && $model->save()) {[m
             return $this->redirect(['view', 'id' => $model->id]);[m
         } else {[m
[32m+[m[32m            $tipos = TipoNoticia::find()->all()->indexBy('id')->column();[m
             return $this->render('update', [[m
                 'model' => $model,[m
[32m+[m[32m                'tipos' => $tipos,[m
             ]);[m
         }[m
     }[m
[1mdiff --git a/views/noticias/_form.php b/views/noticias/_form.php[m
[1mindex 87a0821..eae68c9 100644[m
[1m--- a/views/noticias/_form.php[m
[1m+++ b/views/noticias/_form.php[m
[36m@@ -11,16 +11,15 @@[m [muse yii\widgets\ActiveForm;[m
 <div class="noticia-form">[m
 [m
     <?php $form = ActiveForm::begin(); ?>[m
[31m-[m
[32m+[m[41m    [m
     <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>[m
 [m
     <?= $form->field($model, 'cuerpo')->textarea(['rows' => 6]) ?>[m
 [m
     <?= $form->field($model, 'enlace')->textInput(['maxlength' => true]) ?>[m
 [m
[31m-    <?= $form->field($model, 'tipo_noticia')->textInput() ?>[m
[32m+[m[32m    <?= $form->field($model, 'tipo_noticia')->dropDownList($tipos) ?>[m
 [m
[31m-    <?= $form->field($model, 'id_usuario')->textInput() ?>[m
 [m
     <div class="form-group">[m
         <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>[m
