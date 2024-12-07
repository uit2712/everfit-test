<?php

function log_data($data) {
    $response = wp_remote_post('https://script.google.com/macros/s/AKfycbxJ_rIhemtg3uY8T-RXWVB1t1eqQKFEQ8Ek7Q5mNt0ZRmXnSbJKC12CaWweCQ8xz_vsUQ/exec?apiName=apiLogError', [
        'body' => json_encode($data),
    ]);

    return wp_remote_retrieve_body($response);
}