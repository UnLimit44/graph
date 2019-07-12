<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 18.03.2019
 * Time: 20:24
 */

namespace app\models;


use yii\db\ActiveRecord;
use yii;

class Edge extends ActiveRecord
{

    public $vertex_begin;
    public $vertex_end;

    // Получение граней, объединение таблиц где id вершин заменяются их именами
    public function getEdges(){
        $query = 'SELECT edge.id, vertex1.name AS name_1,
                vertex2.name AS name_2, edge.weight  FROM edge 
                LEFT JOIN vertex as vertex1 ON (vertex1.id=edge.vertex_1) 
                LEFT JOIN vertex as vertex2 ON (vertex2.id=edge.vertex_2)';
        return Yii::$app->db->createCommand($query)->queryAll();
    }

    // Создаём массив граней, потятный для последующей обработки
    public function getGraph() {
        $graph = null;

        $arr = $this->getEdges();

        foreach ($arr as $value)
        {
            $graph[]=array('from'=>$value['name_1'], 'to'=>$value['name_2'], 'price'=> (int) $value['weight']);
        }

        return $graph;
    }

    // Задаем лейблы
    public function attributeLabels()
    {
        return
            [
                'id'=>'Удалить грань',
                'vertex_1'=>'От',
                'vertex_2'=>'До',
                'weight'=>'Укажите длину',
                'vertex_begin'=>'От',
                'vertex_end'=>'До'
            ];
    }

    // Условия
    public function rules()
    {
        return
            [
                ['vertex_1','safe'],
                ['vertex_2','safe'],
                ['weight', 'trim'],
                ['weight', 'required'],
                // Длина больше 0
                ['weight','compare','compareValue' => 0, 'operator' => '>'],
                // Вершина 1 не равна вершине 2 и наоборот
                ['vertex_1', 'compare','compareAttribute' => 'vertex_2', 'operator' => '!=='],
                ['vertex_2', 'compare','compareAttribute' => 'vertex_1', 'operator' => '!=='],
                ['vertex_begin', 'compare','compareAttribute' => 'vertex_end', 'operator' => '!=='],
                ['vertex_end', 'compare','compareAttribute' => 'vertex_begin', 'operator' => '!=='],
            ];
    }


}