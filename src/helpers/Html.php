<?php


namespace antonyz89\templates\helpers;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class Html extends \yii\helpers\Html
{
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
        if (empty($options)) {
            $options['class'] = 'row';
        } elseif (is_string($options)) {
            $options = ['class' => 'row ' . $options];
        }

        return static::tag('div', $content, $options);
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
            $size = $options;
            $options = ['class' => "col-md-$size"];
        }

        return static::tag('div', $content, $options);
    }
}
