<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AdminRequest;
use App\Models\User;
use App\Models\Trainer;

class AdminController extends Controller
{
    /**
     * Fetch paginated list of all admins.
     * @author Stephen Medd | 29 Oct 2020
     *
     * @param None
     *
     * @return Json
     */
    public function all()
    {
        $admins = User::onlyAdmins()->latest()->paginate(50);

        return response()->json($admins);
    }

    /**
     * Load a single admin profile.
     * @author Stephen Medd | 29 Oct 2020
     *
     * @param App\Models\User $user
     *
     * @return Json
     */
    public function single(User $user)
    {
        return response()->json($user);
    }

    /**
     * Validate and store a new admin account.
     * @author Stephen Medd | 29 Oct 2020
     *
     * @param App\Http\Requests\AdminRequest $request
     *
     * @return Json
     */
    public function store(AdminRequest $request)
    {
        $user = User::create([
            'role_id' => 2, // This role ID is for normal administrators only
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make(\Str::random(100)) // A random string is assigned to this password as the recipient will recieve an email to confirm account and set a password
        ]);

        return response()->json($user);
    }

    /**
     * Process profile picture to store in S3.
     * @author Stephen Medd | 28 Oct 2020
     *
     * @param App\Models\User $user
     * @param Request $request
     */
    public function uploadImage(User $user, Request $request)
    {
        if ($request->has('files')) {
            foreach ($request->file('files') as $file) {

                /**
                 * Upload the image to the AWS S3 Bucket and set a public visibility.
                 */
                $file_path = Storage::disk('s3')->putFile('admins', $file, 'public');

                /**
                 * Save the root image path against the user.
                 */
                $user->update([
                    'image_path' => $file_path
                ]);
            }
        }

        return response()->json($user);
    }
}
