<?php 

use yii\helpers\Url;
use yii\helpers\Html;
?>

<h1>Formulario</h1>
<h2> <?= $mensaje ?></h2>
<?= Html::beginForm(
  Url::toRoute('site/sform'), //ruta para submit
  'get', //metodo para el submit
  ['class'=>'form-inline'] //Parametros extras de formulario
  )
?>

<div class="form-group">
  <?= Html::label('label del campo', 'campotxt') ?>
  <?= Html::textInput('campotxt', null, ['class'=>'form-control']) ?> 
</div>

<?= Html::submitInput('Enviar from', ['class'=>'btn btn-primary']) ?>

<?= Html::endForm() ?>

