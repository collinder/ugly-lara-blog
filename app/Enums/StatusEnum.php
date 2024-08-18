<?php

namespace App\Enums;

enum StatusEnum: string
{
    case Public = 'Опубликованный';
    case Private = 'Черновик';
}
