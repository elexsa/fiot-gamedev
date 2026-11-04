<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StaffAcademicRank;
use App\Models\StaffDegree;
use App\Models\StaffPosition;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function about(Request $request): View
    {
        // Варіанти кількості елементів на сторінці, що надходять від сервера
        $perPageOptions = [3, 9, 15, 21];
        $defaultPerPage = 9;

        $perPage = (int) $request->query('per_page', $defaultPerPage);
        if (! in_array($perPage, $perPageOptions)) {
            $perPage = $defaultPerPage;
        }

        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'per_page' => $perPage,
        ];

        $query = Staff::with([
            'achievements' => fn ($query) => $query->orderBy('year', 'desc'),
            'degree',
            'academicRank',
            'position',
            'disciplines' => fn ($query) => $query
                ->whereDate('start_date', '<=', Carbon::now())
                ->whereDate('end_date', '>=', Carbon::now()),
        ])
            ->leftJoin('staff_positions', 'staff.position_id', '=', 'staff_positions.id')
            ->leftJoin('staff_degrees', 'staff.degree_id', '=', 'staff_degrees.id')
            ->leftJoin('staff_academic_ranks', 'staff.academic_rank_id', '=', 'staff_academic_ranks.id')
            ->where('staff.is_published', true);

        // Серверний пошук
        if ($filters['q'] !== '') {
            $searchTerms = explode(' ', $filters['q']);
            $query->where(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $term = trim($term);
                    if ($term === '') {
                        continue;
                    }

                    $q->where(function ($subQ) use ($term) {
                        $subQ->where('staff.first_name', 'like', "%{$term}%")
                            ->orWhere('staff.last_name', 'like', "%{$term}%")
                            ->orWhere('staff.patronymic', 'like', "%{$term}%")
                            ->orWhereHas('position', fn ($posQ) => $posQ->where('name', 'like', "%{$term}%"))
                            ->orWhereHas('degree', fn ($degQ) => $degQ->where('name', 'like', "%{$term}%"))
                            ->orWhereHas('academicRank', fn ($rankQ) => $rankQ->where('name', 'like', "%{$term}%"))
                            ->orWhereHas('disciplines', fn ($discQ) => $discQ->where('name', 'like', "%{$term}%"));
                    });
                }
            });
        }

        $staff = $query->orderByRaw('COALESCE(staff_positions.sort_order, 999) asc')
            ->orderBy('staff.last_name', 'asc')
            ->orderBy('staff.first_name', 'asc')
            ->select([
                'staff.id',
                'staff.first_name',
                'staff.last_name',
                'staff.patronymic',
                'staff.degree_id',
                'staff.academic_rank_id',
                'staff.position_id',
                'staff.avatar',
                'staff.bio',
                'staff.scopus_url',
                'staff.orcid_url',
                'staff.wos_url',
                'staff.scholar_url',
                'staff.intellect_url',
                'staff.is_published',
                'staff.created_at',
                'staff.updated_at',
            ])
            ->paginate($perPage)
            ->withQueryString();

        // Обробка null значень зв'язків
        $staff->getCollection()->transform(function ($member) {
            if (! $member->degree || empty($member->degree->name)) {
                $member->setRelation('degree', new StaffDegree(['name' => 'Відсутній']));
            }
            if (! $member->academicRank || empty($member->academicRank->name)) {
                $member->setRelation('academicRank', new StaffAcademicRank(['name' => 'Відсутнє']));
            }
            if (! $member->position || empty($member->position->name)) {
                $member->setRelation('position', new StaffPosition(['name' => 'Відсутня']));
            }

            return $member;
        });

        return view('about', [
            'staff' => $staff,
            'filters' => $filters,
            'perPageOptions' => $perPageOptions, // Передаємо масив варіантів від сервера
        ]);
    }
}
