<?php

namespace App\Enums;

enum UserTypesEnum: string
{
    case dm = 'demolay';
    case adm = 'admin';
    case on = 'owner';
}
