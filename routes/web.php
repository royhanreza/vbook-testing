<?php

use App\Events\HelloEvent;
use App\Http\Controllers\admin\ManageRoomController;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ManageUserController;
use App\Http\Controllers\admin\ReportBookingController;
use App\Http\Controllers\admin\SettingWebController;
use App\Http\Controllers\admin\DivisionController;
use App\Http\Controllers\guest\AuthGuestController;
use App\Http\Controllers\guest\CreateBookingGuestController;
use App\Http\Controllers\guest\GuestController;
use App\Http\Controllers\guest\SearchBookingGuestController;
use App\Http\Controllers\receptionist\AuthReceptionistController;
use App\Http\Controllers\receptionist\ManageGuestController;
use App\Http\Controllers\admin\ManageReceptionistController;
use App\Http\Controllers\receptionist\ReceptionistController;
use App\Http\Controllers\room\AuthRoomController;
use App\Http\Controllers\room\RoomDashboardController;
use App\Http\Controllers\room\ScanQrcodeController;
use App\Http\Controllers\superadmin\AuthSuperadminController;
use App\Http\Controllers\superadmin\DashboardSuperadminController;
use App\Http\Controllers\superadmin\LicenceController;
use App\Http\Controllers\superadmin\DeviceController;
use App\Http\Controllers\user\AuthGoogleController;
use App\Http\Controllers\user\BookingRoomController;
use App\Http\Controllers\user\DisplayAttendedController;
use App\Http\Controllers\user\ParticipantAttendedController;
use App\Http\Controllers\user\ParticipantConfirmController;
use App\Http\Controllers\user\SearchRoomUserController;
use App\Http\Controllers\user\UserDashboardController;
use App\Http\Controllers\superadmin\ManageCompanyController;
use App\Http\Controllers\superadmin\SettingSuperadminController;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/send-event', function () {
    broadcast(new HelloEvent());
});


Route::controller(AuthController::class)->prefix('/admin')->group(function () {
    Route::get('/login', 'loginAdmin')->name('admin.login');
    Route::post('/login', 'authenticate')->name('admin.authenticate');
    Route::get('/logout', 'logout')->name('admin.logout');
});

Route::controller(AuthSuperadminController::class)->prefix('/suadmin')->group(function () {
    Route::get('/login', 'loginAdmin')->name('suadmin.login');
    Route::post('/login', 'authenticate')->name('suadmin.authenticate');
    Route::get('/logout', 'logout')->name('suadmin.logout');
});

Route::controller(AuthGoogleController::class)->prefix('/')->group(function () {
    Route::get('/login', 'index')->name('user.login');
    Route::get('auth/google', 'redirectToGoogle')->name('user-google.login');
    Route::get('auth/google/callback', 'handleGoogleCallback')->name('user-google.callback');
});

Route::controller(AuthReceptionistController::class)->prefix('/receptionist')->group(function () {
    Route::get('/login', 'login')->name('receptionist.login');
    Route::get('/logout', 'logout')->name('receptionist.logout');
    Route::post('/login', 'authenticate')->name('receptionist.authenticate');
});

Route::controller(AuthGuestController::class)->prefix('/guest-booking')->group(function () {
    Route::get('/login', 'login')->name('guest-booking.login');
    Route::get('/logout', 'logout')->name('guest-booking.logout');
    Route::post('/login', 'authenticate')->name('guest-booking.authenticate');
});


Route::controller(AuthRoomController::class)->prefix('/room')->group(function () {
    Route::get('/login', 'index')->name('room.login');
    Route::post('/login', 'authenticate_room')->name('room.authenticate');
    Route::get('/logout', 'logout')->name('room.logout');
});

Route::controller(ParticipantConfirmController::class)->prefix('/confirmation')->group(function () {
    Route::get('/present', 'present')->name('user.email-present');
    Route::get('/not-present', 'not_present')->name('user.email-not-present');
});

Route::controller(ParticipantAttendedController::class)->prefix('/participants-attended')->group(function () {
    Route::get('/{id}/presence', 'index')->name('user.present');
    Route::post('/presence', 'attendanceQrCode')->name('user.present-post');
});

Route::controller(DisplayAttendedController::class)->prefix('/participants-attended')->group(function () {
    Route::get('/{id}/display-presence', 'index')->name('display.present');
    Route::post('/display-presence', 'attendanceQrCode')->name('display.present-post');
});




