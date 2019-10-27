<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCaseRequest;
use App\Models\Parts\CasePart;

class CaseController extends Controller
{
    public function index()
    {
        $cases = CasePart::with('media')->latest()->get();

        return view('index', compact('cases'));
    }

    public function show(CasePart $casePart)
    {
        $case = $casePart;
        $case->load('media');

        return view('item', compact('case'));
    }

    public function create()
    {
        return view('form');
    }

    public function update(CasePart $casePart, UpdateCaseRequest $request)
    {
        $data = $request->validated();

        $casePart->fill($data)->save();

        session()->flash('message', 'Data successfully updated');

        return ['status' => 'success', 'redirect' => route('cases.show', $casePart->slug)];
    }

    public function edit(CasePart $casePart)
    {
        $casePart->load('media');

        return view('form', ['case' => $casePart]);
    }

    public function destroy(CasePart $casePart)
    {
        if (! $casePart->delete()) {
            return ['status' => 'error', 'message' => 'Error deleting case'];
        }

        return ['status' => 'success', 'redirect' => route('cases.index')];
    }

    public function deleteMedia(CasePart $casePart, int $mediaId)
    {
        $casePart->deleteMedia($mediaId);
    }

    public function deleteAllMedia(CasePart $case)
    {
        $case->clearMediaCollection('gallery');
    }
}
