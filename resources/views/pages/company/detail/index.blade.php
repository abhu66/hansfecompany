@extends('layouts.app')
@section('title', 'Detail Company Page')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Detail Company Form</h4>
                </div>
                <div class="card-body">

                    {{-- Menampilkan pesan kesalahan validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (Session::has('error'))
                        <div class="alert alert-danger justify-content-start align-items-center" role="alert">
                            {{ Session::get('error') }}
                        </div>
                    @endif

                    <form>
                        @csrf
                        <div class="row g-3">

                            <div class="col-lg-6">
                                <div>
                                    <label class="form-label" for="company_name">Company Name</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name" disabled
                                        placeholder="Enter your name" value="{{ $d_company->company_name }}" required />
                                </div>
                            </div>


                          <div class="col-lg-6">
                                <div>
                                    <label class="form-label" for="url">Url</label>
                                    <input type="text" class="form-control" id="url" name="url" disabled
                                        placeholder="Enter url" value="{{ $d_company->url }}" required />
                                </div>
                            </div>

                          <div class="col-lg-6">
                              <div>
                                  <label class="form-label" for="is_active">Is Active</label>
                                  <div class="form-check mt-2">
                                      <input type="checkbox" class="form-check-input" id="is_active" name="is_active" disabled
                                          value="1" {{ isset($d_company) && $d_company->is_active == 1 ? 'checked' : '' }}>
                                      <label class="form-check-label" for="is_active">Active</label>
                                  </div>
                              </div>
                          </div>

                            <div class="col-lg-6">
                                <div>
                                    <label class="form-label" for="created_date">Created date</label>
                                    <input type="text" class="form-control" id="created_date" name="created_date"
                                        disabled placeholder="Enter created date" value="{{ $d_company->created_date ? \Carbon\Carbon::parse($d_company->created_date)->format('d-m-Y H:i') : '-' }}"
                                        required />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div>
                                    <label class="form-label" for="updated_date">Updated date</label>
                                    <input type="text" class="form-control" id="updated_date" name="updated_date"
                                        disabled placeholder="Enter updated date" value="{{ $d_company->updated_date ? \Carbon\Carbon::parse($d_company->updated_date)->format('d-m-Y H:i') : '-' }}"
                                        required />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div>
                                    <label class="form-label" for="created_by">Created by</label>
                                    <input type="text" class="form-control" id="created_by" name="created_by" disabled
                                        placeholder="Enter created by" value="{{ $d_company->created_by }}" required />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div>
                                    <label class="form-label" for="updated_by">Updated by</label>
                                    <input type="text" class="form-control" id="updated_by" name="updated_by" disabled
                                        placeholder="Enter updated by" value="{{ $d_company->updated_by }}" required />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>

@endsection
