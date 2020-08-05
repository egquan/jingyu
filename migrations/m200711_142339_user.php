<?php

use yii\db\Migration;

/**
 * Class m200711_142339_user
 */
class m200711_142339_user extends Migration
{
    /**
     * 创建表
     * @return bool|void
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = "CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB COMMENT='用户表'";
        }
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey()->comment('用户id'),
            'username' => $this->string(32)->notNull()->unique()->comment('用户账户'),
            'auth_key' => $this->string(32)->notNull()->unique()->comment('记住密码auth_key'),
            'password_hash' => $this->string(255)->notNull()->comment('用户密码'),
            'email' => $this->string(64)->notNull()->unique()->comment('用户邮箱'),
            'status' => $this->tinyInteger(3)->notNull()->defaultValue(1)->comment('用户状态 0禁用 1正常'),
            'nickname' => $this->string(10)->notNull()->comment('用户昵称'),
            'head_portrait' => $this->string(128)->null()->comment('用户头像'),
            'created_at' => $this->integer()->notNull()->defaultValue(0)->comment('用户创建时间'),
            'updated_at' => $this->integer()->notNull()->defaultValue(0)->comment('用户更新时间'),
        ], $tableOptions);
    }

    /**
     * 删除数据表
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable('{{%user}}');
    }

}
