<?php

use yii\db\Migration;

/**
 * Class m200712_124410_attachment
 */
class m200712_124410_attachment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200712_124410_attachment cannot be reverted.\n";

        return false;
    }

    /**
     * 创建表
     * @return bool|void
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = "CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB COMMENT='附件表'";
        }
        $this->createTable('{{%attachment}}', [
            'id' => $this->primaryKey()->comment('附件id'),
            'drive' => $this->string(10)->notNull()->comment('驱动'),
            'base_url' => $this->string(256)->notNull()->comment('访问URL'),
            'path' => $this->string(256)->notNull()->comment('路径'),
            'name' => $this->string(256)->notNull()->comment('原始文件名'),
            'extension' => $this->string(10)->notNull()->comment('文件后缀'),
            'size' => $this->integer(11)->notNull()->comment('文件大小'),
            'mime_type' => $this->string(24)->notNull()->comment('MimeType'),
            'md5' => $this->string(64)->unique()->comment('md5校验码'),
            'ip' => $this->string(64)->notNull()->comment('上传IP'),
            'created_at' => $this->integer()->notNull()->defaultValue(0)->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->defaultValue(0)->comment('更新时间'),
        ], $tableOptions);
        $this->createIndex('path','{{%attachment}}',['path']);
        $this->createIndex('base_url','{{%attachment}}',['base_url']);
    }

    /**
     * 删除表
     * @return bool|void
     */
    public function down()
    {
        $this->dropTable('{{%attachment}}');
    }
}
