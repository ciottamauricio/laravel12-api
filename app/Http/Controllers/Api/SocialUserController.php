<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Services\SocialApi\SocialApiFactory;

class SocialUserController extends Controller
{
    public function fetchAndSave(Request $request)
    {
        $request->validate([
            'provider' => 'required|string',
            'username' => 'required|string',
        ]);

        $provider = $request->input('provider');
        $username = $request->input('username');

        try
        {
            $service = SocialApiFactory::make($provider);
            $userData = $service->fetchUserData($username);

            // save with eloquent and model

            return response()->json(['message' => 'User data saved successfully', 'user' => $userData]);
        }
        catch (Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
