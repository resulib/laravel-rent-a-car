<?php


if (!function_exists('paginationIndex')) {
    function paginationIndex($loopIndex, $paginator): float|int
    {
        return ($paginator->currentPage() - 1) * $paginator->perPage() + $loopIndex + 1;
    }
}
