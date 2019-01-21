<?php

function laradin_route($route, $params = []) {
    return route(config('category.route.name') . ".$route", $params) ;
}

function laradin_trans($message, $params = [])
{
    return trans('laradin-category::category.'. $message, $params);
}