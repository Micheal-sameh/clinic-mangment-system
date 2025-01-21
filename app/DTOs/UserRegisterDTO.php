<?php

namespace App\DTOs;

use App\Attributes\HasEmptyPlaceholders;
use App\DTOs\DTO;

#[HasEmptyPlaceholders]
class UserRegisterDTO extends DTO
{
    public ?string $name_en;
    public ?string $name_ar;
    public ?int $E1C1F;
    public ?int $NR;
    public ?string $phone;
    public ?string $email;
    public ?string $password;

    public function __construct(
        string $name_en = parent::STRING,
        string $name_ar = parent::STRING,
        int $E1C1F = parent::INT,
        int $NR = parent::INT,
        int $type = parent::INT,
        int $status = parent::INT,
        string $phone = parent::STRING,
        string $email = parent::STRING,
        string $password = parent::STRING,
    ) {
        parent::__construct(compact(...$this->getParameterList()));
    }
}
