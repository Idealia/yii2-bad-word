<?php
/**
 * Created by PhpStorm.
 * User: Piotr Grzelka <piotr.grzelka@idealia.pl>
 * Date: 22.06.16
 * Time: 20:43
 */

namespace idealia\badword;

use yii\base\Component;

/**
 * Class BadWordDbProvider
 * @package idealia\badword
 */
class BadWordDbProvider extends Component implements BadWordProviderInterface
{

    public $db = 'db';
    public $table = 'bad_word';
    public $field = 'word';

    public function getBadWords()
    {
        return \Yii::$app
            ->{$this->db}
            ->createCommand("select {$this->field} from {$this->table}")
            ->queryColumn();
    }

}