// ====================================== ROUTE HALAMAN SUPERADMIN ======================================

Route::group(['middleware' => 'suadmin'], function () {
    Route::controller(DashboardSuperadminController::class)->prefix('/suadmin')->group(function () {
        Route::get('/', 'index')->name('suadmin.dashboard');
    });

    Route::controller(ManageCompanyController::class)->prefix('/suadmin/manage-company')->group(function () {
        Route::get('/', 'index')->name('manage-company.index');
        Route::get('/create', 'create')->name('manage-company.create');
        Route::get('/{id}/detail', 'detail')->name('manage-company.detail');
        Route::post('/{id}/edit', 'update')->name('manage-company.edit');
        Route::post('/', 'store')->name('manage-company.strore');
        Route::delete('/{id}', 'destroy')->name('manage-company.destroy');
    });


    Route::controller(SettingSuperadminController::class)->prefix('/suadmin/setting')->group(function () {
        Route::get('/', 'index')->name('superadmin-setting.index');
    });

    Route::controller(LicenceController::class)->prefix('/suadmin/licence')->group(function () {
        Route::get('/', 'index')->name('superadmin-licence.index');
    });

    Route::controller(DeviceController::class)->prefix('/suadmin/device')->group(function () {
        Route::get('/', 'index')->name('device-admin.index');
        Route::get('/create', 'create')->name('device-admin.create');
        Route::post('/', 'store')->name('device-admin.post');
        Route::delete('/{id}', 'destroy')->name('device-admin.destroy');
    });
});
// ====================================== SELESAI ROUTE HALAMAN SUPERADMIN ================================


// ====================================== ROUTE HALAMAN ADMIN ======================================

Route::group(['middleware' => 'admin'], function () {
    Route::controller(DashboardController::class)->prefix('/admin')->group(function () {
        Route::get('/', 'index')->name('admin.dashboard');
    });

    Route::controller(ManageRoomController::class)->prefix('/admin/manage-room')->group(function () {
        Route::get('/', 'index')->name('manage-room.index');
        Route::get('/create', 'create')->name('manage-room.create');
        Route::get('/{id}/detail', 'detail')->name('manage-room.detail');
        Route::post('/{id}/edit', 'update')->name('manage-room.edit');
        Route::post('/', 'store')->name('manage-room.strore');
        Route::delete('/{id}', 'destroy')->name('manage-room.destroy');
    });

    Route::controller(ManageUserController::class)->prefix('/admin/manage-user')->group(function () {
        Route::get('/', 'index')->name('manage-user.index');
        Route::get('/create', 'create')->name('manage-user.create');
        Route::get('/{id}/detail', 'detail')->name('manage-user.detail');
        Route::post('/{id}/edit', 'update')->name('manage-user.edit');
        Route::post('/', 'store')->name('manage-user.strore');
        Route::delete('/{id}', 'destroy')->name('manage-user.destroy');
    });

    Route::controller(SettingWebController::class)->prefix('/admin/setting')->group(function () {
        Route::get('/', 'index')->name('seeting-admin.index');
    });

    Route::controller(ReportBookingController::class)->prefix('/admin/report')->group(function () {
        Route::get('/', 'index')->name('report-booking.index');
        Route::get('/excel', 'export_excel')->name('report-booking.excel');
        Route::post('/{id}/edit', 'update')->name('report-booking.edit');
    });

    Route::controller(DivisionController::class)->prefix('/admin/manage-division')->group(function () {
        Route::get('/', 'index')->name('manage-division.index');
        Route::post('/', 'store')->name('manage-division.post');
        Route::post('/{id}/edit', 'update')->name('manage-division.edit');
    });

    Route::controller(ManageReceptionistController::class)->prefix('/admin/manage-receptionist')->group(function () {
        Route::get('/', 'index')->name('manage-receptionist.index');
        Route::get('/create', 'create')->name('manage-receptionist.create');
        Route::post('/', 'store')->name('manage-receptionist.post');
        Route::post('/{id}/edit', 'update')->name('manage-receptionist.edit');
    });
});
// ====================================== SELESAI ROUTE HALAMAN ADMIN ================================





// ====================================== ROUTE HALAMAN ROOM ======================================

