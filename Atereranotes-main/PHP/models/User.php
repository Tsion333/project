<?php
namespace app\models;
use app\core\Model;
use app\core\db\DbModel; 

use app\core\UserModel;
class User extends UserModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public int $status = self::STATUS_INACTIVE;
    public string $password = '';
    public string $confirmPassword = ''; 

    public function tableName(): string
    {
       return 'users'; 
    }

    public function primaryKey():string
    {
        return 'id';
    }
  
    public function save()
    {
        $this->status = self::STATUS_INACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }
    public function rules():array
    {
        return [
            'first_name' => [self::RULE_REQUIRED],
            'last_name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
			'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];

    }
    public function attributes(): array
    {
        return ['first_name','last_name', 'email', 'password', 'status'];
    }

    public function labels(): array
    {
        return[
            'first_name' =>'First name',
            'last_name' =>'Last name',
            'email' =>'Email',
            'password' =>'Password',
            'confirmPassword' =>'Confirm password',
        ];
    }

    public function getDisplayName(): string
    {
       return $this->name;
    }

}


?>