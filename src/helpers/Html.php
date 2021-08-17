<?php


namespace antonyz89\templates\helpers;


use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class Html extends \yii\helpers\Html
{
    public const DEFAULT_ROW = 'row';
    public const DEFAULT_BUTTON = 'btn';

    /**
     * @inheritDoc
     * @param string|array $content the content to be enclosed between the start and end tags. It will not be HTML-encoded.
     * If this is coming from end users, you should consider [[encode()]] it to prevent XSS attacks.
     * @param string|array $options
     */
    public static function tag($name, $content = '', $options = [])
    {
        if (is_array($content)) {
            $_content = '';

            foreach ($content as $key => $value) {
                if (is_string($key)) {
                    if (is_array($value)) {
                        foreach ($value as $item) {
                            $_content .= self::tag('div', $item, $key);
                        }
                    } else {
                        $_content .= self::tag('div', $value, $key);
                    }
                } else {
                    $_content .= $value;
                }
            }

            $content = $_content;
        }

        if (is_string($options)) {
            $options = ['class' => $options];
        }

        return parent::tag($name, $content, $options);
    }

    /**
     * @inheritDoc
     * @param array|string $options
     */
    public static function textInput($name, $value = null, $options = [])
    {
        if (is_string($options)) {
            $options = ['class' => $options];
        }

        return static::input('text', $name, $value, $options);
    }

    /**
     * @param string $name
     * @param array|string $options
     * @return string
     * @throws \Exception
     */
    public static function icon(string $name, $options = []): string
    {
        if (is_array($options)) {
            $options['class'] = ArrayHelper::getValue($options, 'class') . ' fas fa-' . $name;
        } else {
            $options = [
                'class' => $options . ' fas fa-' . $name
            ];
        }

        $tag = ArrayHelper::getValue($options, 'tag', 'i');
        unset($options['tag']);

        return self::tag($tag, null, $options);
    }

    /**
     * @inheritDoc
     * @param array|string $text
     */
    public static function a($text, $url = null, $options = [])
    {
        if ($url !== null) {
            if (is_array($options)) {
                $options['href'] = Url::to($url);
            } else {
                $options = [
                    'class' => $options,
                    'href' => Url::to($url)
                ];
            }
        }

        return static::tag('a', $text, $options);
    }

    /**
     * @param string|array|null $content
     * @param string|array $options
     */
    public static function row($content, $options = [])
    {
        if (is_string($options)) {
            $options = ['class' => $options];
        } else if (!isset($options['class'])) {
            $options['class'] = '';
        }

        $options['class'] .= ' ' . self::DEFAULT_ROW;

        return static::tag('div', $content, $options);
    }

    public static function beginRow($options = [])
    {
        if (is_string($options)) {
            $options = ['class' => $options];
        } else if (!isset($options['class'])) {
            $options['class'] = '';
        }

        $options['class'] .= ' ' . self::DEFAULT_ROW;

        return self::beginTag('div', $options);
    }

    public static function endRow()
    {
        return self::endTag('div');
    }

    /**
     * @param string|array|null $content
     * @param string|array $options
     */
    public static function col($content, $options = [])
    {
        if (empty($options)) {
            $options['class'] = 'col-md-12';
        } elseif (is_string($options)) {
            $options = ['class' => $options];
        }

        return static::tag('div', $content, $options);
    }

    /**
     * @inheritDoc
     *
     * @param array|string $options
     */
    public static function beginTag($name, $options = [])
    {
        if ($name === null || $name === false) {
            return '';
        }

        if (is_string($options)) {
            $options = ['class' => $options];
        }

        return "<$name" . static::renderTagAttributes($options) . '>';
    }

    /**
     * @inheritDoc
     *
     * @param string $content
     * @param array|string $options
     * @return string
     */
    public static function button($content = 'Button', $options = [])
    {
        if (is_string($options)) {
            $options = ['class' => $options];
        } else if (!isset($options['class'])) {
            $options['class'] = '';
        }

        $options['class'] .= ' ' . self::DEFAULT_BUTTON;
        return parent::button($content, $options);
    }

    /**
     * @inheritDoc
     *
     * @param string $content
     * @param string|array $options
     * @return string
     */
    public static function submitButton($content = 'Submit', $options = [])
    {
        if (is_string($options)) {
            $options = ['class' => $options];
        }

        $options['type'] = 'submit';
        return static::button($content, $options);
    }
}