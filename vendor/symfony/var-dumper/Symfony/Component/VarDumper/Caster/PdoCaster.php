<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\VarDumper\Caster;

use Symfony\Component\VarDumper\Cloner\Stub;

/**
 * Casts PDO related classes to array representation.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class PdoCaster
{
    private static $pdoAttributes = array(
        'CASE' => array(
            \PDO::CASE_LOWER => 'LOWER',
            \PDO::CASE_NATURAL => 'NATURAL',
            \PDO::CASE_UPPER => 'UPPER',
        ),
        'ERRMODE' => array(
            \PDO::ERRMODE_SILENT => 'SILENT',
            \PDO::ERRMODE_WARNING => 'WARNING',
            \PDO::ERRMODE_EXCEPTION => 'EXCEPTION',
        ),
        'TIMEOUT',
        'PREFETCH',
        'AUTOCOMMIT',
        'PERSISTENT',
        'DRIVER_NAME',
        'SERVER_INFO',
        'ORACLE_NULLS' => array(
            \PDO::NULL_NATURAL => 'NATURAL',
            \PDO::NULL_EMPTY_STRING => 'EMPTY_STRING',
            \PDO::NULL_TO_STRING => 'TO_STRING',
        ),
        'CLIENT_VERSION',
        'SERVER_VERSION',
        'STATEMENT_CLASS',
        'EMULATE_PREPARES',
        'CONNECTION_STATUS',
        'STRINGIFY_FETCHES',
        'DEFAULT_FETCH_MODE' => array(
            \PDO::FETCH_ASSOC => 'ASSOC',
            \PDO::FETCH_BOTH => 'BOTH',
            \PDO::FETCH_LAZY => 'LAZY',
            \PDO::FETCH_NUM => 'NUM',
            \PDO::FETCH_OBJ => 'OBJ',
        ),
    );

    public static function castPdo(\PDO $c, array $a, Stub $stub, $isNested)
    {
        $attr = array();
        $errmode = $c->getAttribute(\PDO::ATTR_ERRMODE);
        $c->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        foreach (self::$pdoAttributes as $k => $v) {
            if (!isset($k[0])) {
                $k = $v;
                $v = array();
            }

            try {
                $attr[$k] = 'ERRMODE' === $k ? $errmode : $c->getAttribute(constant('PDO::ATTR_'.$k));
                if ($v && isset($v[$attr[$k]])) {
                    $attr[$k] = new ConstStub($v[$attr[$k]], $attr[$k]);
                }
            } catch (\Exception $e) {
            }
        }

        $m = "\0~\0";
        $a += array(
            $m.'inTransaction' => method_exists($c, 'inTransaction'),
            $m.'errorInfo' => $c->errorInfo(),
            $m.'attributes' => $attr,
        );

        if ($a[$m.'inTransaction']) {
            $a[$m.'inTransaction'] = $c->inTransaction();
        } else {
            unset($a[$m.'inTransaction']);
        }

        if (!isset($a[$m.'errorInfo'][1], $a[$m.'errorInfo'][2])) {
            unset($a[$m.'errorInfo']);
        }

        $c->setAttribute(\PDO::ATTR_ERRMODE, $errmode);

        return $a;
    }

    public static function castPdoStatement(\PDOStatement $c, array $a, Stub $stub, $isNested)
    {
        $m = "\0~\0";
        $a[$m.'errorInfo'] = $c->errorInfo();

        if (!isset($a[$m.'errorInfo'][1], $a[$m.'errorInfo'][2])) {
            unset($a[$m.'errorInfo']);
        }

        return $a;
    }
}
