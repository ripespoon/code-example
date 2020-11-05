<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\OnDemandCategoryRequest;
use App\Models\OnDemand;
use App\Models\OnDemandCategory;

class OnDemandCategoryController extends Controller
{
    /**
     * Fetch all on demand video categories.
     * @author Stephen Medd | 29 Oct 2020
     *
     * @param None
     *
     * @return Json
     */
    public function all()
    {
        $categories = OnDemandCategory::orderBy('created_at', 'DESC')->get();

        return response()->json($categories);
    }

    /**
     * Store a new on demand resource.
     * @author Stephen Medd | 29 Oct 2020
     *
     * @param App\Http\Requests\OnDemandCategoryRequest $request
     *
     * @return Json
     */
    public function store(OnDemandCategoryRequest $request)
    {
        $category = OnDemandCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => auth()->user()->id
        ]);

        return response()->json($category);
    }

    /**
     * Process image to store in S3.
     * @author Stephen Medd | 29 Oct 2020
     *
     * @param App\Models\OnDemandCategory $category
     * @param Request $request
     */
    public function uploadImage(OnDemandCategory $category, Request $request)
    {
        if ($request->has('files')) {
            foreach ($request->file('files') as $file) {

                /**
                 * Upload the image to the AWS S3 Bucket and set a public visibility.
                 */
                $file_path = Storage::disk('s3')->putFile('on-demand-categories/images', $file, 'public');

                /**
                 * Save the root image path against the category.
                 */
                $category->update([
                    'image_path' => $file_path
                ]);
            }
        }

        return response()->json($category);
    }
}
