<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function createProject(Request $request)
    {
        $title = $request->input('title');
        $service = $request->input('service');
        $client = $request->input('client');
        $description = $request->input('description');
        $status = $request->input('status');

        if (
            empty($title) ||
            empty($service) ||
            empty($client) ||
            empty($description) ||
            empty($status)
        ) {
            return response()->json([
                'message' => 'All fields are required'
            ], 400);
        }

        Project::create([
            'title' => $request->input('title'),
            'service' => $request->input('service'),
            'client' => $request->input('client'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
        ]);
        return response()->json([
            'message' => 'Project submitted successfully'
        ], 200);
    }

    public function getProjects(Request $request)
    {
        $projects = Project::all();
        return response()->json($projects);
    }

     public function delete($id){
        $project = Project::findorFail($id);
        if (!$project) {
            return response()->json([
                'message' => 'Project not found'
            ], 404);
        }
        $project->delete();
        return response()->json([
            'message' => 'Project deleted successfully'
        ], 200);
    }

    public function updateProject(Request $request, $id)
    {
        $project = Project::findorFail($id);
        if (!$project) {
            return response()->json([
                'message' => 'Project not found'
            ], 404);
        }

        $title = $request->input('title');
        $service = $request->input('service');
        $client = $request->input('client');
        $description = $request->input('description');
        $status = $request->input('status');

        if (
            empty($title) ||
            empty($service) ||
            empty($client) ||
            empty($description) ||
            empty($status)
        ) {
            return response()->json([
                'message' => 'All fields are required'
            ], 400);
        }

        $project->update([
            'title' => $request->input('title'),
            'service' => $request->input('service'),
            'client' => $request->input('client'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
        ]);
        return response()->json([
            'message' => 'Project updated successfully'
        ], 200);
    }
}


