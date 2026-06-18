<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    // GET /api/testimonials
    public function index()
    {
        return response()->json(Testimonial::latest()->get());
    }

    // POST /api/testimonials
    public function store(Request $request)
    {
        $validated = $request->validate([
            'initials'  => 'required|string|max:5',
            'name'      => 'required|string',
            'title'     => 'required|string',
            'review'    => 'required|string',
            'rating'    => 'required|integer|min:1|max:5',
            'is_active' => 'boolean',
        ]);

        $testimonial = Testimonial::create($validated);

        return response()->json($testimonial, 201);
    }

    // PUT /api/testimonials/{testimonial}
    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'initials'  => 'required|string|max:5',
            'name'      => 'required|string',
            'title'     => 'required|string',
            'review'    => 'required|string',
            'rating'    => 'required|integer|min:1|max:5',
            'is_active' => 'boolean',
        ]);

        $testimonial->update($validated);

        return response()->json($testimonial);
    }

    // PATCH /api/testimonials/{testimonial}/toggle
    public function toggle(Testimonial $testimonial)
    {
        $testimonial->update(['is_active' => !$testimonial->is_active]);

        return response()->json([
            'id'        => $testimonial->id,
            'is_active' => $testimonial->is_active,
        ]);
    }

    // DELETE /api/testimonials/{testimonial}
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}

