<?php 
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\widgets\LinkPager;
?>

  <a href="<?= Url::toRoute('site/formvalidar') ?>" class="btn btn-success"><i class="bi bi-person-plus-fill"></i> Nuevo...</a>

<h3>Lista de la tabla Usuarios</h3>

<?php if($mensaje!=null){
  echo "<div class='alert alert-warning' role='alert'> $mensaje </div>";
} ?>

<?php 
  $form = ActiveForm::begin([
    "method"=>"get",
    "action"=>Url::toRoute("site/usuarios"),
    "enableClientValidation"=>true
  ]);
?>

<div>
  <?= $form->field($model, "query")->input("search") ?>
</div>

<?= Html::submitInput("Buscar", ["class"=>"btn btn-primary"]) ?>

<?php 
  $form->end();
?>
<table class="table table-bordered">
  <tr>
    <th>Codigo:</th>
    <th>Nombre:</th>
    <th>Email:</th>
    <th>Acciones</th>
  </tr>
<?php 
 foreach($data as $row):
?>
<tr>
  <td>
    <?= $row->id ?>
  </td>
  <td>
    <?= $row->nombre ?>
  </td>
  <td>
    <a href="mailto: <?= $row->email ?>">
      <?= $row->email ?>
    </a>
  </td>
  <td>
    <a href="<?= Url::toRoute(['site/delusuario', 'id'=>$row->id, 'nombre'=>$row->nombre]) ?>" class="btn btn-danger"><i class="bi bi-trash"></i>
  </td>
</tr>
<?php endforeach ?>
</table>

<?= LinkPager::widget([
  'pagination' => $pages,
]); ?>






