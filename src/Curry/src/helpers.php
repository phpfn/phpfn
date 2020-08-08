<?php
/**
 * This file is part of Curry package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);


if (! \function_exists('\\spl_object_id')) {
    /**
     * This function returns a unique identifier for the object.
     * The object id is unique for the lifetime of the object.
     * Once the object is destroyed, its id may be reused for other
     * objects. This behavior is similar to spl_object_hash().
     *
     * @param object $obj Any object.
     * @return int An integer identifier that is unique for each currently existing
     *             object and is always the same for each object.
     */
    function spl_object_id($obj): int
    {
        \ob_start();
        \debug_zval_dump($obj);
        \preg_match_all('/\w+\(\w+\)#(\d+)/iu', \ob_get_clean(), $matches);

        return (int)($matches[1][0] ?? 0);
    }
}


if (! \function_exists('\\iterator_map')) {
    /**
     * iterator_map() returns an array containing all the elements of
     * $iterable after applying the callback function to each one.
     *
     * The number of parameters that the callback function accepts should
     * match the number of iterable arguments passed to the iterator_map()
     *
     * @param callable $map Callback function to run for each element in each iterable.
     * @param iterable ...$iterable An iterable items to run through the callback function.
     * @return array
     */
    function iterator_map(callable $map, iterable ...$iterable): array
    {
        $result = [];

        foreach ($iterable as $it) {
            foreach ($it as $key => $value) {
                $result[] = $map($value, $key);
            }
        }

        return $result;
    }
}