Route::group(['middleware' => 'room', 'cors'], function () {
    Route::controller(RoomDashboardController::class)->prefix('/room')->group(function () {
        Route::get('/', 'index')->name('room.dashboard');
        Route::post('/post-reload', 'reload')->name('room.reload');
    });

    Route::controller(ScanQrcodeController::class)->prefix('/scan')->group(function () {
        Route::get('/', 'index')->name('room.scan-qrcode');
    });

    Route::controller(RoomDashboardController::class)->prefix('/api-display')->group(function () {
        Route::get('/', 'apiDisplay')->name('room.api-display');
    });
});
// ====================================== SELESAI ROUTE HALAMAN ROOM ================================





// ====================================== ROUTE HALAMAN USER ======================================

Route::group(['middleware' => 'user'], function () {
    Route::controller(UserDashboardController::class)->prefix('/')->group(function () {
        Route::get('/', 'index')->name('user.index');
        Route::get('/user', 'index')->name('user.dashboard');
        Route::get('/user/profile', 'profile')->name('user.profile');
        Route::get('/user/logout', 'logout')->name('user.logout');
        Route::post('/user/guest', 'guestAccess')->name('user.logout');
    });

    // // Route::controller(BookingRoomController::class)->prefix('/user/booking')->group(function () {
    // //     Route::get('/', 'index')->name('user-booking.dashboard');
    // //     Route::get('/{id}/create', 'create')->name('user-booking.create');
    // //     Route::post('/', 'store')->name('user-booking.post');
    // // });

    // // Route::controller(SearchRoomUserController::class)->prefix('/user/booking')->group(function () {
    // //     Route::get('/search', 'index')->name('user-search-booking.dashboard');
    // // });
});
// ====================================== SELESAI ROUTE HALAMAN USER ================================

// ====================================== ROUTE HALAMAN BOOKING ======================================

Route::group(['middleware' => 'multi'], function () {

    Route::controller(UserDashboardController::class)->prefix('/booking')->group(function () {
        Route::get('/', 'index')->name('booking.dashboard');
        Route::get('/logout', 'logout')->name('booking.logout');
    });

    Route::controller(SearchRoomUserController::class)->prefix('/booking')->group(function () {
        Route::get('/search', 'index')->name('booking-searvh.dashboard');
    });

    Route::controller(BookingRoomController::class)->prefix('/booking')->group(function () {
        Route::get('/{id}/create', 'create')->name('booking.create');
        Route::post('/', 'store')->name('bokking.post');
    });
});
// ====================================== SELESAI ROUTE HALAMAN BOOKING ================================




// ====================================== ROUTE HALAMAN RECEPTIONIST ======================================

Route::group(['middleware' => 'receptionist'], function () {

    Route::controller(ReceptionistController::class)->prefix('/receptionist')->group(function () {
        Route::get('/', 'index')->name('receptionist.dashboard');
    });

    Route::controller(ManageGuestController::class)->prefix('/receptionist/manage-guest')->group(function () {
        Route::get('/', 'index')->name('manage-guest.index');
        Route::get('/create', 'create')->name('manage-guest.create');
        Route::post('/', 'store')->name('manage-guest.strore');
        Route::delete('/{id}', 'destroy')->name('manage-guest.destroy');
        Route::post('/{id}', 'restore')->name('manage-guest.restore');
        Route::post('/{id}/aktif', 'aktif')->name('manage-guest.aktif');
    });
});
// ====================================== SELESAI ROUTE HALAMAN RECEPTIONIST ================================



// ====================================== ROUTE HALAMAN GUEST ======================================

Route::group(['middleware' => 'guest-booking'], function () {

    Route::controller(GuestController::class)->prefix('/guest-booking')->group(function () {
        Route::get('/', 'index')->name('guest.dashboard');
    });

    Route::controller(SearchBookingGuestController::class)->prefix('/guest-booking/search')->group(function () {
        Route::get('/', 'index')->name('guest.search');
    });

    Route::controller(CreateBookingGuestController::class)->prefix('/guest-booking/create')->group(function () {
        Route::get('/{id}', 'create')->name('guest.create');
        Route::post('/', 'store')->name('guest.post');
    });
});
// ====================================== SELESAI ROUTE HALAMAN GUEST ================================
