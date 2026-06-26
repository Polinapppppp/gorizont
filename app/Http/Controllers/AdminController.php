<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Application::with(['user', 'apartment', 'realtor']);

        if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'viewing_scheduled', 'closed'])) {
            $query->where('status', $request->status);
        }

        if ($request->filled('realtor_id')) {
            $query->where('realtor_id', $request->realtor_id);
        }


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

        $realtors = User::where('role_id', 3)->get();

        return view('admin.dashboard', compact('applications', 'realtors', 'sort'));
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
