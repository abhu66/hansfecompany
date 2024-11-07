@extends('layouts.app')
@section('title', 'Add Company Page')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Add Company Form</h4>
                </div>
                <div class="card-body">

                    {{-- Menampilkan pesan kesalahan validasi --}}
                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}

                    @if (Session::has('error'))
                        <div class="alert alert-danger justify-content-start align-items-center" role="alert">
                            {{ Session::get('error') }}
                        </div>
                    @endif

                    <form action="{{ route('company.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">


                            <div class="col-lg-6">
                                <div>
                                    <label class="form-label" for="company_name">Name</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name"
                                        placeholder="Enter company name" required />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div>
                                    <label class="form-label" for="url">Url</label>
                                    <input type="text" class="form-control" id="url" name="url"
                                        placeholder="Enter URL" required />
                                </div>
                            </div>

                           <div class="col-lg-12">
                                                           <div class="form-check mt-1">
                                                               <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                                                                   value="1" {{ isset($data) && $data->is_active == 1 ? 'checked' : '' }} checked>
                                                               <label class="form-check-label ms-2" for="is_active">Is Active</label>
                                                           </div>
                                                       </div>
                            <div class="col-lg-12">
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary">Add</button>
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
@push('script')
    <script>
        function togglePassword(fieldId, eyeIcon) {
            const field = document.getElementById(fieldId);
            const icon = eyeIcon.querySelector('i');

            if (field.type === "password") {
                field.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endpush
