@extends('layouts.app')

@section('title', 'Dashboard | Manage Room')

@section('prehead')
<link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@inject('carbon', 'Carbon\Carbon')
@inject('carbonInterval', 'Carbon\CarbonInterval')

@section('content')
<div id="app" v-cloak>

    <div class="modal fade" tabindex="-1" id="kt_modal_1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form @submit.prevent="submitForm" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Room</h5>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <span class="svg-icon svg-icon-2x"></span>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">

                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-sm-3">
                                <label for="" class="form-label form-label-sm">Device</label>
                            </div>

                            <div class="col-sm-9">
                                <span class="fw-bolder text-dark">: &nbsp; @{{ roomDetail?.device?.name }}</span>
                            </div>
                        </div>

                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-sm-3">
                                <label for="" class="form-label form-label-sm">Email</label>
                            </div>

                            <div class="col-sm-9">
                                <span class="fw-bolder text-dark">: &nbsp; @{{ roomDetail?.user?.email }}</span>
                            </div>
                        </div>

                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-sm-3">
                                <label for="" class="form-label form-label-sm">Floor</label>
                            </div>

                            <div class="col-sm-9">
                                <span class="fw-bolder text-dark">: &nbsp; @{{ roomDetail?.floor }}</span>
                            </div>
                        </div>

                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-sm-3">
                                <label for="" class="form-label form-label-sm">IP Address</label>
                            </div>

                            <div class="col-sm-9">
                                <span class="fw-bolder text-dark">: &nbsp; @{{ roomDetail?.ip_address }}</span>
                            </div>
                        </div>

                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-sm-3">
                                <label for="" class="form-label form-label-sm">Projector</label>
                            </div>

                            <div class="col-sm-9">
                                <span class="fw-bolder text-dark" v-if="roomDetail?.projector == 1">: &nbsp;
                                    Tersedia</span>
                                <span class="fw-bolder text-dark" v-if="roomDetail?.projector == 2">: &nbsp; Tidak
                                    Tersedia</span>
                            </div>
                        </div>

                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-sm-3">
                                <label for="" class="form-label form-label-sm">Internet</label>
                            </div>

                            <div class="col-sm-9">
                                <span class="fw-bolder text-dark" v-if="roomDetail?.internet == 1">: &nbsp; Tersedia
                                    &nbsp; </span>
                                <span class="fw-bolder text-dark" v-if="roomDetail?.internet == 2">: &nbsp; Tidak
                                    Tersedia</span>


                            </div>
                        </div>

                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-sm-3">
                                <label for="" class="form-label form-label-sm">PIN</label>
                            </div>

                            <div class="col-sm-9">
                                <span class="fw-bolder text-dark">: &nbsp; @{{ roomDetail?.user?.pin }}</span>
                            </div>
                        </div>

                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-sm-3">
                                <label for="" class="form-label form-label-sm">Color Room</label>
                            </div>

                            <div class="col-sm-9">
                                <span class="fw-bolder text-dark">: &nbsp; @{{ roomDetail?.color_code }} &nbsp; <span class="badge" :style="{ 'background-color': roomDetail?.color_code }">-</span></span>
                            </div>
                        </div>

                        <!-- <div class="row g-3 align-items-center mb-4">
                            <div class="col-sm-3">
                                <label for="" class="form-label form-label-sm">IP Address</label>
                            </div>

                            <div class="col-sm-9">
                                <span class="fw-bolder text-dark">: &nbsp; @{{ roomDetail.ip_address }}</span>
                            </div>
                        </div> -->
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="kt_modal_edit">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form @submit.prevent="submitFormEdit" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Room</h5>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <span class="svg-icon svg-icon-2x"></span>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">


                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-sm-3">
                                <label for="" class="form-label form-label-sm">Room Name </label>
                            </div>

                            <div class="col-sm-9">
                                <input type="text" v-model="roomDetail.name" class="form-control mb-2" placeholder="Nama Ruangan" />

                            </div>
                        </div>



                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-sm-3">
                                <label for="" class="form-label form-label-sm">Capacity </label>
                            </div>

                            <div class="col-sm-9">
                                <input type="text" v-model="roomDetail.capacity" class="form-control mb-2" placeholder="Nama Ruangan" />

                            </div>
                        </div>

                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-sm-3">
                                <label for="" class="form-label form-label-sm">IP Address </label>
                            </div>

                            <div class="col-sm-9">
                                <input type="text" v-model="roomDetail.ip_address" class="form-control mb-2" placeholder="Nama Ruangan" />

                            </div>
                        </div>

                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-sm-3">
                                <label for="" class="form-label form-label-sm">Floor </label>
                            </div>

                            <div class="col-sm-9">
                                <input type="text" v-model="roomDetail.floor" class="form-control mb-2" placeholder="Nama Ruangan" />

                            </div>
                        </div>

                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-sm-3">
                                <label for="" class="form-label form-label-sm">Projector </label>
                            </div>

                            <div class="col-sm-9">
                                <input type="text" v-model="roomDetail.projector" class="form-control mb-2" placeholder="Nama Ruangan" />

                            </div>
                        </div>

                        <div class="row g-3 align-items-center mb-4">
                            <div class="col-sm-3">
                                <label for="" class="form-label form-label-sm">Color Room </label>
                            </div>

                            <div class="col-sm-9">
                                <input type="color" v-model="roomDetail.color_code" class="form-control mb-2" />

                            </div>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="container-xxl" id="kt_content_container">
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                            </span>
                            <input type="text" data-kt-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Cari" />
                        </div>
                        <!--end::Search-->
                    </div>

                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

                        <a href="/admin/manage-room/create" class="btn btn-primary">Create Ruang</a>
                        <!--end::Add product-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle border rounded table-row-dashed fs-6 g-5" id="kt_datatable_example_1">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="text-center min-w-20px">No</th>
                                <th class="text-center min-w-100px">Room</th>
                                <th class="text-center min-w-100px">Capacity</th>
                                <th class="text-center min-w-100px">Status</th>
                                <th class="text-center min-w-70px">Actions</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <tbody class="fw-bold text-gray-600">
                            <!--begin::Table row-->
                            <tr v-for="(rooms, index) in room">


                                <td class="text-center pe-0">
                                    <span class="fw-bolder text-dark">@{{ index + 1 }}</span>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">

                                        <div class="ms-5">
                                            <!--begin::Title-->
                                            <a href="#" @click="onSelcected(rooms.id)" data-bs-toggle="modal" data-bs-target="#kt_modal_1" class="text-gray-800 text-hover-primary fs-5 fw-bolder" data-kt-ecommerce-product-filter="product_name">@{{ rooms.name }}</a>
                                            <!--end::Title-->
                                        </div>
                                    </div>
                                </td>


                                <td class="text-center pe-0">
                                    <span class="fw-bolder text-dark">@{{ rooms.capacity }}</span>
                                </td>

                                <!--begin::Status=-->
                                <td class="text-center pe-0" data-order="Scheduled">
                                    <!--begin::Badges-->
                                    <div class="badge badge-light-primary" v-if="rooms.status == 1">Active</div>
                                    <div class="badge badge-light-primary" v-if="rooms.status == 2">Non Active</div>
                                    <!--end::Badges-->
                                </td>
                                <!--end::Status=-->
                                <!--begin::Action=-->
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-secondary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" @click="onSelcected(rooms.id)" data-bs-toggle="modal" data-bs-target="#kt_modal_edit" class="menu-link px-3">Edit</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" @click.prevent="deleteRecord(rooms.id)">Delete</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </td>
                                <!--end::Action=-->
                            </tr>

                            <!--end::Table row-->
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
        </div>
    </div>

