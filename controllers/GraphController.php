<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 16.03.2019
 * Time: 18:37
 */
/**
 * ОСНОВНОЙ КОНТРОЛЛЕР
 *
 * СКРИПТ ДЛЯ ОТОБРАЖЕНИЯ В LAYOUTS
 */

namespace app\controllers;

use app\models\Edge;
use app\models\Vertex;
use yii\web\Controller;
use Yii;


class GraphController extends Controller
{
    // Применяем шаблон
    public $layout='default';


    public function actionCreate()
    {
        $vertexMod = new Vertex();

        // Создание вершины
        if ($vertexMod->load(Yii::$app->request->post())) {
            if ($vertexMod->save()) {
                return $this->redirect(['index']);
            }
            else
                {
                Yii::$app->session->setFlash('error', 'Ошибка');
            }
        }

        $edgeMod = new Edge();
        // Массив граней
        $edgeArr=Edge::find()->select(['id','vertex_1','vertex_2'])->asArray()->all();

        // Если грань уже существует, то обновить длину
        foreach ($edgeArr as $value){
            if (($value['vertex_1']==$_POST['Edge']['vertex_1']) and ($value['vertex_2']==$_POST['Edge']['vertex_2'])){
                return $this->redirect(['update','id'=> $value['id'], 'weight'=>$_POST['Edge']['weight']]);
            }
        }

        // Создание грани
        if ($edgeMod->load(Yii::$app->request->post())) {
            if ($edgeMod->save()) {
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка');
            }
        }
    }

    public function actionUpdate($id=null, $weight=null)
    {
        // Нахождение по id
        $edgeEdit = Edge::findOne($id);

        // присваиваем длину
        $edgeEdit->weight = $weight;
        $edgeEdit->save();

        return $this->redirect(['index']);
    }

    public function actionDelete()
    {

        if (!empty($_POST['Vertex']))
        {
            // Удаление вершины
            $customer = Vertex::findOne($_POST['Vertex']['id']);
            $customer->delete();

            // Проверка используется ли удаленная вершина среди граней
            $delEdge = Edge::find()->select(['id','vertex_1','vertex_2'])->asArray()->all();
            foreach ($delEdge as $value)
            {
                if (($_POST['Vertex']['id']==$value['vertex_1']) or ($_POST['Vertex']['id']==$value['vertex_2']))
                {
                    $delArr[]=$value['id'];
                }
            }
            // Если используется, то удаляем вршины
            if (!empty($delArr)){
                foreach ($delArr as $v){
                    $customer2 = Edge::findOne($v);
                    $customer2->delete();
                }
            }

            $this->redirect(['index']);
        }

        // Удаление грани
        if (!empty($_POST['Edge']))
        {
            $customer = Edge::findOne($_POST['Edge']['id']);
            $customer->delete();
            $this->redirect(['index']);
        }
    }

    public function actionIndex($route=null)
    {
        // Заголовок страницы
        $this->view->title='Graph';

        $vertexMod = new Vertex();
        $edgeMod = new Edge();

        // Массив вершин
        $vertexArr = $vertexMod->getVertex();

        // Массив граней
        $edge = $edgeMod->getEdges();
        // Массив для удаления граней
        foreach ($edge as $value) {
            $edgeArr[$value['id']]=$value['name_1'].'->'.$value['name_2'];
        }

        return $this->render('index', compact('edgeMod','edge', 'edgeArr', 'vertexMod','vertexArr', 'route'));
    }
}
