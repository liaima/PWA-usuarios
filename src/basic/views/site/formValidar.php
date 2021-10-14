<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<h1>Formulario Validado</h1>

<a href="<?= Url::toRoute('site/usuarios') ?>" class="btn btn-primary"><i class="bi bi-card-list"></i> Lista de usuarios...</a>

<?php if($mensaje!=null){
  echo "<div class='alert alert-success' role='alert'>$mensaje</div>";
} ?>
<?php 
  $form = ActiveForm::begin([
    'method'=>'post',
    'id' => 'formulario',
    'enableClientValidation'=> true,
    'enableAjaxValidation' => false
  ]);
?>

<div class="container-sm">
  <div class="row">
    <div class="col">
    <div class="form-group">
      <?= $form->field($model, 'nombre')->input(type: 'text', options: [
        'placeholder'=>'Ingrese su nombre'
      ]) ?>
  
    </div>
   </div>
   <div class="col">
     <div class="form-group">
    <?= $form->field($model, 'email')->input(type: 'email', options: [
      'placeholder' => 'Ingrese su email'
    ]) ?>
   </div>

   <div class="form-group">
     <?= $form->field($model, 'confEmail')->input(type: 'text', options: [
       'placeholder' => 'Repita su email'
      ]) ?> 
   </div>
  </div>
  </div>
  <?= Html::submitInput('Enviar', ['class'=>'btn btn-primary']) ?>
</div>
<?php 

  $form->end();

?>
