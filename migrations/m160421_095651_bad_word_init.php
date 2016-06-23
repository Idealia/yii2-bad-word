<?php
/**
 * Created by PhpStorm.
 * User: Piotr Grzelka <piotr.grzelka@idealia.pl>
 * Date: 22.06.16
 * Time: 20:49
 */

/**
 * Class m160421_095651_bad_word_init
 */
class m160421_095651_bad_word_init extends \yii\db\Migration
{

    public $table = 'bad_word';

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'word' => $this->string(50),
        ]);
        $this->installWords();
    }


    public function safeDown()
    {
        $this->dropTable($this->table);
    }

    /**
     * insert words from file
     */
    private function installWords()
    {
        $data = file(__DIR__ . '/../bad_words_pl.txt');

        $bom = pack('H*', 'EFBBBF');

        $rows = [];
        foreach ($data as $row) {
            $rows[] = [trim(preg_replace("/^$bom/", '', $row))];
        }

        Yii::$app
            ->db
            ->createCommand()
            ->batchInsert($this->table, ['word'], $rows)
            ->execute();
    }

}