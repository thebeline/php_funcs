<?php

(function($files) {
    if ($files === false)
        throw new RuntimeException("Failed to glob for function files");
    foreach ($files as $file)
        require_once $file;
})(glob(__DIR__ . '/.functions/*.functions?.php'));