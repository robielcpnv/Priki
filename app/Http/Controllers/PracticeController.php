<?php

namespace App\Http\Controllers;

use App\Models\Practice;
use Illuminate\Support\Facades\Gate;

class PracticeController extends Controller
{
    public function index()
    {
        if (!Gate::allows('access-moderator')) {
            abort(403);
        }
        $practicesDomains = Practice::all()->sortBy('publication_state_id')->groupBy('domain_id');
        return view('practices.index', compact('practicesDomains'));
    }

    public function show(int $id)
    {

        if (!Gate::allows('published', Practice::findOrFail($id))) {
            abort(403);
        }
        $practice = Practice::publishedOpinion($id);
        $hasPublished = Practice::UserPublishedOpinion($id);
        return view('practices.show', compact('practice', 'hasPublished'));
    }


}
