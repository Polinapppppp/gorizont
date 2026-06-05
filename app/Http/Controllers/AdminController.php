<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Application;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $applications = Application::with(['user', 'apartment', 'realtor'])
            ->latest()
            ->paginate(15);

        return view('admin.dashboard', compact('applications'));
    }

    public function assignRealtor(Request $request, Application $application)
    {
        $request->validate([
            'realtor_id' => 'required|exists:users,id'
        ]);

        $application->update(['realtor_id' => $request->realtor_id]);

        return back()->with('success', 'Риэлтор назначен.');
    }

    public function updateApartmentStatus(Request $request, Apartment $apartment)
    {
        $request->validate([
            'status' => 'required|in:free,sold,booked'
        ]);

        $apartment->update(['status' => $request->status]);

        return back();
    }
}
