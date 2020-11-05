<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\OnDemandVideoRequest;
use App\Models\OnDemand;
use App\Jobs\ProcessVideoJob;

class OnDemandController extends Controller
{
    /**
     * Fetch library of all videos.
     * @author Stephen Medd | 28 Oct 2020
     *
     * @param None
     *
     * @return Json
     */
    public function library()
    {
        $library = OnDemand::latest()->paginate(25);

        return response()->json($library);
    }

    /**
     * Store a new on demand resource.
     * @author Stephen Medd | 28 Oct 2020
     *
     * @param App\Http\Requests\OnDemandVideoRequest $request
     *
     * @return Json
     */
    public function store(OnDemandVideoRequest $request)
    {
        $ondemand = OnDemand::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => auth()->user()->id
        ]);

        return response()->json($ondemand);
    }

    /**
     * Process image to store in S3.
     * @author Stephen Medd | 28 Oct 2020
     *
     * @param App\Models\OnDemand $ondemand
     * @param Request $request
     */
    public function uploadImage(OnDemand $ondemand, Request $request)
    {
        if ($request->has('files')) {
            foreach ($request->file('files') as $file) {

                /**
                 * Upload the image to the AWS S3 Bucket and set a public visibility.
                 */
                $file_path = Storage::disk('s3')->putFile('on-demand/images', $file, 'public');

                /**
                 * Save the root image path against the resource.
                 */
                $ondemand->update([
                    'image_path' => $file_path
                ]);
            }
        }

        return response()->json($ondemand);
    }

    /**
     * Upload recording and store in S3.
     * @author Stephen Medd | 28 Oct 2020
     *
     * @param App\Models\OnDemand $ondemand
     * @param Request $request
     *
     * @return Json
     */
    public function uploadVideo(OnDemand $ondemand, Request $request)
    {
        if ($request->has('files')) {
            foreach ($request->file('files') as $file) {

                /**
                 * Upload the raw video to the AWS S3 Bucket and set a public visibility.
                 */
                $file_path = Storage::disk('s3')->putFile('on-demand/raw-videos', $file, 'public');

                /**
                 * Queues the AWS Elastic Transcoder Job which will process the video into a streaming format.
                 * We will set this queue to it's own specific 'transcoding' pipeline so it doesn't conflict with any other queue workers.
                 */
                ProcessVideoJob::dispatch($class, 'ondemand')->onQueue('transcoding');
            }
        }

        return response()->json($ondemand);
    }
}