</div>
@endsection
@section('script')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endsection

@section('pagescript')

<script>
    "use strict";

    // Class definition
    var KTDatatablesButtons = function() {
        // Shared variables
        var table;
        var datatable;

        // Private functions
        var initDatatable = function() {
            // Set date data order
            const tableRows = table.querySelectorAll('tbody tr');

            tableRows.forEach(row => {
                const dateRow = row.querySelectorAll('td');
                const realDate = moment(dateRow[3].innerHTML, "DD MMM YYYY, LT").format(); // select date from 4th column in table
                dateRow[3].setAttribute('data-order', realDate);
            });

            // Init datatable --- more info on datatables: https://datatables.net/manual/
            datatable = $(table).DataTable({
                "info": false,
                'order': [],
                'pageLength': 10,
            });
        }

        // Hook export buttons
        var exportButtons = () => {
            const documentTitle = 'Data Lowongan Kerja';
            var buttons = new $.fn.dataTable.Buttons(table, {
                buttons: [{
                        extend: 'copyHtml5',
                        title: documentTitle
                    },
                    {
                        extend: 'excelHtml5',
                        title: documentTitle
                    },
                    {
                        extend: 'csvHtml5',
                        title: documentTitle
                    },
                    {
                        extend: 'pdfHtml5',
                        title: documentTitle
                    }
                ]
            }).container().appendTo($('#kt_datatable_example_1_export'));

            // Hook dropdown menu click event to datatable export buttons
            const exportButtons = document.querySelectorAll('#kt_datatable_example_1_export_menu [data-kt-export]');
            exportButtons.forEach(exportButton => {
                exportButton.addEventListener('click', e => {
                    e.preventDefault();

                    // Get clicked export value
                    const exportValue = e.target.getAttribute('data-kt-export');
                    const target = document.querySelector('.dt-buttons .buttons-' + exportValue);

                    // Trigger click event on hidden datatable export buttons
                    target.click();
                });
            });
        }

        var handleSearchDatatable = () => {
            const filterSearch = document.querySelector('[data-kt-filter="search"]');
            filterSearch.addEventListener('keyup', function(e) {
                datatable.search(e.target.value).draw();
            });
        }

        // Public methods
        return {
            init: function() {
                table = document.querySelector('#kt_datatable_example_1');

                if (!table) {
                    return;
                }

                initDatatable();
                exportButtons();
                handleSearchDatatable();
            }
        };
    }();

    // On document ready
    KTUtil.onDOMContentLoaded(function() {
        KTDatatablesButtons.init();
    });
