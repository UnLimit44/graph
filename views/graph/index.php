<? use yii\widgets\ActiveForm;?>
<? use yii\helpers\Html;?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 gr-menu">
            <!--Меню-->
            <label class="control-label">Найти кратчайший путь</label>
            <?
            // Поиск кратчайшего пути
            $form = ActiveForm::begin(['action' => ['search/index']]);
            $params = [
                'prompt' => 'Первая вершина'
            ];
            $params2 = [
                'prompt' => 'Вторая вершина'
            ];
            echo $form->field($edgeMod, 'vertex_begin')->dropDownList($vertexArr,$params)->label(false);
            echo $form->field($edgeMod, 'vertex_end')->dropDownList($vertexArr,$params2)->label(false);
            echo Html::submitButton('Ок', ['class'=>"btn btn-success"]);
            ActiveForm::end();
            ?>
            <h5>
                <?
                // Отображение пути
                if (!empty($route)) {
                    echo $route;
                }?>
            </h5>

            <?
            // Добавить вершиу
            $form= ActiveForm::begin(['action' => ['graph/create']]);

            echo $form->field($vertexMod, 'name')->textInput(['maxlength' => 6]);
            echo Html::submitButton('Ок', ['class'=>"btn btn-success mb-2"]);

            ActiveForm::end();

            // Удалить вершиу
            $form= ActiveForm::begin(['action' => ['graph/delete']]);
            echo $form->field($vertexMod, 'id')->dropDownList(
                $vertexArr, ['prompt'=>'Укажите вершину']);
            echo Html::submitButton('Ок', ['class'=>"btn btn-success"]);
            ActiveForm::end();
            ?>

            <label class="control-label">Добавить грань</label>
            <?
            // Создание связи
            $form = ActiveForm::begin(['action' => ['graph/create']]);
            $params = [
                'prompt' => 'Первая вершина'
            ];
            $params2 = [
                'prompt' => 'Вторая вершина'
            ];
            echo $form->field($edgeMod, 'vertex_1')->dropDownList($vertexArr,$params)->label(false);
            echo $form->field($edgeMod, 'vertex_2')->dropDownList($vertexArr,$params2)->label(false);
            echo $form->field($edgeMod, 'weight');
            echo Html::submitButton('Ок', ['class'=>"btn btn-success"]);
            ActiveForm::end();

            //Удаление связи
            $form= ActiveForm::begin(['action' => ['graph/delete']]);
            echo $form->field($edgeMod, 'id')->dropDownList(
                $edgeArr, ['prompt'=>'Укажите грань']);
            echo Html::submitButton('Ок', ['class'=>"btn btn-success"]);
            ActiveForm::end();
            ?>
        </div>

        <!--Граф-->
        <div class="col-lg-8">
            <div id="graphContainer" style="position:relative;overflow:hidden;width:820px;height:500px;cursor:default;">
            </div>
            <!--Описание графа-->
            <?foreach ($vertexArr as $val):?>
            <?=$val;?>
            <?endforeach;?>
        <br>___________<br>
            <?foreach ($edge as $e):?>
                <?=$e['name_1'];?>
                <?=$e['name_2'];?>
                <?='=';?>
                <?=$e['weight'];?>
                <?=';     ';?>
            <?endforeach;?>
        </div>
    </div>
</div>

<?php
/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 16.03.2019
 * Time: 18:45
 */
