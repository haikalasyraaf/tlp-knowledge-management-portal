<?php

namespace App\Http\Controllers;

use App\Models\TransferOfKnowledge;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $top_transfer_of_knowledges = TransferOfKnowledge::where('is_top_learner', true)
            ->orderBy('top_learner_month', 'desc')
            ->get();

        return view('dashboard', compact('top_transfer_of_knowledges'));
    }
}
