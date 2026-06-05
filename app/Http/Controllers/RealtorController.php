<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class RealtorController extends Controller
{
    public function index()
    {
        // Риэлтор видит только те заявки, где realtor_id равен его ID
        $applications = Application::where('realtor_id', auth()->id())
            ->with(['user', 'apartment'])
            ->latest()
            ->paginate(15);

        return view('realtor.dashboard', compact('applications'));
    }

    // Метод для изменения статуса заявки (например, "Просмотр состоялся")
    public function updateStatus(Request $request, Application $application)
    {
        // Проверка, что эта заявка действительно принадлежит этому риэлтору
        if ($application->realtor_id != auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,approved,viewing_scheduled,closed'
        ]);

        $application->update(['status' => $validated['status']]);

        return back()->with('success', 'Статус заявки обновлен.');
    }
}
