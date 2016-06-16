<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 28.08.2015
 */
use yii\db\Schema;
use yii\db\Migration;

class m160616_093837__create_table__cms_user_subscribe extends Migration
{
    public function safeUp()
    {
        $tableExist = $this->db->getTableSchema("{{%cms_user_subscribe}}", true);
        if ($tableExist)
        {
            return true;
        }

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable("{{%cms_user_subscribe}}", [
            'id'                                => $this->primaryKey(),

            'created_at'                        => $this->integer(),

            'cms_user_id'                       => $this->integer()->notNull(),
            'cms_user_subscribe_id'             => $this->integer()->notNull(),

        ], $tableOptions);

        $this->createIndex('cms_user_id', '{{%cms_user_subscribe}}', ['cms_user_id']);
        $this->createIndex('cms_user_subscribe_id', '{{%cms_user_subscribe}}', ['cms_user_subscribe_id']);
        $this->createIndex('user2cms_user_subscribe_id', '{{%cms_user_subscribe}}', ['cms_user_id', 'cms_user_subscribe_id'], true);

        $this->execute("ALTER TABLE {{%cms_user_subscribe}} COMMENT = 'Favorites content items';");

        $this->addForeignKey(
            'cms_user_subscribe__cms_user_id', "{{%cms_user_subscribe}}",
            'cms_user_id', '{{%cms_user}}', 'id', 'CASCADE', 'CASCADE'
        );

        $this->addForeignKey(
            'cms_user_subscribe__cms_user_subscribe_id', "{{%cms_user_subscribe}}",
            'cms_user_subscribe_id', '{{%cms_user}}', 'id', 'CASCADE', 'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey("cms_user_subscribe__cms_user_id", "{{%cms_user_subscribe}}");
        $this->dropForeignKey("cms_user_subscribe__cms_user_subscribe_id", "{{%cms_user_subscribe}}");

        $this->dropTable("{{%cms_user_subscribe}}");
    }
}