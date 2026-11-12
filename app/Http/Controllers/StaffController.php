<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StaffController extends Controller
{
    private const ALLOWED_PER_PAGE = [3, 9, 15, 21];

    private const DEFAULT_PER_PAGE = 9;

    public function about(Request $request): View|string
    {
        $perPage = (int) $request->query('per_page', self::DEFAULT_PER_PAGE);
        if (! in_array($perPage, self::ALLOWED_PER_PAGE, true)) {
            $perPage = self::DEFAULT_PER_PAGE;
        }

        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'per_page' => $perPage,
        ];

        // Точкова вибірка колонок для підвищення продуктивності SQL-запиту
        $staff = Staff::query()
            ->select(['id', 'first_name', 'last_name', 'patronymic', 'position_id', 'degree_id', 'academic_rank_id', 'avatar_url', 'is_published'])
            ->published()
            ->search($filters['q'])
            ->withStaffRelations()
            ->sortedByPositionAndName()
            ->paginate($perPage)
            ->onEachSide(1)
            ->withQueryString();

        // Якщо це AJAX-запит від живого пошуку чи пагінації — віддаємо лише HTML-контент сітки
        if ($request->ajax()) {
            return view('partials.staff-grid-content', [
                'staff' => $staff,
                'filters' => $filters,
                'perPageOptions' => self::ALLOWED_PER_PAGE,
            ])->render();
        }

        return view('about', [
            'staff' => $staff,
            'filters' => $filters,
            'perPageOptions' => self::ALLOWED_PER_PAGE,
        ]);
    }

    public function details(Staff $staff): JsonResponse
    {
        if (! $staff->is_published) {
            abort(404);
        }

        $now = Carbon::now();

        $staff->load([
            'achievements' => fn ($q) => $q->orderBy('year', 'desc'),
            'degree',
            'academicRank',
            'position',
            // 'disciplines',
            'disciplines' => fn ($q) => $q->whereDate('end_date', '>=', $now),
        ]);

        return response()->json($staff);
    }
}
