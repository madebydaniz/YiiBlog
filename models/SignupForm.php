<?php


namespace app\models;


use yii\base\Model;
use Yii;
use yii\helpers\VarDumper;

class SignupForm extends Model
{
    public $username;
    public $password;
    public $password_repeat;
    public $email;

    public function rules()
    {
        return [
            [ ['username', 'password', 'password_repeat', 'email'], 'required'],
            [ 'username', 'string', 'min' => 4 ],
            [ ['password', 'password_repeat'], 'string', 'min' => 8 ],
            [ 'password_repeat', 'compare', 'compareAttribute' => 'password'],
            [ 'email', 'email' ]
        ];
    }

    public function signup()
    {
        $user = new User();
        $user->username = $this->username;
        $user->password = Yii::$app->security->generatePasswordHash( $this->password );
        $user->email = $this->email;
        $user->access_token = Yii::$app->security->generateRandomString();
        $user->auth_key = Yii::$app->security->generateRandomString();
        $status = $user->save();
        if ( !$status )
        {
            Yii::error( 'user was not save.' . VarDumper::dumpAsString( $user->errors ) );
        }
        return $status;
    }

}