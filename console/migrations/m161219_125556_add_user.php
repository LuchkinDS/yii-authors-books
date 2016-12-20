<?php

use yii\db\Migration;

class m161219_125556_add_user extends Migration
{
    private $usersTable = '{{%user}}';
    
    public function safeUp()
    {
        $this->insert($this->usersTable, [
            'username' => 'user',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('user'),
            'email' => 'mail@example.com',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    public function safeDown()
    {
        $this->truncateTable($this->usersTable);
    }
}
