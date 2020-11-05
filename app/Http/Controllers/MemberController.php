<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class MemberController extends Controller
{
    /**
     * Fetch paginated list of all members.
     * @author Stephen Medd | 29 Oct 2020
     *
     * @param None
     *
     * @return Json
     */
    public function all()
    {
        $members = User::onlyMembers()->latest()->paginate(50);

        return response()->json($members);
    }

    /**
     * Load a single member profile.
     * @author Stephen Medd | 29 Oct 2020
     *
     * @param App\Models\User $member
     *
     * @return Json
     */
    public function single(User $member)
    {
        return response()->json($member);
    }
}
