<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\RouteNameEnum;
use App\Models\Idea;
use Illuminate\Contracts\View\View;

final class IdeaController extends Controller
{
    public function index(): View
    {
        return view('ideas.index');
    }

    public function show(Idea $idea): View
    {
        return view('ideas.show', [
            'idea' => $idea,
            'votesCount' => $idea->votes()->count(),
            'backUrl' => url()->previous() !== url()->full() && url()->previous() !== route('login')
                ? url()->previous()
                : route(RouteNameEnum::IdeasIndex),
        ]);
    }
}
