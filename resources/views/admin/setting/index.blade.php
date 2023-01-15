@extends('layouts.app')

@section('title', 'Setting Admin')

@section('prehead')
<link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@inject('carbon', 'Carbon\Carbon')
@inject('carbonInterval', 'Carbon\CarbonInterval')

@section('content')
<div id="app" v-cloak>

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="container-xxl" id="kt_content_container">
            <!--begin::Row-->
            <div class="card card-dashed">
                <div class="card-header">
                    <h3 class="card-title">Setting Halaman Admin</h3>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-sm btn-warning">
                            Edit
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row form-group mb-4 col-12">
                        <div class="col-4">
                            <h4>Favicon</h4>
                        </div>
                        <div class="col-8">
                            <h4> : &nbsp; isinya</h4>
                        </div>
                    </div>

                    <div class="row form-group mb-4 col-12">
                        <div class="col-4">
                            <h4>Logo</h4>
                        </div>
                        <div class="col-8">
                            <h4> : &nbsp; isinya</h4>
                        </div>
                    </div>

                    <div class="row form-group mb-4 col-12">
                        <div class="col-4">
                            <h4>Logo Login</h4>
                        </div>
                        <div class="col-8">
                            <h4> : &nbsp; isinya</h4>
                        </div>
                    </div>

                </div>

            </div>


            <div class="card card-flush border-0 h-xl-100">
                <!--begin::Body-->
                <div class="card-body py-9">
                    <!--begin::Row-->
                    <div class="row gx-9 h-100">
                        <!--begin::Col-->
                        <div class="col-sm-6 mb-10 mb-sm-0">
                            <!--begin::Overlay-->
                            <a class="d-block overlay h-100" data-fslightbox="lightbox-hot-sales" href="{{ asset('assets/booking-room/images/background-display.png') }}">
                                <!--begin::Image-->
                                <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-200px h-100" style="background-image:url('{{ asset('assets/booking-room/images/background-display.png') }}')"></div>
                                <!--end::Image-->
                                <!--begin::Action-->
                                <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                    <i class="bi bi-eye-fill fs-2x text-white"></i>
                                </div>
                                <!--end::Action-->
                            </a>
                            <!--end::Overlay-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-sm-6">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column h-100">
                                <!--begin::Header-->
                                <div class="mb-7">
                                    <!--begin::Title-->
                                    <div class="mb-6">
                                        <a href="../../demo4/dist/apps/projects/users.html" class="text-gray-800 text-hover-primary fs-1 fw-bolder">Tampilan Display</a>
                                    </div>
                                    <!--end::Title-->

                                    <!--end::Items-->
                                </div>
                                <!--end::Header-->
                                <!--begin::Body-->
                                <div class="d-flex flex-column border border-1 border-gray-300 text-center pt-5 pb-7 mb-8 card-rounded">

                                    <span class="fw-bolder text-gray-600 fs-4 pb-5">Upload gambar untuk merubah tampilan display</span>

                                    <span class="fw-bold text-gray-600 fs-7 pb-1">Upload gambar dengan format (.jpg, .jpeg, .png)</span>
                                    <span class="fw-bolder text-gray-800 fs-3"> <input type="file" class="form-control"></span>
                                </div>
                                <!--end::Body-->
                                <!--begin::Footer-->
                                <div class="d-flex flex-stack mt-auto bd-highlight">
                                    <!--begin::Actions-->
                                    <a href="#" class="btn btn-primary btn-sm flex-shrink-0 me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_bidding">Place a Bid</a>
                                    <a href="#" class="btn btn-light btn-sm flex-shrink-0" data-bs-toggle="modal" data-bs-target="#kt_modal_users_search">View Item</a>
                                    <!--end::Actions-->
                                </div>
                                <!--end::Footer-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 15-->


        </div>
        <br>
        <br>

    </div>
    @endsection
    @section('script')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    @endsection

    @section('pagescript')
    <script>
        let app = new Vue({
            el: '#app',
            data: {

                loading: false,
            },
            methods: {
                toCurrency: function(number) {
                    return new Intl.NumberFormat('De-de').format(number);
                },
                deleteRecord: function(id) {
                    Swal.fire({
                        title: 'Yakin Ingin Menghapus data?',
                        text: "data akan di hapus di system",
                        icon: 'warning',
                        reverseButtons: true,
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Delete',
                        cancelButtonText: 'Cancel',
                        showLoaderOnConfirm: true,
                        preConfirm: () => {
                            return axios.delete('/central-goods/' + id)
                                .then(function(response) {
                                    console.log(response.data);
                                })
                                .catch(function(error) {
                                    console.log(error.data);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops',
                                        text: 'Something wrong',
                                    })
                                });
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Outlet Berhasil Dihapus',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            })
                        }
                    })
                },


            }
        })
    </script>
    @endsection