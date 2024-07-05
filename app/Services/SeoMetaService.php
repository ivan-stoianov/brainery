<?php

namespace App\Services;

use App\Services\Contracts\SeoMeta as Contract;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\HtmlString;
use Stringable;

class SeoMetaService implements Contract
{
    public function generate(): Stringable
    {
        return new HtmlString(SEOMeta::generate());
    }

    public function setTitle(string $title): void
    {
        SeoMeta::setTitle($title);
    }

    public function setDescription(string $description): void
    {
        SeoMeta::setDescription($description);
    }
}
