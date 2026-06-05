<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'nullable|string|max:255',
            'phone'        => 'required|string|max:20',
            'viewing_date' => 'nullable|date|after:now',
            'comment'      => 'nullable|string|max:500',
            'apartment_id' => 'nullable|exists:apartments,id',
        ]);

        $realtor = User::where('role_id', 3)
            ->orderByRaw('last_application_at IS NULL DESC, last_application_at ASC')
            ->first();

        if (!$realtor) {
            return back()->with('error', 'К сожалению, сейчас нет свободных менеджеров. Попробуйте позже.');
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
}
