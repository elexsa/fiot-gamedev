<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StaffAcademicRank;
use App\Models\StaffDegree;
use App\Models\StaffPosition;
use Carbon\Carbon;

class StaffController extends Controller
{
    public function about()
    {
        $staff = Staff::with([
            'achievements' => fn ($query) => $query->orderBy('year', 'desc'),
            'degree',
            'academicRank',
            'position',
            // Фільтруємо дисципліни (У картці працівника відображаються предмети, які він зараз викладає)
            'disciplines' => fn ($query) => $query
                ->whereDate('start_date', '<=', Carbon::now())
                ->whereDate('end_date', '>=', Carbon::now()),
        ])
            ->leftJoin('staff_positions', 'staff.position_id', '=', 'staff_positions.id')
            ->leftJoin('staff_degrees', 'staff.degree_id', '=', 'staff_degrees.id')
            ->leftJoin('staff_academic_ranks', 'staff.academic_rank_id', '=', 'staff_academic_ranks.id')
            ->where('staff.is_published', true)
            ->orderByRaw('COALESCE(staff_positions.sort_order, 999) asc')
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
            ->get();

        // Обробка null значень зв'язків та заміна їх на дефолтні моделі з текстом
        $staff->transform(function ($member) {
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

        return view('about', compact('staff'));
    }
}
