<?php 

namespace Language\LeetSpeak;

/* *************************** Non accessible code *************************** */

define('CHARSET', [
    'latin' => str_split('ABEGIOPRST'),
    'leet'  => str_split('4836109257')
]);

/* *************************** Exposed functions *************************** */

function register_encode($str) {
    return str_replace(CHARSET['latin'], CHARSET['leet'], strtoupper($str));
}

function register_decode($str) {
    return str_replace(CHARSET['leet'], CHARSET['latin'], strtoupper($str));
}
