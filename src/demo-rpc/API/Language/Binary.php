<?php

namespace Language\Binary;

/* *************************** Exposed functions *************************** */

function register_encode($str) {
    $binary = [];
    foreach (str_split($str) as $character) {
        $data = unpack('H*', $character);
        $binary[] = base_convert($data[1], 16, 2);
    }
    return implode(' ', $binary);
}

function register_decode($binary) {

    $str = [];

    foreach (explode(' ', $binary) as $character) {
        $data[] = pack('H*', base_convert($character, 2, 16));
    }
    return implode('', $data);
}
