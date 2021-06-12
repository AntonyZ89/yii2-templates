<?php


namespace antonyz89\templates\helpers;


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
}