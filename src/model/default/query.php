<?php
/**
 * This is the template for generating the ActiveQuery class.
 *
 * @author Antony Gabriel Pereira
 * @link https://github.com/AntonyZ89
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */
/* @var $className string class name */
/* @var $modelClassName string related model class name */

$modelFullClassName = $modelClassName;
if ($generator->ns !== $generator->queryNs) {
    $modelFullClassName = '\\' . $generator->ns . '\\' . $modelFullClassName;
}

function match_toupper($m) {
    return ucfirst($m[1]);
}

function capitalize($str) {
    $str = preg_replace('/_id$/', '', $str);
    return preg_replace_callback('/(?:^|_)([a-zA-Z0-9])/', 'match_toupper', $str);
}

echo "<?php\n";
?>

namespace <?= $generator->queryNs ?>;

use antonyz89\templates\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[<?= $modelFullClassName ?>]].
 *
 * @see <?= $modelFullClassName . "\n" ?>
 */
class <?= $className ?> extends ActiveQuery
{

    /**
     * {@inheritdoc}
     * @return <?= $modelFullClassName ?>[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return <?= $modelFullClassName ?>|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
<?php foreach ($tableSchema->columns as $name => $values):
    if (in_array($name, ['created_at', 'updated_at'])) continue;

    $operator = ($name === 'operator' ? '$_operator' : '$operator');
    switch ($values->phpType):
        case 'integer': ?>
<?= "\n" ?>
    /**
     * @param integer $<?= $name . "\n" ?>
     * @param string <?= $operator . "\n" ?>
     * @return <?= $modelFullClassName ?>Query
     */
    public function where<?= capitalize($name) ?>($<?= $name ?>, <?= $operator ?> = '=')
    {
        return $this->andWhere([
            <?= $operator ?>, sprintf('%s.<?= $name ?>', $this->_alias), $<?= $name . "\n" ?>
        ]);
    }
<?php break;
    case 'string':
        $isDate = in_array($values->dbType, ['date', 'datetime']); ?>
<?= "\n" ?>
    /**
     * @param string $<?= $name . "\n" ?>
     * @param string <?= $operator . "\n" ?>
     * @return <?= $modelFullClassName ?>Query
     */
    public function where<?= capitalize($name) ?>($<?= $name ?>, <?= $operator ?> = <?= $isDate ? "'='" : "'LIKE'" ?>)
    {
        return $this->andWhere([
            <?= $operator ?>, sprintf('%s.<?= $name ?>', $this->_alias), $<?= $name . "\n" ?>
        ]);
    }
    <?php if($isDate): ?>
<?= "\n" ?>
    /**
     * @param string $start_date
     * @param string $end_date
     * @return <?= $modelFullClassName ?>Query
     */
    public function where<?= capitalize($name) ?>Between($start_date, $end_date)
    {
        return $this->andWhere([
            'BETWEEN', sprintf('%s.<?= $name ?>', $this->_alias), $start_date, $end_date
        ]);
    }
    <?php endif; ?>
<?php break; ?>
<?php endswitch; ?>
<?php endforeach; ?>

}
