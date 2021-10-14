<?php 

namespace app\models;

use Yii;
use yii\base\Model;

class FormValidar extends Model
{
  public $nombre;
  public $email;
  public $confEmail;

  public function rules()
  {
    return [
      ['nombre', 'required', 'message'=>'El nombre es requerido'],
      ['nombre', 'match', 'pattern'=>'/^.{3,50}$/', 'message'=>'Debe ser de 3 a 50 caracteres'],
      ['nombre', 'match', 'pattern'=>'/^[0-9a-z]+$/i', 'message'=>'Solo letras y números'],
      ['email', 'required', 'message' => 'El email es requerido'],
      ['email', 'email', 'message' => 'Email no válido'],
      ['confEmail', 'required', 'message' => 'Este camo es Requerido'],
      ['confEmail', 'compare', 'compareAttribute' => 'email', 'message' => 'Los mails no coniciden.']
    ];
  }

  public function attributeLabels()
  {
    return [
      'nombre' => 'Nombre:',
      'email' => 'Email:',
      'confEmail' => 'Confirmación de mail:'
    ];
  }
}





?>
