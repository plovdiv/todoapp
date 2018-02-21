<?php

function data_page()
{
    $actionName = request()->route()->getActionMethod();
    $controllerClass = get_class(request()->route()->getController());

    $controller = preg_replace('/.*\\\/', '', $controllerClass);
    $controllerName = str_replace('Controller', '', $controller);

    return $controllerName . ':' . $actionName;
}
