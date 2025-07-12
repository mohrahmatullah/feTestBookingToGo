<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $apiHost;
    public function __construct()
    {
        $host = config('app.api_host', 'http://localhost:8081');
        if (!$host) {
            abort(500, 'API host not configured. Please set API_HOST in your .env file.');
        }
        $this->apiHost = $host;
    }
    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        $limit = $request->query('limit', 10);

        $response = Http::get("{$this->apiHost}/api/customers", [
            'page' => $page,
            'limit' => $limit
        ]);

        // pastikan sukses
        if (!$response->successful()) {
            abort(500, "Gagal mengambil data customer dari API");
        }

        $customers = $response->json()['data'] ?? [];

        return view('customers.list', compact('customers'));
    }

    public function create()
    {
        $nationalities = $this->getNationalities()['data'] ?? [];

        return view('customers.create', compact('nationalities'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'CstName' => 'required|string',
            'CstDob' => 'required|date',
            'NationalityID' => 'required|integer',
            'Family.*.FlName' => 'required|string',
            'Family.*.FlDob' => 'required|date',
        ]);

        $post = $request->all();
        $post['NationalityID'] = (int)$request->input('NationalityID');

        // Panggil API pakai HTTP Client
        $response = Http::post("{$this->apiHost}/api/customers", $post);

        if ($response->successful()) {
            return redirect()->route('customers.index')->with('success', 'Data berhasil ditambahkan!');
        } else {
            return redirect()->route('customers.index')->with('error', 'Gagal mengirim data!');
        }
    }

    public function edit($id)
    {
        $response = Http::get("{$this->apiHost}/api/customers/{$id}");

        if (!$response->successful()) {
            abort(404, 'Customer tidak ditemukan.');
        }

        $customer = $response->json()['data'] ?? null;
        $nationalities = $this->getNationalities()['data'] ?? [];

        return view('customers.edit', compact('customer', 'nationalities'));
    }

    public function update(Request $request, $id)
    {
        $host = config('app.api_host', 'localhost:8081');
        // Validasi input sederhana
        $request->validate([
            'CstName' => 'required|string|max:255',
            'CstDob' => 'required|date',
            'NationalityID' => 'required|integer',
            'Family' => 'required|array',
            'Family.*.FlName' => 'required|string',
            'Family.*.FlDob' => 'required|date',
        ]);
        $post = $request->all();
        $post['NationalityID'] = (int)$request->input('NationalityID');
        $response = Http::put("{$this->apiHost}/api/customers/{$id}", $post);

        if (!$response->successful()) {
            return back()->with('error', 'Gagal update customer.');
        }

        return redirect()->route('customers.index')->with('success', 'Customer berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $response = Http::delete("{$this->apiHost}/api/customers/{$id}");

        if ($response->successful()) {
            return redirect()->route('customers.index')->with('success', 'Customer berhasil dihapus');
        } else {
            return redirect()->route('customers.index')->with('error', 'Gagal menghapus customer');
        }
    }

    private function getNationalities()
    {
        $response = Http::get("{$this->apiHost}/api/nationalities");

        if ($response->successful()) {
            return $response->json();
        }
        return [];
    }

}
