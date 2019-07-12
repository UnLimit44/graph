<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 22.03.2019
 * Time: 18:58
 */
/**
 * КОНТРОЛЛЕР ДЛЯ ПОИСКА КОРОТКОГО ПУТИ
 */

namespace app\controllers;

use app\models\Vertex;
use yii\web\Controller;
use app\models\Graph;
use app\models\Node;
use app\models\Dijkstra;
use app\models\Edge;

class SearchController extends Controller
{
    public function actionIndex()
    {
        function printShortestPath($from_name, $to_name, $routes)
        {
            $graph = new Graph();
            foreach ($routes as $route) {
                $from = $route['from'];
                $to = $route['to'];
                $price = $route['price'];
                if (! array_key_exists($from, $graph->getNodes())) {
                    $from_node = new Node($from);
                    $graph->add($from_node);
                } else {
                    $from_node = $graph->getNode($from);
                }
                if (! array_key_exists($to, $graph->getNodes())) {
                    $to_node = new Node($to);
                    $graph->add($to_node);
                } else {
                    $to_node = $graph->getNode($to);
                }
                $from_node->connect($to_node, $price);
            }

            $g = new Dijkstra($graph);
            $start_node = $graph->getNode($from_name);
            $end_node = $graph->getNode($to_name);
            $g->setStartingNode($start_node);
            $g->setEndingNode($end_node);

            return "Из:" . $start_node->getId() . "\n". "в:" . $end_node->getId() . "\n". "Кротчайший путь: " . $g->getLiteralShortestPath() . "\n". "Сумма: " . $g->getDistance() . "\n";
        }

        $vertexObj = new Vertex();

        // Устанавливаются начало и конец, id переводится в имя
        $begin = $vertexObj->idToName($_POST["Edge"]["vertex_begin"]);
        $end = $vertexObj->idToName($_POST["Edge"]["vertex_end"]);

        $edgeObj = new Edge();
        // Генерируем граф
        $routes = $edgeObj->getGraph();

        // Поиск короткого пути
        $route = printShortestPath($begin, $end, $routes);
        return $this->redirect(['graph/index','route'=>$route]);


    }
}