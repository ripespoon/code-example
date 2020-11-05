<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\TrainerRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Trainer;

class TrainerController extends Controller
{
    /**
     * Fetch paginated list of all trainers.
     * @author Stephen Medd | 29 Oct 2020
     *
     * @param None
     *
     * @return Json
     */
    public function all()
    {
        $trainers = User::onlyTrainers()->latest()->paginate(50);

        return response()->json($trainers);
    }

    /**
     * Load a single trainer user.
     * @author Stephen Medd | 29 Oct 2020
     *
     * @param App\Models\User $trainer
     *
     * @return Json
     */
    public function single(User $trainer)
    {
        return response()->json($trainer);
    }

    /**
     * Validate and store a new trainer user and also create a trainer profile.
     * @author Stephen Medd | 29 Oct 2020
     *
     * @param App\Http\Requests\TrainerRequest $request
     *
     * @return Json
     */
    public function store(TrainerRequest $request)
    {
        $user = User::create([
            'role_id' => 3, // This role ID is for trainer accounts only
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make(\Str::random(100)) // A random string is assigned to this password as the recipient will recieve an email to confirm account and set a password
        ]);

        Trainer::create([
            'user_id' => $user->id,
            'biography' => $request->biography
        ]);

        return response()->json($user);
    }

    /**
     * Process profile picture to store in S3.
     * @author Stephen Medd | 28 Oct 2020
     *
     * @param App\Models\User $user
     * @param Request $request
     *
     * @return Json
     */
    public function uploadImage(User $user, Request $request)
    {
        if ($request->has('files')) {
            foreach ($request->file('files') as $file) {

                /**
                 * Upload the image to the AWS S3 Bucket and set a public visibility.
                 */
                $file_path = Storage::disk('s3')->putFile('trainers', $file, 'public');

                /**
                 * Save the root picture path against the trainer profile.
                 */
                $user->trainer->update([
                    'image_path' => $file_path
                ]);
            }
        }

        return response()->json($user);
    }
}
