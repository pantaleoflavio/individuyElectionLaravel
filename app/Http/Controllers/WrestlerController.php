<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
use App\Models\Wrestler;
use Illuminate\Http\Request;

class WrestlerController extends Controller
{
    public function candidates(Request $request)
    {
        $categoryId = $request->query('category_id');
        $includesInactive = $request->query('includes_inactive');
        $rankingId = $request->query('ranking_id');

        $ranking = Ranking::find($rankingId);
        if (!$ranking) {
            return redirect()->back()->with('error', 'Ranking non disponibile per questa votazione.');
        }
    
        $query = Wrestler::query();
    
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        } else {
            $query->whereNull('category_id');
        }
    
        if (!$includesInactive) {
            $query->where('is_active', true);
        }
    
        $wrestlers = $query->get();
    
        $ranking = null;
        if ($rankingId) {
            $ranking = Ranking::find($rankingId);
        }
    
        return view('votes.wrestler.candidates', [
            'wrestlers' => $wrestlers,
            'ranking' => $ranking,
        ]);
    }


}
