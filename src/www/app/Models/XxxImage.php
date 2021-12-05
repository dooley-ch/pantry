<?php
// *******************************************************************************************
//  File:  XxxImage.php
//
//  Created: 03-12-2021
//
//  Copyright (c) 2021 James Dooley <james@dooley.ch>
//
//  History:
//  03-12-2021: Initial version
//
// *******************************************************************************************

declare(strict_types=1);

namespace App\Models;

use \stdClass;
use Carbon\Carbon;

class XxxImage extends AuditRecord
{
    public function __construct(int $id, Carbon $logged_at, string $action, int $record_id, int $lock_version,
                                private string $url, private string $image_type, private int $product_image_id)
    {
        parent::__construct($id, $logged_at, $action, $record_id, $lock_version);
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getImageType(): string
    {
        return $this->image_type;
    }

    public function getProductImageId(): int
    {
        return $this->product_image_id;
    }

    public static function fromRecord(stdClass $record): XxxImage
    {
        $id = intval($record->id);
        $logged_at = Carbon::createFromTimestamp($record->logged_at);
        $action = $record->action;
        $record_id = intval($record->record_id);
        $url = $record->url;
        $image_type = $record->image_type;
        $product_image_id = intval($record->product_image_id);
        $lock_version = intval($record->lock_version);

        return new XxxImage($id, $logged_at, $action, $record_id, $lock_version, $url, $image_type, $product_image_id);
    }
}
