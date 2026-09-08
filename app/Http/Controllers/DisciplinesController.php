<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use Illuminate\Contracts\View\View;

class DisciplinesController extends Controller
{
    public function index(): View
    {
        $disciplines = Discipline::published()
            ->orderBy('level')
            ->orderBy('sort_order')
            ->get();

        // Зв'язки для Skill Tree: пари "disc-{id}" на основі prerequisites
        $connections = [];
        foreach ($disciplines as $discipline) {
            foreach ($discipline->prerequisites ?? [] as $prerequisiteId) {
                $connections[] = ["disc-{$prerequisiteId}", "disc-{$discipline->id}"];
            }
        }

        return view('disciplines', [
            'disciplines' => $disciplines,
            'connections' => $connections,
            'levels' => $disciplines->groupBy('level'),
        ]);
    }
}
