<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    private $apiUrl;
    private $token;

    public function __construct()
    {
        $this->apiUrl = config('app.url') . '/api';
        $this->token = Session::get('api_token'); // Get token from session
    }

    public function index()
    {
        // $token = Session::get('api_token');
        // dd($token);

        try {
            $response = Http::withToken($this->token)
                ->get("{$this->apiUrl}/customers");

            $customers = $response->successful() ? $response->json() : [];
            
            return view('customers.index', compact('customers'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch customers');
        }
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        try {
            $response = Http::withToken($this->token)
                ->post("{$this->apiUrl}/customers", $request->all());

            if ($response->successful()) {
                return redirect()->route('customers.index')
                    ->with('success', 'Customer created successfully');
            }

            return redirect()->back()
                ->withErrors($response->json()['errors'] ?? ['Failed to create customer'])
                ->withInput();

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create customer')
                ->withInput();
        }
    }

    public function show($id)
    {
        try {
            $response = Http::withToken($this->token)
                ->get("{$this->apiUrl}/customers/{$id}");

            if ($response->successful()) {
                $customer = $response->json();
                return view('customers.show', compact('customer'));
            }

            return redirect()->route('customers.index')
                ->with('error', 'Customer not found');

        } catch (\Exception $e) {
            return redirect()->route('customers.index')
                ->with('error', 'Failed to fetch customer');
        }
    }

    public function edit($id)
    {
        try {
            $response = Http::withToken($this->token)
                ->get("{$this->apiUrl}/customers/{$id}");

            if ($response->successful()) {
                $customer = $response->json();
                return view('customers.edit', compact('customer'));
            }

            return redirect()->route('customers.index')
                ->with('error', 'Customer not found');

        } catch (\Exception $e) {
            return redirect()->route('customers.index')
                ->with('error', 'Failed to fetch customer');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $response = Http::withToken($this->token)
                ->put("{$this->apiUrl}/customers/{$id}", $request->all());

            if ($response->successful()) {
                return redirect()->route('customers.index')
                    ->with('success', 'Customer updated successfully');
            }

            return redirect()->back()
                ->withErrors($response->json()['errors'] ?? ['Failed to update customer'])
                ->withInput();

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update customer')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $response = Http::withToken($this->token)
                ->delete("{$this->apiUrl}/customers/{$id}");

            if ($response->successful()) {
                return redirect()->route('customers.index')
                    ->with('success', 'Customer deleted successfully');
            }

            return redirect()->back()
                ->with('error', 'Failed to delete customer');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete customer');
        }
    }
}
