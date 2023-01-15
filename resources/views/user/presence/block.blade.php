<html>

<head>
    <title>Absen Hadir </title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700'>


    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="{{ asset('gambar/logo-vbook.png') }}">
</head>


<body id="kt_body" class="bg-body">
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <!--begin::Logo-->
                <div class="mb-12">
                    <img alt="Logo" src="{{ asset('gambar/logo-vbook.png') }}" class="h-40px" />
                </div>
                <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <!--begin::Form-->

                    <!--begin::Heading-->
                    <div class="mb-10">
                        <!--begin::Title-->
                        <div class="text-center mb-4">
                            <img alt="Logo" src="{{ asset('gambar/batal.png') }}" class="h-65px" />
                        </div>
                        <div class="alert alert-danger mb-4 text-center">
                            <h5 class="text-dark mb-4">Mohom maaf <br> Anda tidak bisa Konfirmasi kehadiran melalui email jika meeting sedang berjalan atau selesai </h5>
                        </div>


                    </div>

                    <div class="text-center">
                        <a href="/user"> <button class="btn btn-primary">Kembali Ke halaman awal</button></a>
                    </div>


                    <!--end::Actions-->

                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <script>
        var hostUrl = "assets/";
    </script>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/authentication/sign-in/general.js') }}"></script>
</body>

</html>
