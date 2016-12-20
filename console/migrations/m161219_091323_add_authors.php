<?php

use yii\db\Migration;

class m161219_091323_add_authors extends Migration
{
    private $authorsTable = '{{%authors}}';
    
    public function safeUp()
    {
        $this->insert($this->authorsTable, [
            'name' => 'author 1',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert($this->authorsTable, [
            'name' => 'author 2',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert($this->authorsTable, [
            'name' => 'author 3',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    public function safeDown()
    {
        return true;
    }
}
