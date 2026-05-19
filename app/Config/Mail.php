<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Mail extends BaseConfig
{
    public string $host       = '';
    public string $username   = '';
    public string $password   = '';
    public int    $port       = 587;
    public string $from       = '';
    public string $fromName   = '';
}