<?php
// *******************************************************************************************
//  File:  config_info.php
//
//  Created: 26-11-2021
//
//  Copyright (c) 2021 James Dooley <james@dooley.ch>
//
//  History:
//  26-11-2021: Initial version
//
// *******************************************************************************************

declare(strict_types=1);

namespace OpenFoodFacts;

class ConfigInfo
{
    private string $data_file;
    private string $host;
    private int $port;
    private string $database;
    private string $user;
    private string $password;
    private int $batch_size;

    public function __construct(array $data)
    {
        $this->data_file = $data['data-file'];
        $this->batch_size = intval($data['batch-size']);

        $database = $data['database'];
        $this->host = $database['host'];
        $this->port = intval($database['port']);
        $this->database = $database['database'];
        $this->user = $database['user'];
        $this->password = $database['password'];
    }

    /**
     * @return string
     */
    public function getDataFile(): string
    {
        return $this->data_file;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getDatabase(): string
    {
        return $this->database;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return int
     */
    public function getBatchSize(): int
    {
        return $this->batch_size;
    }
}