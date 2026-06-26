<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Apartment::query();

        if ($request->filled('rooms')) {
            $query->where('rooms', $request->rooms);
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        if ($request->filled('area_min')) {
            $query->where('area', '>=', $request->area_min);
        }
        if ($request->filled('area_max')) {
            $query->where('area', '<=', $request->area_max);
        }

        if ($request->filled('floor_min')) {
            $query->where('floor', '>=', $request->floor_min);
        }
        if ($request->filled('floor_max')) {
            $query->where('floor', '<=', $request->floor_max);
        }

        if ($request->filled('building')) {
            $query->where('building_id', $request->building);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'area_asc':
                $query->orderBy('area', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        $apartments = $query->paginate(9)->withQueryString();

        $ranges = [
            'price' => [
                'min' => Apartment::min('price') ?? 0,
                'max' => Apartment::max('price') ?? 40000000,
            ],
            'area' => [
                'min' => Apartment::min('area') ?? 20,
                'max' => Apartment::max('area') ?? 100,
            ],
            'floor' => [
                'min' => Apartment::min('floor') ?? 1,
                'max' => Apartment::max('floor') ?? 7,
            ],
        ];

        return view('apartments.index', compact('apartments', 'ranges'));
    }

    public function create()
    {
        return view('apartments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'building_id'    => 'required|integer|in:1,2',
            'title'          => 'required|string|max:255',
            'area'           => 'required|integer|min:20|max:100',
            'living_area'    => 'nullable|numeric|min:10|max:150',
            'rooms'          => 'required|integer|min:1|max:3',
            'floor'          => 'required|integer|min:1|max:7',
            'has_balcony'    => 'nullable|boolean',
            'ceiling_height' => 'nullable|numeric|min:2.5|max:4.0',
            'finishing'      => 'nullable|string|max:100',
            'price'          => 'nullable|integer|min:0|max:40000000',
            'status'         => 'required|in:free,booked,sold',
            'zone_number'    => 'required|integer|min:1|max:5',
            'image'          => 'nullable|image|mimes:jpg,png|max:2048',
            'description'    => 'nullable|string|max:1000',
        ]);

        $exists = Apartment::where('building_id', $validated['building_id'])
            ->where('floor', $validated['floor'])
            ->where('zone_number', $validated['zone_number'])
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'zone_number' => 'На этом этаже в данной зоне уже есть квартира!'
            ]);
        }

        $validated['has_balcony'] = $request->has('has_balcony');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('apartments', 'public');
        }

        Apartment::create($validated);

        return redirect()->route('apartments.index')->with('success', 'Квартира добавлена!');
    }

    public function show(Apartment $apartment)
    {
        return view('apartments.show', compact('apartment'));
    }

    public function edit(Apartment $apartment)
    {
        return view('apartments.edit', compact('apartment'));
    }

    public function update(Request $request, Apartment $apartment)
    {
        $validated = $request->validate([
            'building_id'    => 'required|integer|in:1,2',
            'title'          => 'required|string|max:255',
            'area'           => 'required|integer|min:20|max:100',
            'living_area'    => 'nullable|numeric|min:10|max:150',
            'rooms'          => 'required|integer|min:1|max:3',
            'floor'          => 'required|integer|min:1|max:7',
            'has_balcony'    => 'nullable|boolean',
            'ceiling_height' => 'nullable|numeric|min:2.5|max:4.0',
            'finishing'      => 'nullable|string|max:100',
            'price'          => 'nullable|integer|min:0|max:40000000',
            'status'         => 'required|in:free,booked,sold',
            'zone_number'    => 'required|integer|min:1|max:5',
            'image'          => 'nullable|image|mimes:jpg,png|max:2048',
            'description'    => 'nullable|string|max:1000',
        ]);

        $exists = Apartment::where('building_id', $validated['building_id'])
            ->where('floor', $validated['floor'])
            ->where('zone_number', $validated['zone_number'])
            ->where('id', '!=', $apartment->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'zone_number' => 'На этом этаже в данной зоне уже есть другая квартира!'
            ]);
        }

        $validated['has_balcony'] = $request->has('has_balcony');

        if ($request->hasFile('image')) {
            if ($apartment->image) {
                Storage::disk('public')->delete($apartment->image);
            }
            $validated['image'] = $request->file('image')->store('apartments', 'public');
        }

        $apartment->update($validated);

        return redirect()->route('apartments.index')->with('success', 'Квартира обновлена!');
    }

    public function destroy(Apartment $apartment)
    {
        if ($apartment->image) {
            Storage::disk('public')->delete($apartment->image);
        }
        $apartment->delete();
        return redirect()->route('apartments.index');
    }
}
