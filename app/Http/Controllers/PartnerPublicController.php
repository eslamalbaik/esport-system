<?php

namespace App\Http\Controllers;

use App\Models\Partner;

class PartnerPublicController extends Controller
{
    public function show(Partner $partner)
    {
        return view('site.partner_show', compact('partner'));
    }
}
