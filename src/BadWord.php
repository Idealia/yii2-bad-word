<?php
/**
 * Created by PhpStorm.
 * User: Piotr Grzelka <piotr.grzelka@idealia.pl>
 * Date: 22.06.16
 * Time: 20:28
 */

namespace idealia\badword;


use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Class BadWord
 * @package idealia\badword
 *
 * ```
 * $foo = Yii::$app->badword->filter('your text with bad words to replace by ***');
 * ```
 *
 * @see http://stackoverflow.com/questions/11751425/how-to-do-a-preg-replace-on-a-string-in-php
 */
class BadWord extends Component
{

    /**
     * @var BadWordProviderInterface
     */
    public $provider;

    /**
     * @var null
     */
    public $replaceCallback = null;

    /**
     * @var bool
     */
    public $obfuscation = false;

    /**
     * @var null
     */
    private static $bad_words_regex = null;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if ($this->replaceCallback == null) {
            $this->replaceCallback = function ($match) {
                return str_repeat('*', strlen($match[0]));
            };
        }

        if (is_array($this->provider)) {
            $this->provider = \Yii::createObject($this->provider);
        }

        if (!$this->provider instanceof BadWordProviderInterface) {
            throw new InvalidConfigException("Bad word provider should be instance of BadWordProviderInterface");
        }
    }

    /**
     * @param $text
     * @return mixed
     */
    public function filter($text)
    {
        return preg_replace_callback($this->getBadWordsRegex(), $this->replaceCallback, $text);
    }

    /**
     * @return string
     */
    public function getBadWordsRegex()
    {
        if (static::$bad_words_regex == null) {
            static::$bad_words_regex = $this->generateBadWordsRegex();
        }
        return static::$bad_words_regex;
    }

    /**
     * @return string
     */
    private function generateBadWordsRegex()
    {
        $bad_words = $this->provider->getBadWords();

        usort($bad_words, function($a, $b) {
            return strlen($b) - strlen($a);
        });

        if ($this->obfuscation) {
            $bad_words = array_map(function ($el) {
                return implode('(?:\.|\s|,)', str_split($el));
            }, $bad_words);
        }

        return "/(" . implode('|', $bad_words) . ")/msi";
    }

}
