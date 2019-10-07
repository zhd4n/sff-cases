<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCaseRequest;
use App\Http\Requests\UpdateCaseRequest;
use App\Models\Parts\CasePart;
use Spatie\MediaLibrary\FileAdder\FileAdder;

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
        return view('item', compact('case'));
    }

    public function create()
    {
        return view('form');
    }

    public function edit(CasePart $casePart)
    {
        return view('form', ['case' => $casePart]);
    }

    public function store(StoreCaseRequest $request)
    {
        $data = $request->validated();

//        $data = Arr::sort($data, function($value) {
//            $order = ['type', 'psu'];
//            return $order[$value] ?? 100;
//        });

        $case = CasePart::create($data);

        if ($request->hasFile('images.*')) {
            $case->addMultipleMediaFromRequest(['images'])->each(function(FileAdder $fileAdder) {
                $fileAdder->preservingOriginal()->toMediaCollection('gallery');
            });
        }

        return back()->with('message', ['status' => 'success', 'message' => 'Case saved successfully']);
    }

    public function update(CasePart $casePart, UpdateCaseRequest $request)
    {
        $data = $request->validated();

        $casePart->fill($data)->save();

        if ($request->hasFile('images.*')) {
            $casePart->addMultipleMediaFromRequest(['images'])->each(function(FileAdder $fileAdder) {
                $fileAdder->preservingOriginal()->toMediaCollection('gallery');
            });
        }

        return response()
            ->redirectToRoute('cases.show', $casePart)
            ->with('message', ['status' => 'success', 'message' => 'Case saved successfully']);
    }

    public function delete(CasePart $casePart)
    {
        if (! $casePart->delete()) {
            //session()->flash('message', ['status' => 'error', 'message' => 'Error deleting case']);
            return ['status' => 'error', 'message' => 'Error deleting case'];
        }

        session()->flash('message', ['status' => 'success', 'message' => 'Item deleted successfully']);

        return ['status' => 'success', 'redirect' => route('cases.index')];
    }

    public function deleteMedia(CasePart $case, int $mediaId)
    {
        $case->deleteMedia($mediaId);
    }

    public function deleteAllMedia(CasePart $case)
    {
        $case->clearMediaCollection('gallery');
    }
}
