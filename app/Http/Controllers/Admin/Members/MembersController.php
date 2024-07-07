<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Members;

use App\Http\Controllers\Controller;
use App\Services\Contracts\SeoMetaServiceInterface;
use Illuminate\View\View;

class MembersController extends Controller
{
    public function __construct(
        protected readonly SeoMetaServiceInterface $seoMeta,
    ) {
    }

    public function index(): View
    {
        $this->seoMeta->setTitle(__('Members'));

        return view('admin.members.index');
    }
}
