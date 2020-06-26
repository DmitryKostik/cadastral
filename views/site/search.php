<?php
/** @var \app\models\SearchForm $searchModel */
/** @var \yii\data\ActiveDataProvider|false $plotsProvider */

use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin(['id' => 'contact-form', 'method' => "GET"]); ?>

    <?= $form->field($searchModel, 'egrns')->textInput(['autofocus' => true]) ?>

    <div class="form-group">
        <?= yii\helpers\Html::submitButton('Получить данные', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

<?= $plotsProvider ? GridView::widget([
    'dataProvider' => $plotsProvider,
    'columns' => [
        'egrn',
        'address',
        'formattedPrice',
        'formattedArea'
    ]
]) : ''; ?>
