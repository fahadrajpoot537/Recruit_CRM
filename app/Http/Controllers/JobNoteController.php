<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobNote;
use Illuminate\Http\Request;

class JobNoteController extends Controller
{
    //index
    public function index($jobId)
    {
        $job = Job::with(['notes.createdBy'])->findOrFail($jobId);

        return view('jobs.show', compact('job'))->render();
    }
    //store
    public function store(Request $request)
    {
        // dd($request->all());
        //
        try {
            $data = $request->validate([
                'job_id' => 'required',
                'note' => 'required',
                'type' => 'nullable|in:Call,To Do',
                'collaborator'  => 'nullable|array',
                'collaborator.*' => 'exists:users,id'
            ]);

            $data['created_by'] = auth()->user()->id;
            $jobNote = JobNote::create($data);
            if (!empty($data['collaborator'])) {

                $collaboratorsData = array_map(function ($id) {
                    return ['collaborator_id' => $id];
                }, $data['collaborator']);
                //   dd($collaboratorsData);
                $jobNote->collaborators()->createMany($collaboratorsData);
            }
            $job = Job::with('notes.createdBy')->findOrFail($data['job_id']);
            $html = view('jobs.notes_block', compact('job'))->render();
           return response()->json(['html' => $html, 'message' => 'Note updated successfully!']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    //edit
    public function edit($id)
    {
        try {
            $jobNote = JobNote::with('collaborators')->findOrFail($id);
            return response()->json([
                'note' => $jobNote,
                'collaborators' => $jobNote->collaborators->pluck('collaborator_id')
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //update
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'note' => 'required',
                'type' => 'nullable|in:Call,To Do',
                'collaborator'  => 'nullable|array',
                'collaborator.*' => 'exists:users,id',
                'job_id' => 'required',
            ]);

            $data['created_by'] = auth()->id();
            $jobNote = JobNote::findOrFail($id);
            $jobNote->update($data);

            // Replace collaborators
            $jobNote->collaborators()->delete();
            if (!empty($data['collaborator'])) {
                $collaboratorsData = array_map(fn($id) => ['collaborator_id' => $id], $data['collaborator']);
                $jobNote->collaborators()->createMany($collaboratorsData);
            }

            // Return the updated notes block HTML
            $job = Job::with(['notes.createdBy'])->findOrFail($data['job_id']);
            $html = view('jobs.notes_block', compact('job'))->render();

            return response()->json(['html' => $html, 'message' => 'Note updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
