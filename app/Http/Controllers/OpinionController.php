<?php

namespace App\Http\Controllers;

use App\Models\Opinion;
use App\Models\Practice;
use App\Models\UserOpinion;
use Illuminate\Http\Request;
use \Illuminate\Http\RedirectResponse;

class OpinionController extends Controller
{
    public function store(Request $request, int $id): RedirectResponse
    {
        Opinion::newOpinion($request, $id);

        return redirect()->route('practices.show', ['id' => $id]);
    }

    public function destroy(Request $request, int $id, int $oId): RedirectResponse
    {
        Opinion::find($oId)->delete();

        return redirect()->route('practices.show', ['id' => $id]);
    }

    public function updateVote(Request $request, int $id, int $oId, int $vote): RedirectResponse
    {
        UserOpinion::updateOrCreate(
            ['opinion_id' => $oId, 'user_id' => auth()->user()->id],
            ['user_id' => auth()->user()->id, 'opinion_id' => $oId, 'comment' => "", 'points' => $vote]);

        return redirect()->route('practices.show', ['id' => $id]);
    }

    public function updateComment(Request $request, int $id, int $oId): RedirectResponse
    {
        $request->validate([
            'comment' => ['required', 'max:1000', 'min:5'],
        ]);
        UserOpinion::updateOrCreate(
            ['opinion_id' => $oId, 'user_id' => auth()->user()->id],
            ['user_id' => auth()->user()->id, 'opinion_id' => $oId, 'comment' => $request->comment]);

        return redirect()->route('practices.show', ['id' => $id]);
    }
}
