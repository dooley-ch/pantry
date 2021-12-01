<?php
// *******************************************************************************************
//  File:  datastore.php
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

use mysqli;
use mysqli_sql_exception;

class Datastore
{
    private \mysqli $connection;

    public function __construct(string $host, int $port, string $database, string $user, string $password)
    {
        $this->connection = new mysqli($host, $user, $password, $database, $port);;

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function __destruct()
    {
        $this->connection->close();
    }

    /**
     * @param Product[] $data
     * @return bool
     */
    public function postBatch(array $data): bool
    {
        $this->connection->begin_transaction();

        try {
            $stmt = $this->connection->prepare("INSERT INTO barcode_lookup (code, name, url, countries) VALUES (?, ?, ?, ?) 
                                                        ON DUPLICATE KEY UPDATE code = ?, name = ?, url = ?, countries = ?, 
                                                            lock_version = lock_version + 1, updated_at = CURRENT_TIMESTAMP");
            if ($stmt) {
                foreach ($data as $record) {
                    $code = $record->getBarCode();
                    $name = $record->getName();
                    $url = $record->getUrl();
                    $countries = $record->getCountries();

                    $stmt->bind_param('ssssssss', $code, $name, $url, $countries, $code, $name, $url, $countries);
                    $stmt->execute();
                }

                $this->connection->commit();
                return true;
            }
        } catch (mysqli_sql_exception $exception) {
            $this->connection->rollback();
            die("Failed to insert records in database: " . $exception->getMessage());
        }

        return false;
    }
}