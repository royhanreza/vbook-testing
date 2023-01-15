@extends('layouts.app')

@section('title', 'Create Company')

@section('prehead')
<link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@inject('carbon', 'Carbon\Carbon')
@inject('carbonInterval', 'Carbon\CarbonInterval')

@section('content')
<div id="app" v-cloak>


    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div class="container-xxl" id="kt_content_container">
            <!--begin::Form-->

            <form @submit.prevent="submitForm" enctype="multipart/form-data" id="kt_ecommerce_add_product_form" class="form d-flex flex-column flex-lg-row" data-kt-redirect="../../demo4/dist/apps/ecommerce/catalog/products.html">

                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <!--begin:::Tabs-->

                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <!--begin::Inventory-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Add New Company</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Name</label>
                                    <input type="text" v-model="name" class="form-control mb-2" placeholder="Nama" />
                                </div>

                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Aplication Name</label>
                                    <input type="text" v-model="aplicationName" class="form-control mb-2" placeholder="Email" value="" />
                                </div>

                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Email</label>
                                    <input type="text" v-model="email" class="form-control mb-2" placeholder="Email" value="" />
                                </div>



                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Password</label>
                                    <input type="password" v-model="password" class="form-control mb-2" placeholder="Password" value="" />
                                </div>

                                <div class="mb-10 fv-row">
                                    <label class="required form-label">No Handphone</label>
                                    <input type="text" v-model="noHp" class="form-control mb-2" placeholder="No Telepon" value="" />
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="alert alert-warning">
                                            <div class="d-flex flex-column">
                                                <h4 class="mb-1 text-dark">Logo </h4><small>File harus berupa jpeg / png / jpg </small>
                                                <br>
                                                <input type="file" ref="logo" class="custom-file-input" accept=".jpeg, .png, .jpg" v-on:change="handleLogoUpload">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--
                                <div class="mb-10 fv-row">
                                    <label class="required form-label">Select Role</label>
                                    <select class="form-select mb-2" v-model="roleId">
                                        <option value="0">- SELECT ROLE -</option>
                                        <option value="3">USER</option>
                                    </select>
                                </div> -->

                            </div>
                        </div>


                    </div>

                    <!--end::Tab pane-->

                    <!--end::Tab content-->
                    <div class="d-flex justify-content-end">
                        <!--begin::Button-->
                        <a href="/suadmin/manage-company" id="kt_ecommerce_add_product_cancel" class="btn btn-secondary me-5">Cancel</a>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
                            <span class="indicator-label">Save</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!--end::Button-->
                    </div>
                </div>
                <!--end::Main column-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Content-->


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
            name: '',
            logo: '',
            aplicationName: '',
            email: '',
            password: '',
            noHp: '',
            loading: false,
        },
        methods: {
            handleLogoUpload: function() {
                this.logo = this.$refs.logo.files[0];

            },
            submitForm: function() {
                this.sendData();
            },
            sendData: function() {
                let vm = this;
                //vm.loading = true;
                let data = {
                    logo: vm.logo,
                    name: this.name,
                    aplication_name: this.aplicationName,
                    email: this.email,
                    password: this.password,
                    no_telp: this.noHp,
                    logo_name: this.logo['name'],
                }
                let formData = new FormData();
                for (var key in data) {
                    formData.append(key, data[key]);
                }
                axios.post('/suadmin/manage-company', formData)
                    .then(function(response) {
                        vm.loading = false;
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Company berhasil disimpan.',
                            icon: 'success',
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '/suadmin/manage-company';
                            }
                        })
                        // console.log(response);
                    })
                    .catch(function(error) {
                        vm.loading = false;
                        console.log(error);
                        Swal.fire(
                            'Terjadi Kesalahan!',
                            'Pastikan data terisi dengan benar.',
                            'error'
                        )
                    });
            },

        }
    })
</script>
@endsection