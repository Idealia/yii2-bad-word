<?php
/**
 * Created by PhpStorm.
 * User: Piotr Grzelka <piotr.grzelka@idealia.pl>
 * Date: 22.06.16
 * Time: 20:29
 */

namespace idealia\badword;

/**
 * Interface BadWordProviderInterface
 * @package idealia\badword
 */
interface BadWordProviderInterface
{

    /**
     * Should return array of bad words
     * @return array
     */
    public function getBadWords();

}