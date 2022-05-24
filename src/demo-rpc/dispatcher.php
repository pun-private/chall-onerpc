<?php

function check_json() {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Only POST method allowed.");
    }

    $json = json_decode(file_get_contents('php://input'));
    if (json_last_error() !== JSON_ERROR_NONE)
        throw new Exception("Invalid JSON.");

    return $json;
}

function check_forbidden_func($func_name) {
    if (array_search($func_name, get_defined_functions()["internal"]) !== false) {
        throw new Exception("Forbidden function name.");
    }
}

function return_json($obj, $http_code=200) {

    http_response_code($http_code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($obj, JSON_PRETTY_PRINT);
}

function call_api($json) {

    if (empty($json->api) || preg_match('/^[\\\\]|[^a-zA-Z0-9\\\\]/', $json->api) === 1) {
        throw new Exception("Invalid 'api' endpoint.");
    }
    $json->api = rtrim($json->api, '\\');

    $json->func = "register_{$json->func}";
    check_forbidden_func($json->func);

    $api_func = "{$json->api}\\{$json->func}";
    if (function_exists($api_func) === false) {
        throw new Exception("Unknown function $api_func");
    }

    return $api_func(...(empty($json->args) ? [] : $json->args));
}

function rpc_api() {

    try {
        $json = check_json();
        return_json((object)
            [ "result" => call_api($json) ],
            200
        );
    }
    catch (ArgumentCountError $e) {
        return_json((object)
            [ "error" => "Invalid 'args' value." ], 
            500
        );
    }
    catch (Throwable $e){
        return_json((object)
            [ "error" => $e->getMessage() ], 
            500
        );
    }
}