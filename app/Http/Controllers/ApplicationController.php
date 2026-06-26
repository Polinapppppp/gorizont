<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /* фиксированная длительность показа для расчета*/
    private const VIEWING_DURATION_MINUTES = 60;

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'nullable|string|max:255',
            'phone'        => 'required|string|max:20',
            'viewing_date' => 'nullable|date|after:now',
            'comment'      => 'nullable|string|max:500',
            'apartment_id' => 'nullable|exists:apartments,id',
        ]);

        $realtor = !empty($validated['viewing_date'])
            ? $this->findAvailableRealtor($validated['viewing_date'])
            : $this->findAnyRealtor();

        if (!$realtor) {
            return back()
                ->with('error', 'К сожалению, на выбранную дату и время нет свободных менеджеров. Попробуйте выбрать другое время.')
                ->withInput();
        }

        $application = Application::create([
            'user_id'       => auth()->id() ?? null,
            'apartment_id'  => $validated['apartment_id'] ?? null,
            'realtor_id'    => $realtor->id,
            'phone'         => $validated['phone'],
            'status'        => 'pending',
            'viewing_date'  => $validated['viewing_date'] ?? null,
            'comment'       => $validated['comment'] ?? null,
        ]);

        $realtor->update(['last_application_at' => now()]);

        return back()->with('success', 'Заявка успешно отправлена! Менеджер свяжется с вами.');
    }

    private function findAvailableRealtor(string $viewingDate): ?User
    {
        $newStart = Carbon::parse($viewingDate);
        $newEnd   = $newStart->copy()->addMinutes(self::VIEWING_DURATION_MINUTES);

        $busyRealtorIds = Application::where('status', '!=', 'cancelled')
            ->whereNotNull('viewing_date')
            ->where(function ($query) use ($newStart, $newEnd) {
                /* перекрытие интервалов */
                $query->where('viewing_date', '<', $newEnd)/* существующая заявка началась раньше чем заканчивается новая */
                      ->whereRaw(
                          'DATE_ADD(viewing_date, INTERVAL ? MINUTE) > ?',/* существующая заявка заканчивается позже чем начинается новая */
                          [self::VIEWING_DURATION_MINUTES, $newStart]
                      );
            })
            ->pluck('realtor_id')
            ->toArray();

        return User::where('role_id', 3)
            ->whereNotIn('id', $busyRealtorIds)
            ->withCount(['applications' => function ($q) {/* сначала берем тех у кого меньше всего заявок */
                $q->whereDate('created_at', today());
            }])
            ->orderBy('applications_count', 'asc')
            ->orderByRaw('last_application_at IS NULL DESC')/* среди равных по нагрузке приоритет тем кто еще не получал заявок */
            ->orderBy('last_application_at', 'asc')
            ->first();
    }

    private function findAnyRealtor(): ?User
    {
        return User::where('role_id', 3)
            ->withCount(['applications' => function ($q) {
                $q->whereDate('created_at', today());
            }])
            ->orderBy('applications_count', 'asc')
            ->orderByRaw('last_application_at IS NULL DESC')
            ->orderBy('last_application_at', 'asc')
            ->first();
    }
}
