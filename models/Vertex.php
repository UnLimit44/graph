<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 17.03.2019
 * Time: 21:18
 */

namespace app\models;


use yii\db\ActiveRecord;

class Vertex extends ActiveRecord
{
    // Получаем вершины
    public function getVertex(){
        return Vertex::find()->select(['name', 'id'])->indexBy('id')->column();
    }

    // Возвращаем имя вершины
    public function idToName($id)
    {
        $vertexName= $this->getVertex();
        return $vertexName[$id];
    }

    // Устанавливаем лейблы
    public function attributeLabels()
    {
        return
        [
            'name'=>'Добавить вершину',
            'id'=>'Удалить вершину'
        ];
    }

    // Условия
     public function rules()
    {
        return
        [
            ['name','required'],
            ['name','unique'],
            ['name','trim']
        ];
    }
}