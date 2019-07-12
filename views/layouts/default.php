<?php

use yii\helpers\Html;
use app\assets\AppAsset;
use app\models\Vertex;
use app\models\Edge;


AppAsset::register($this);

// Получаем вершины и грани
$vertexMod = new Vertex();
$allVertex = $vertexMod->getVertex();
$edgeMod = new Edge();
$allEdge = $edgeMod->getEdges();

$vertexVar=null;

foreach ($allVertex as $value)
{
    // Генерируем координаты вершин
    $x=rand(60, 780);
    $y=rand(60, 440);
    // JavaScript: отображение вершин
    $vertexVar=$vertexVar."var v$value = graph.insertVertex(parent, null, '$value', $x, $y, 30, 30);";

}

$edgeVar=null;
foreach ($allEdge as $value){
    // JavaScript: отображение граней
    $edgeVar=$edgeVar."var e".$value['id']." = graph.insertEdge(parent, null, '".$value['weight']."', v".$value['name_1'].", v".$value['name_2'].");";
}


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="UTF-8">
    <title><?= Html::encode($this->title) ?></title>
    <!-- Задает basepath для библиотеки, если не в том же каталоге -->
    <script type="text/javascript">
        mxBasePath = '../src';
    </script>
    <!-- Загрузка и инициализация библиотеки -->
    <script type="text/javascript" src="/web/js/mxClient.min.js"></script>
    <!-- Сам код -->
    <script type="text/javascript">
        function main(container)
        {
            // Проверяет, поддерживается ли браузер
            if (!mxClient.isBrowserSupported())
            {
                // Отображает сообщение об ошибке, если браузер не поддерживается.
                mxUtils.error('Browser is not supported!', 200, false);
            }
            else
            {
                // Отключает встроенное контекстное меню
                mxEvent.disableContextMenu(container);

                // Создает граф внутри данного контейнера
                var graph = new mxGraph(container);

                // Позволяет выбор моделей (Enables rubberband selection)
                new mxRubberband(graph);

                // Получает родительский элемент по умолчанию для вставки новых ячеек.
                //  Он обычно является первым дочерним элементом корня (т. е. слой 0).
                var parent = graph.getDefaultParent();

                // Добавление ячеек в модель за один шаг
                graph.getModel().beginUpdate();
                try
                {
                    <?=$vertexVar?>
                    <?=$edgeVar?>
                }
                finally
                {
                    // Обновляет экран
                    graph.getModel().endUpdate();
                }
            }
        };
    </script>
    <?php $this->head() ?>
</head>
<body  onload="main(document.getElementById('graphContainer'))">
<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>