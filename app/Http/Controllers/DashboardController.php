<?php

namespace App\Http\Controllers;

use App\Models\InternalBulletin;
use App\Models\TransferOfKnowledge;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $bulletins = InternalBulletin::orderBy('created_at')->get();

        $top_transfer_of_knowledges = TransferOfKnowledge::where('is_top_learner', true)
            ->orderBy('top_learner_month', 'desc')
            ->get();

        return view('dashboard', compact('bulletins', 'top_transfer_of_knowledges'));
    }
}
