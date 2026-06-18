<?php

namespace App\Http\Controllers;

use App\Models\Careers;

use Illuminate\Http\Request;

class JobController extends Controller
{
    // Create Job
    public function store(Request $request){

   $validated = $request->validate([
    'title'       => 'required|string|max:255',
    'department'  => 'required|string|max:255',
    'location'    => 'nullable|string|max:255',
    'experience'  => 'nullable|string|max:255',
    'type'        => 'nullable|string|max:255',
    'description' => 'nullable|string',
    'skills'      => 'nullable|array',
]);
        $validated = Careers::create([
            'title' => $request->title,
            'department' => $request->department,
            'location' => $request->location,
            'experience' => $request->experience,
            'type' => $request->type,
            'description' => $request->description,
            'skills' =>  $request->skills,

        ]);

        return response()->json([
            'message' => 'Job created successfully',
            'job' => $validated
        ]);
    }

    // Get All Jobs
    public function index()
    {
        return response()->json(Careers::all());
    }

    // Get Single Job
    public function show($id)
    {
        return response()->json(Careers::find($id));
    }
     public function destroy(Careers $careers)
    {
        $careers->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }

        public function toggle(Careers $careers)
    {
        $careers->update(['is_active' => !$careers->is_active]);

        return response()->json([
            'id'        => $careers->id,
            'is_active' => $careers->is_active,
        ]);
}

public function update(Request $request, Careers $careers)
    {
        $validated = $request->validate([
    'title'       => 'required|string|max:255',
    'department'  => 'required|string|max:255',
    'location'    => 'nullable|string|max:255',
    'experience'  => 'nullable|string|max:255',
    'type'        => 'nullable|string|max:255',
    'description' => 'nullable|string',
    'skills'      => 'nullable|array',
        ]);
        $careers->update($validated);

        return response()->json($careers);
    }
}
