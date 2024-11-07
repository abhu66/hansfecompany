<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

use GuzzleHttp\Client;

class CompanyController extends Controller
{
    public function companyCheck()
    {
        try {
            $token = Session::get('token');

            $response = Http::withHeaders([])->post(env('API_URL') . '/api/v1/company/check', [
                'url'=> request()->root() . "/",
            ]);
            return $response;

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Get the response and decode JSON
            $response = $e->getResponse();
            $responseBody = json_decode($response->getBody()->getContents(), true);

            // Extract error message and redirect back with the message
            $errorMessage = $responseBody['message'] ?? 'Something went wrong.';
            return redirect()->back()->with('error', $errorMessage);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function companyNotFound () {
        return view('pages.company_not_found.index');
    }


     public function showCompany()
        {
            try {
                $token = Session::get('token');

               $response = Http::withHeaders([
                   'Authorization' => 'Bearer ' . $token,
               ])->post(env('API_URL') . '/api/admin/company/get');
//                   dd($response);
               if ($response->successful() && $response->json('success')) {
                   $data = $response->json('data');
                   $data = json_decode($response);
                   $company = $data->data;

                   return view("pages.company.index", compact("company"));
               }

            } catch (\GuzzleHttp\Exception\ClientException $e) {
                // Get the response and decode JSON
                $response = $e->getResponse();
                $responseBody = json_decode($response->getBody()->getContents(), true);

                // Extract error message and redirect back with the message
                $errorMessage = $responseBody['message'] ?? 'Something went wrong.';
                return redirect()->back()->with('error', $errorMessage);
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', $th->getMessage());
            }
        }


         public function showDetailCompany($id)
            {
                try {
                    $token = Session::get('token');

                    $response_detail_company = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $token,
                    ])->post(env('API_URL') . '/api/admin/company/view', [
                        'id' => $id,
                    ]);

                    if ($response_detail_company->successful() && $response_detail_company->json('success')) {
                        $data_detail_company = $response_detail_company->json('data');
                        $d_company = json_decode(json_encode($data_detail_company));
                        return view("pages.company.detail.index", compact("d_company"));
                    } else {
                        //$data = $response->json('message');

                        return view("pages.company.detail.index", compact("d_company",));
                    }
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    // Get the response and decode JSON
                    $response = $e->getResponse();
                    $responseBody = json_decode($response->getBody()->getContents(), true);
                    // Extract error message and redirect back with the message
                    $errorMessage = $responseBody['message'] ?? 'Something went wrong.';
                    return redirect()->back()->with('error', $errorMessage);
                } catch (\Throwable $th) {
                    return redirect()->back()->with('error', $th->getMessage());
                }
            }



        public function store(Request $request)
            {
                try {
                    $company_name = $request->company_name;
                    $is_active = $request->is_active;
                    $url = $request->url;

                    $client = new Client();
                    $res = $client->request('POST', env('API_URL') . '/api/admin/company/create',  [
                        'headers' => [
                            'Authorization' => 'Bearer ' . Session::get('token'),
                        ],
                        'verify' => false,
                        'json' => [ // Gunakan 'json' untuk mengirimkan data sebagai JSON
                            'company_name' => $company_name,
                            'is_active' => $is_active ? true : false, // Set true/false sesuai checkbox
                            'url' => $url
                        ],
                    ]);

                    return redirect()->route('company');

                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    // Get the response and decode JSON
                    $response = $e->getResponse();
                    $responseBody = json_decode($response->getBody()->getContents(), true);

                    // Extract error message and redirect back with the message
                    $errorMessage = $responseBody['message'] ?? 'Something went wrong.';
                    return redirect()->back()->with('error', $errorMessage);
                } catch (\Throwable $th) {
                    return redirect()->back()->with('error', $th->getMessage());
                }
            }


        public function create()
        {
            try {
                $token = Session::get('token');
                if (!$token) {
                    return redirect()->back()->with('error', 'Token tidak ditemukan.');
                }
               return view("pages.company.add.index");
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                // Get the response and decode JSON
                $response = $e->getResponse();
                $responseBody = json_decode($response->getBody()->getContents(), true);

                // Extract error message and redirect back with the message
                $errorMessage = $responseBody['message'] ?? 'Something went wrong.';
                return redirect()->back()->with('error', $errorMessage);
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', $th->getMessage());
            }
        }

         public function edit($id)
            {
                try {
                    $token = Session::get('token');
                    $response_detail_company = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $token,
                    ])->post(env('API_URL') . '/api/admin/company/view', [
                        'id' => $id,
                    ]);

                    if ($response_detail_company->successful() && $response_detail_company->json('success') ) {
                        $data_detail_company = $response_detail_company->json('data');
                        $f_company = json_decode(json_encode($data_detail_company));



                        return view("pages.company.edit.index", compact("f_company",));
                    } else {
                        //$data = $response->json('message');
                       $f_company = [];

                        return view("pages.company.edit.index", compact("f_company"));
                    }
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    // Get the response and decode JSON
                    $response = $e->getResponse();
                    $responseBody = json_decode($response->getBody()->getContents(), true);

                    // Extract error message and redirect back with the message
                    $errorMessage = $responseBody['message'] ?? 'Something went wrong.';
                    return redirect()->back()->with('error', $errorMessage);
                } catch (\Throwable $th) {
                    return redirect()->back()->with('error', $th->getMessage());
                }
            }

            public function update(Request $request)
                {
                    try {
                        $id = $request->id;
                        $company_name = $request->company_name;
                        $is_active = $request->is_active; // Ambil status aktif dari checkbox
                        $url = $request->url; // Ambil array ID role dari checkbox

                        $client = new Client();
                        $res = $client->request('POST', env('API_URL') . '/api/admin/company/update',  [
                            'headers' => [
                                'Authorization' => 'Bearer ' . Session::get('token'),
                            ],
                            'verify' => false,
                            'json' => [ // Gunakan 'json' untuk mengirimkan data sebagai JSON
                                'id' => $id,
                                'company_name' => $company_name,
                                'is_active' => $is_active ? true : false, // Set true/false sesuai checkbox
                                'url' => $url, // Ambil id role yang di ceklis
                            ],
                        ]);

                        return redirect()->route('company');
                    } catch (\GuzzleHttp\Exception\ClientException $e) {
                        // Get the response and decode JSON
                        $response = $e->getResponse();
                        $responseBody = json_decode($response->getBody()->getContents(), true);

                        // Extract error message and redirect back with the message
                        $errorMessage = $responseBody['message'] ?? 'Something went wrong.';
                        return redirect()->back()->with('error', $errorMessage);
                    } catch (\Throwable $th) {
                        return redirect()->back()->with('error', $th->getMessage());
                    }
                }

}
