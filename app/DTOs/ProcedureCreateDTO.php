<?php

namespace App\DTOs;

use App\Attributes\HasEmptyPlaceholders;
use App\DTOs\DTO;

#[HasEmptyPlaceholders]
class ProcedureCreateDTO extends DTO
{
    public ?string $name_en;
    public ?string $name_ar;
    public ?string $description_en;
    public ?string $description_ar;
    public ?float $price;

    public function __construct(
        string $name_en,
        string $name_ar,
        string $description_en = parent::STRING,
        string $description_ar = parent::STRING,
        float $price = parent::FLOAT,
    ) {
        parent::__construct(compact(...$this->getParameterList()));
    }
}
