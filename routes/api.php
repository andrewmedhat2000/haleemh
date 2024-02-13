<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
});
*/
Route::middleware('auth:api')->post('auth/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
Route::middleware('auth:api')->post('auth/deactivate_account', [App\Http\Controllers\API\AuthController::class, 'deactivate_account']);
Route::post('auth/register', [App\Http\Controllers\API\AuthController::class, 'register']);
Route::get('getcontries', [App\Http\Controllers\API\CountryController::class, 'getcontries']);
Route::post('auth/login', [App\Http\Controllers\API\AuthController::class, 'login']);
Route::post('auth/reset', [App\Http\Controllers\API\AuthController::class, 'reset']);
Route::post('auth/verifyCode', [App\Http\Controllers\API\AuthController::class, 'verifyCode']);
Route::post('auth/resendVerificationCode', [App\Http\Controllers\API\AuthController::class, 'resendVerificationCode']);
Route::post('auth/forgotPassword', [App\Http\Controllers\API\AuthController::class, 'forgotPassword']);
Route::post('auth/reset', [App\Http\Controllers\API\AuthController::class, 'reset']);



Route::middleware('auth:api')->post('profile/update_profile', [App\Http\Controllers\API\SetterController::class, 'update_profile']);
Route::middleware('auth:api')->post('profile/update_phone', [App\Http\Controllers\API\SetterController::class, 'update_phone']);
Route::middleware('auth:api')->post('profile/profileDetails', [App\Http\Controllers\API\SetterController::class, 'profileDetails']);
Route::middleware('auth:api')->post('career/career_details', [App\Http\Controllers\API\SetterController::class, 'career_details']);
Route::middleware('auth:api')->post('career/update_career', [App\Http\Controllers\API\SetterController::class, 'update_career']);
Route::middleware('auth:api')->post('career/setter_certificates',  [App\Http\Controllers\API\SetterController::class, 'getCertificates']);
Route::middleware(['auth:api', 'validate.image'])->post('career/add_certificate',  [App\Http\Controllers\API\SetterController::class, 'addCertificate']);
Route::middleware('auth:api')->delete('career/delete_certificate/{id}',  [App\Http\Controllers\API\SetterController::class, 'deleteCertificate']);
Route::middleware(['auth:api', 'validate.image'])->post('career/edit_certificate',  [App\Http\Controllers\API\SetterController::class, 'editCertificate']);
Route::middleware('auth:api')->get('facility/facility_details',  [App\Http\Controllers\API\SetterController::class, 'facility_details']);
Route::middleware(['auth:api', 'validate.image'])->post('facility/update_facility', [App\Http\Controllers\API\SetterController::class, 'update_facility']);
Route::middleware(['auth:api'])->post('facility/add_facility', [App\Http\Controllers\API\SetterController::class, 'add_facility']);
Route::middleware(['auth:api'])->post('facility/add_room_image',  [App\Http\Controllers\API\SetterController::class, 'add_room_image']);
Route::middleware(['auth:api'])->post('facility/add_facility_room',  [App\Http\Controllers\API\SetterController::class, 'add_facility_room']);
Route::middleware(['auth:api'])->get('facility/get_all_rooms',  [App\Http\Controllers\API\SetterController::class, 'get_all_rooms']);
Route::middleware(['auth:api'])->get('facility/get_all_facilities',  [App\Http\Controllers\API\SetterController::class, 'get_all_facilities']);
Route::middleware('auth:api')->post('facility/delete_room_image', [App\Http\Controllers\API\SetterController::class, 'delete_room_image']);
Route::middleware('auth:api')->post('facility/get_room_images', [App\Http\Controllers\API\SetterController::class, 'get_room_images']);
Route::middleware('auth:api')->post('facility/edit_room', [App\Http\Controllers\API\SetterController::class, 'edit_room']);
Route::middleware('auth:api')->post('facility/add_room', [App\Http\Controllers\API\SetterController::class, 'add_room']);
Route::middleware('auth:api')->post('facility/delete_room', [App\Http\Controllers\API\SetterController::class, 'delete_room']);
Route::middleware('auth:api')->get('auth/deactivateAccount/{id}',  [App\Http\Controllers\API\SetterController::class, 'deactivateAccount']);
Route::middleware('auth:api')->delete('auth/deleteAccount',  [App\Http\Controllers\API\SetterController::class, 'deleteAccount']);
Route::middleware('auth:api')->get('profile/reviews_details/{id}',  [App\Http\Controllers\API\SetterController::class, 'reviews_details']);




Route::middleware('auth:api')->post('order/order_details',  [App\Http\Controllers\API\OrderController::class, 'order_details']);
Route::middleware('auth:api')->post('order/get_orders',  [App\Http\Controllers\API\OrderController::class, 'get_orders']);
Route::middleware('auth:api')->post('order/set_order_status',  [App\Http\Controllers\API\OrderController::class, 'set_order_status']);
Route::middleware('auth:api')->get('order/orders',  [App\Http\Controllers\API\OrderController::class, 'orders']);
Route::middleware('auth:api')->post('order/updateReceiveOrder',[App\Http\Controllers\API\OrderController::class, 'updateReceiveOrder']);




Route::middleware('auth:api')->get('settings',  [App\Http\Controllers\API\SettingsController::class, 'index']);
Route::middleware('auth:api')->post('settings/store',  [App\Http\Controllers\API\SettingsController::class, 'store']);
Route::middleware('auth:api')->post('settings/update/{id}',  [App\Http\Controllers\API\SettingsController::class, 'update']);
Route::middleware('auth:api')->delete('settings/delete/{id}',  [App\Http\Controllers\API\SettingsController::class, 'destroy']);




Route::middleware('auth:api')->get('chat/get_my_conversations', [App\Http\Controllers\API\ChatController::class, 'conversations']);
Route::middleware('auth:api')->post('chat/delete',[App\Http\Controllers\API\ChatController::class, 'destroy']);
Route::middleware('auth:api')->get('chat/conversation_messeges',[App\Http\Controllers\API\ChatController::class, 'messages']);
Route::middleware('auth:api')->post('chat/send_message',[App\Http\Controllers\API\ChatController::class, 'send']);



Route::middleware('auth:api')->post('wallet/transactions',[App\Http\Controllers\API\WalletController::class, 'transactions']);
Route::middleware('auth:api')->post('wallet/latest_transactions',[App\Http\Controllers\API\WalletController::class, 'latestTransactions']);
Route::middleware('auth:api')->post('wallet/total_amount',[App\Http\Controllers\API\WalletController::class, 'calculateTotalAmount']);







////////////////////////////Parent//////////////////////////////////////////////////////////////
Route::post('auth_parent/register', [App\Http\Controllers\API\ParentAuthController::class, 'register']);
Route::post('auth_parent/login', [App\Http\Controllers\API\ParentAuthController::class, 'login']);
Route::post('auth_parent/verifyCode', [App\Http\Controllers\API\ParentAuthController::class, 'verifyCode']);
Route::post('auth_parent/resendVerificationCode', [App\Http\Controllers\API\ParentAuthController::class, 'resendVerificationCode']);

Route::middleware('auth:api')->post('parent_profile/update_profile', [App\Http\Controllers\API\ParentController::class, 'update_profile']);
Route::middleware('auth:api')->post('parent_profile/update_phone', [App\Http\Controllers\API\ParentController::class, 'update_phone']);

Route::middleware('auth:api')->get('children/my_childrens',  [App\Http\Controllers\API\ParentController::class, 'getChildrens']);
Route::middleware('auth:api')->post('children/add_children',  [App\Http\Controllers\API\ParentController::class, 'addChildren']);
Route::middleware('auth:api')->post('children/edit_children',  [App\Http\Controllers\API\ParentController::class, 'editChildren']);
Route::middleware('auth:api')->delete('children/delete_children/{id}',  [App\Http\Controllers\API\ParentController::class, 'deleteChildren']);

Route::middleware('auth:api')->get('driver/my_drivers',  [App\Http\Controllers\API\ParentController::class, 'getdrivers']);

Route::middleware('auth:api')->post('driver/add_driver',  [App\Http\Controllers\API\ParentController::class, 'adddriver']);
Route::middleware('auth:api')->post('driver/edit_driver',  [App\Http\Controllers\API\ParentController::class, 'editdriver']);
Route::middleware('auth:api')->delete('driver/delete_driver/{id}',  [App\Http\Controllers\API\ParentController::class, 'deletedriver']);

Route::middleware('auth:api')->get('parent/setter_details/{id}',  [App\Http\Controllers\API\ParentController::class, 'setter_details']);
Route::middleware('auth:api')->post('add_rate',  [App\Http\Controllers\API\ParentController::class, 'add_rate']);



Route::middleware('auth:api')->get('reviews_details/{id}',  [App\Http\Controllers\API\ParentController::class, 'reviews_details']);



Route::middleware('auth:api')->post('parent/make_favourite',  [App\Http\Controllers\API\ParentController::class, 'make_favourite']);
Route::middleware('auth:api')->post('parent/get_my_favourites',  [App\Http\Controllers\API\ParentController::class, 'get_my_favourites']);
Route::middleware('auth:api')->post('parent/delete_favourite',  [App\Http\Controllers\API\ParentController::class, 'delete_favourite']);
Route::middleware('auth:api')->get('parent/get_setters',  [App\Http\Controllers\API\ParentController::class, 'get_setters']);
Route::middleware('auth:api')->post('parent/make_order',  [App\Http\Controllers\API\OrderController::class, 'make_order']);
Route::middleware('auth:api')->get('parent/my_orders_setters',  [App\Http\Controllers\API\OrderController::class, 'my_orders_setters']);
Route::middleware('auth:api')->post('parent/make_report',  [App\Http\Controllers\API\ReportController::class, 'make_report']);
