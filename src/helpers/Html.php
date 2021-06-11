<?php


namespace antonyz89\templates\helpers;


class Html extends \yii\helpers\Html
{
    /**
     * @inheritDoc
     * @param string|array $content the content to be enclosed between the start and end tags. It will not be HTML-encoded.
     * If this is coming from end users, you should consider [[encode()]] it to prevent XSS attacks.
     */
    public static function tag($name, $content = '', $options = [])
    {
        if (is_array($content)) {
            $content = implode($content);
        }

        return parent::tag($name, $content, $options);
    }
}