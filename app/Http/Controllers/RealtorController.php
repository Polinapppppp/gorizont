<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class RealtorController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::where('realtor_id', auth()->id())
            ->with(['user', 'apartment']);

        // Фильтр по статусу
        if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'viewing_scheduled', 'closed'])) {
            $query->where('status', $request->status);
        }

        // Фильтр по типу (с квартирой / просмотр комплекса)
        if ($request->filled('type')) {
            if ($request->type === 'with_apartment') {
                $query->whereNotNull('apartment_id');
            } elseif ($request->type === 'complex_only') {
                $query->whereNull('apartment_id');
            }
        }

        // Сортировка
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            default:
                $query->latest();
                break;
        }

        $applications = $query->paginate(15)->withQueryString();

        return view('realtor.dashboard', compact('applications', 'sort'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        if ($application->realtor_id != auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,approved,viewing_scheduled,closed'
        ]);

        $application->update(['status' => $validated['status']]);

        return back()->with('success', 'Статус заявки обновлён.');
    }
}
