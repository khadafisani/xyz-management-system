<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Requests\FeedbackRequest;
use Illuminate\Support\Facades\Storage;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedback = Feedback::all();
        return response()->api($feedback, 200, 'ok', 'Sucessfully get feedbacks');
    }

    public function store(FeedbackRequest $request)
    {
        $data = $request->validated();

        \DB::beginTransaction();
        try {
            if(isset($data['file'])) {
                $saveImage = Storage::disk('public')->put('feedbacks', $data['file']);

                $data['file_path'] = $saveImage;
            }

            $feedback = Feedback::create($data);

            \DB::commit();
            return response()->api($feedback, 200, 'ok', 'Sucessfully store feedback');
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->api([], 400, 'error', 'Failed to store feedback');
        }
    }

    public function show(Feedback $feedback)
    {
        return response()->api($feedback, 200, 'ok', 'Sucessfully get feedback');
    }

    public function update(FeedbackRequest $request, Feedback $feedback)
    {
        $data = $request->validated();

        \DB::beginTransaction();
        try {
            $feedback->update($data);

            \DB::commit();
            return response()->api($feedback, 200, 'ok', 'Sucessfully update feedback');
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->api([], 400, 'error', 'Failed to update feedback');
        }
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return response()->api([], 200, 'ok', 'Sucessfully delete feedback');
    }
}