</script>


<script>
    const room = <?php echo Illuminate\Support\Js::from($room) ?>;
    let app = new Vue({
        el: '#app',
        data: {
            room,
            roomDetail: [],

            loading: false,
        },
        methods: {
            onSelcected: function(id) {
                this.roomDetail = this.room.filter((item) => {
                    return item.id == id;
                })[0]

            },
            submitFormEdit: function() {
                this.sendData();
            },
            sendData: function() {
                let vm = this;
                vm.loading = true;
                axios.post('/admin/manage-room/' + this.roomDetail['id'] + '/edit', {
                        name: this.roomDetail['name'],
                        email: this.roomDetail['email'],
                        base_id: this.roomDetail['base_id'],
                        calendar_id: this.roomDetail['calendar_id'],
                        projector: this.roomDetail['projector'],
                        floor: this.roomDetail['floor'],
                        capacity: this.roomDetail['capacity'],
                        color_code: this.roomDetail['color_code'],
                        ip_address: this.roomDetail['ip_address'],
                        device_id: this.roomDetail['device_id'],
                    })
                    .then(function(response) {
                        vm.loading = false;
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Ruangan berhasil diupdate.',
                            icon: 'success',
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '/admin/manage-room';
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
                        return axios.delete('/admin/manage-room/' + id)
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
                            text: 'Room Berhasil Dihapus',
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