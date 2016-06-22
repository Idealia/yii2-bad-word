<?php
/**
 * Created by PhpStorm.
 * User: Piotr Grzelka <piotr.grzelka@idealia.pl>
 * Date: 22.06.16
 * Time: 22:16
 */

namespace idealia\badword;

use yii\validators\FilterValidator;

/**
 * Class BadWordFilter
 * @package idealia\badword
 *
 * In active record validator
 *
 * ```
 * public function rules()
 * {
 *      return [
 *          ['title',  BadWordFilter::class],
 *      ]
 * }
 * ```
 */
class BadWordFilter extends FilterValidator
{
    /**
     * initialize filter callback
     */
    public function init()
    {
        $this->filter = function ($value) {
            return \Yii::$app->badword->filter($value);
        };
        parent::init();
    }

}