<?php

namespace App\Enums;

enum ProductStatus: string
{
    case IN_STOCK = 'in_stock';
    case OUT_STOCK = 'out_stock';
}
