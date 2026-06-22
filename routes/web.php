<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceDeskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BudgetPlannerController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CustomPackageController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\BlogController;
// Service Desk Public Route
Route::post('/service-desk/request', [ServiceDeskController::class, 'store'])
    ->middleware('throttle:form')
    ->name('service-desk.store');
// Admin Service Desk Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/service-desk', [ServiceDeskController::class, 'index'])->name('service-desk.index');
    Route::get('/service-desk/{request}', [ServiceDeskController::class, 'show'])->name('service-desk.show');
    Route::post('/service-desk/{request}/assign', [ServiceDeskController::class, 'assign'])->name('service-desk.assign');
    Route::patch('/service-desk/{request}/status', [ServiceDeskController::class, 'updateStatus'])->name('service-desk.status');
});



Route::get('/blueprint', [\App\Http\Controllers\BlueprintController::class, 'index'])->name('blueprint');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search-suggestions', [HomeController::class, 'searchSuggestions'])->name('search.suggestions');
Route::get('/home', [HomeController::class, 'index']); // Keep /home as legacy if needed

// Public Vendor Profiles
Route::get('/vendors/{vendor:id}', [\App\Http\Controllers\PublicVendorController::class, 'show'])->name('vendors.show');

// Public Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/desks/{slug}', [PageController::class, 'desk'])->name('desk.show');
Route::get('/services/{service}/check-availability', [BookingController::class, 'checkAvailability'])->name('services.check-availability');
Route::get('/services/{service}/unavailable-dates', [BookingController::class, 'getUnavailableDates'])->name('services.unavailable-dates');
Route::get('/services/{service}', [PageController::class, 'showService'])->name('services.show');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:form')
    ->name('contact.store');
Route::get('/how-it-works', [PageController::class, 'howItWorks'])->name('how-it-works');
Route::get('/upcoming', [PageController::class, 'upcoming'])->name('upcoming');
Route::get('/global', [PageController::class, 'global'])->name('global');
Route::get('/budget-planner', [BudgetPlannerController::class, 'index'])->name('budget-planner');
Route::get('/budget-planner/preview', [BudgetPlannerController::class, 'preview'])->name('budget-planner.preview');
Route::post('/budget-planner', [BudgetPlannerController::class, 'store'])
    ->middleware('throttle:form')
    ->name('budget-planner.store');
Route::post('/budget-planner/{budgetRequest}/acquire', [BudgetPlannerController::class, 'acquire'])->name('budget-planner.acquire');
Route::post('/newsletter', [NewsletterController::class, 'store'])
    ->middleware('throttle:form')
    ->name('newsletter.store');

// New Ecosystem Routes
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/refund-policy', [PageController::class, 'refundPolicy'])->name('refund-policy');
Route::get('/vendor-onboarding', [PageController::class, 'vendorOnboarding'])->name('vendor-onboarding');
Route::get('/insights', [PageController::class, 'insights'])->name('insights');
Route::get('/individual', [PageController::class, 'individual'])->name('individual');
Route::get('/corporate', [PageController::class, 'corporate'])->name('corporate');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');



// Custom Package Routes
Route::get('/packages', [CustomPackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{package}', [CustomPackageController::class, 'show'])->name('packages.show');


// Booking form — open to guests (no login required)
Route::get('/services/{service}/book', [BookingController::class, 'create'])->name('services.book');
Route::post('/services/{service}/book', [BookingController::class, 'store'])->name('services.store_booking');

// Guest booking tracking — token-gated, no login required
Route::get('/bookings/{booking}/track', [BookingController::class, 'track'])->name('bookings.track');

// Manual / Bank Transfer payments — open to guests (token-gated) and logged-in customers
Route::get('/bookings/{booking}/pay/manual', [\App\Http\Controllers\PaymentController::class, 'showManual'])->name('payment.manual');
Route::post('/bookings/{booking}/pay/manual', [\App\Http\Controllers\PaymentController::class, 'submitManual'])->name('payment.manual.submit');

// User Booking Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}/invoice', [BookingController::class, 'downloadInvoice'])->name('bookings.invoice');

    // Payments
    Route::post('/bookings/{booking}/pay', [\App\Http\Controllers\PaymentController::class, 'createCheckoutSession'])->name('payment.checkout');
    Route::get('/payment/success/{booking}', [\App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel/{booking}', [\App\Http\Controllers\PaymentController::class, 'cancel'])->name('payment.cancel');

    Route::post('/bookings/{booking}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('bookings.reviews.store');
    Route::post('/reviews/{review}/reply', [\App\Http\Controllers\ReviewController::class, 'reply'])->name('reviews.reply');
    Route::post('/reviews/{review}/like', [\App\Http\Controllers\ReviewController::class, 'toggleLike'])->name('reviews.like');
    Route::get('/my-packages', [CustomPackageController::class, 'myPackages'])->name('my-packages');
    Route::get('/my-packages/{booking}', [CustomPackageController::class, 'showBooking'])->name('my-packages.show');
    
    // Chat Routes
    Route::get('/messages/{receiver?}', [ChatController::class, 'index'])->name('messages.index');
    Route::post('/messages/{receiver}', [ChatController::class, 'sendMessage'])->name('messages.send');
    Route::get('/messages/{receiver}/updates', [ChatController::class, 'getUpdates'])->name('messages.updates');
    Route::get('/unread-messages-count', [ChatController::class, 'getUnreadCount'])->name('messages.unread-count');
    
    // Custom Package Management
    Route::get('/build-package', [CustomPackageController::class, 'create'])->name('packages.create');
    Route::post('/packages', [CustomPackageController::class, 'store'])->name('packages.store');
    Route::get('/packages/{package}/book', [CustomPackageController::class, 'book'])->name('packages.book');
    Route::post('/packages/{package}/book', [CustomPackageController::class, 'storeBooking'])->name('packages.store_booking');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', [VendorController::class, 'dashboard'])->name('dashboard');
    Route::get('/analytics', [VendorController::class, 'analytics'])->name('analytics');
    Route::get('/profile', [VendorController::class, 'profile'])->name('profile');
    Route::post('/profile', [VendorController::class, 'updateProfile'])->name('profile.update');
    Route::get('/finance', [VendorController::class, 'finance'])->name('finance');
    Route::post('/withdraw', [VendorController::class, 'withdraw'])->name('withdraw');

    Route::post('/ai/optimize-description', [\App\Http\Controllers\AIController::class, 'optimizeDescription'])->name('ai.optimize-description');
    Route::post('/ai/suggest-images', [\App\Http\Controllers\AIController::class, 'suggestImages'])->name('ai.suggest-images');
    
    // Service Management
    Route::get('/create-service', [VendorController::class, 'createService'])->name('create-service');
    Route::post('/store-service', [VendorController::class, 'storeService'])->name('store-service');
    Route::get('/services/{service}/edit', [VendorController::class, 'editService'])->name('edit-service');
    Route::put('/services/{service}', [VendorController::class, 'updateService'])->name('update-service');
    Route::delete('/services/{service}', [VendorController::class, 'destroyService'])->name('destroy-service');
    
    // Availability Management
    Route::get('/services/{service}/availability', [\App\Http\Controllers\VendorAvailabilityController::class, 'index'])->name('services.availability');
    Route::get('/services/{service}/availability/fetch', [\App\Http\Controllers\VendorAvailabilityController::class, 'fetch'])->name('services.availability.fetch');
    Route::post('/services/{service}/availability', [\App\Http\Controllers\VendorAvailabilityController::class, 'store'])->name('services.availability.store');
    Route::delete('/availability/{availability}', [\App\Http\Controllers\VendorAvailabilityController::class, 'destroy'])->name('services.availability.destroy');
    
    // Orders
    Route::get('/orders', [BookingController::class, 'vendorIndex'])->name('orders');
    Route::get('/custom-orders', [VendorController::class, 'customOrders'])->name('custom-orders');
    Route::patch('/orders/{booking}/status', [BookingController::class, 'updateStatus'])->name('orders.update');
    Route::put('/orders/{booking}/payment/verify', [BookingController::class, 'vendorVerifyPayment'])->name('orders.payment.verify');
    Route::put('/orders/{booking}/payment/reject', [BookingController::class, 'vendorRejectPayment'])->name('orders.payment.reject');
});

Route::middleware(['auth', 'role:corporate'])->prefix('corporate')->name('corporate.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\CorporateController::class, 'dashboard'])->name('dashboard');
});

Route::middleware(['auth', 'role:affiliate'])->prefix('affiliate')->name('affiliate.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AffiliateController::class, 'dashboard'])->name('dashboard');
    Route::get('/leads', [\App\Http\Controllers\AffiliateController::class, 'leads'])->name('leads');
    Route::get('/commissions', [\App\Http\Controllers\AffiliateController::class, 'commissions'])->name('commissions');
    Route::get('/resources', [\App\Http\Controllers\AffiliateController::class, 'resources'])->name('resources');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
    Route::get('/services', [AdminController::class, 'services'])->name('services');
    Route::get('/services/create', [AdminController::class, 'createService'])->name('services.create');
    Route::post('/services', [AdminController::class, 'storeService'])->name('services.store');
Route::get('/services/{service}/edit', [VendorController::class, 'editService'])->name('services.edit');
Route::put('/services/{service}', [VendorController::class, 'updateService'])->name('services.update');
Route::put('/services/{service}/toggle', [AdminController::class, 'toggleFeature'])->name('services.toggle');
Route::delete('/services/{service}', [AdminController::class, 'deleteService'])->name('services.delete');
    Route::get('/services-trash', [AdminController::class, 'trashedServices'])->name('services.trash');
    Route::put('/services/{id}/restore', [AdminController::class, 'restoreService'])->name('services.restore');
    Route::delete('/services/{id}/force-delete', [AdminController::class, 'forceDeleteService'])->name('services.force-delete');
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::delete('/bookings/{booking}', [AdminController::class, 'deleteBooking'])->name('bookings.delete');
    Route::get('/bookings-trash', [AdminController::class, 'trashedBookings'])->name('bookings.trash');
    Route::put('/bookings/{id}/restore', [AdminController::class, 'restoreBooking'])->name('bookings.restore');
    Route::delete('/bookings/{id}/force-delete', [AdminController::class, 'forceDeleteBooking'])->name('bookings.force-delete');
    Route::put('/bookings/{booking}/status', [AdminController::class, 'updateBookingStatus'])->name('bookings.status');
    Route::get('/users-trash', [\App\Http\Controllers\Admin\UserController::class, 'trashedUsers'])->name('users.trash');
    Route::put('/users/{id}/restore', [\App\Http\Controllers\Admin\UserController::class, 'restoreUser'])->name('users.restore');
    Route::delete('/users/{id}/force-delete', [\App\Http\Controllers\Admin\UserController::class, 'forceDeleteUser'])->name('users.force-delete');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::put('/users/{user}/ban', [\App\Http\Controllers\Admin\UserController::class, 'toggleBan'])->name('users.ban');
    Route::put('/users/{user}/verify', [\App\Http\Controllers\Admin\UserController::class, 'verifyVendor'])->name('users.verify');
    Route::resource('vendors', \App\Http\Controllers\Admin\VendorController::class)->except(['create', 'store', 'edit', 'update']);
    Route::post('/vendors/{vendor}/verify', [\App\Http\Controllers\Admin\VendorController::class, 'verify'])->name('vendors.verify');
    Route::get('/custom-packages', [AdminController::class, 'customPackages'])->name('custom-packages');
    Route::get('/custom-packages/{booking}', [AdminController::class, 'showCustomPackage'])->name('custom-packages.show');
    Route::get('/vendor-logs', [AdminController::class, 'vendorLogs'])->name('vendor-logs');
    Route::get('/budget-requests', [AdminController::class, 'budgetRequests'])->name('budget-requests');
    Route::get('/withdrawals', [AdminController::class, 'withdrawals'])->name('withdrawals');
    Route::patch('/withdrawals/{withdrawal}', [AdminController::class, 'updateWithdrawalStatus'])->name('withdrawals.update');

    // Manual payment verification
    Route::get('/payments', [AdminController::class, 'payments'])->name('payments.index');
    Route::put('/payments/{payment}/verify', [AdminController::class, 'verifyPayment'])->name('payments.verify');
    Route::put('/payments/{payment}/reject', [AdminController::class, 'rejectPayment'])->name('payments.reject');
    Route::put('/payments/{payment}/unverify', [AdminController::class, 'unverifyPayment'])->name('payments.unverify');

    // Setup & Configuration
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('service-categories', \App\Http\Controllers\Admin\ServiceCategoryController::class);
    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);
    Route::resource('features', \App\Http\Controllers\Admin\FeatureController::class);
    Route::resource('cities', \App\Http\Controllers\Admin\CityController::class);
    Route::get('/coupons', [\App\Http\Controllers\Admin\CouponController::class, 'index'])->name('coupons.index');
    Route::post('/coupons', [\App\Http\Controllers\Admin\CouponController::class, 'store'])->name('coupons.store');
    Route::put('/coupons/{coupon}', [\App\Http\Controllers\Admin\CouponController::class, 'update'])->name('coupons.update');
    Route::delete('/coupons/{coupon}', [\App\Http\Controllers\Admin\CouponController::class, 'destroy'])->name('coupons.destroy');
    Route::get('/settings', [\App\Http\Controllers\Admin\SiteSettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [\App\Http\Controllers\Admin\SiteSettingController::class, 'update'])->name('settings.update');

    // Homepage Content (CMS)
    Route::get('/homepage', [\App\Http\Controllers\Admin\HomepageController::class, 'edit'])->name('homepage.edit');
    Route::post('/homepage', [\App\Http\Controllers\Admin\HomepageController::class, 'update'])->name('homepage.update');
    Route::post('/homepage/media', [\App\Http\Controllers\Admin\HomepageMediaController::class, 'store'])->name('homepage.media.store');
    Route::post('/homepage/media/{media}', [\App\Http\Controllers\Admin\HomepageMediaController::class, 'update'])->name('homepage.media.update');
    Route::delete('/homepage/media/{media}', [\App\Http\Controllers\Admin\HomepageMediaController::class, 'destroy'])->name('homepage.media.destroy');

    // Blog Management
    Route::resource('blog', \App\Http\Controllers\Admin\BlogController::class);
    Route::patch('/blog/{blog}/toggle-publish', [\App\Http\Controllers\Admin\BlogController::class, 'togglePublish'])->name('blog.toggle-publish');
    Route::post('/blog-upload-image', [\App\Http\Controllers\Admin\BlogController::class, 'uploadImage'])->name('blog.upload-image');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('/notifications/recent', [NotificationController::class, 'getRecent'])->name('notifications.recent');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Wishlist Routes
    Route::get('/wishlist', [\App\Http\Controllers\FavoriteController::class, 'index'])->name('wishlist.index');
    Route::post('/services/{service}/favorite', [\App\Http\Controllers\FavoriteController::class, 'toggle'])->name('services.favorite');
    
    // Coupons
    Route::post('/coupons/validate', [\App\Http\Controllers\CouponController::class, 'validateCoupon'])->name('coupons.validate');

    // AI Chat
    Route::post('/ai/service-chat', [\App\Http\Controllers\AIController::class, 'serviceChat'])->name('ai.service-chat');
});

// Webhook (Public)
Route::post('/webhooks/stripe', [\App\Http\Controllers\PaymentController::class, 'webhook'])->name('payment.webhook');

require __DIR__.'/auth.php';

// Make cities resource route available globally (for navigation)
// Route::resource('cities', \App\Http\Controllers\Admin\CityController::class);

// require __DIR__.'/auth.php'; // Already required above

// ===================== HOTEL ROUTES =====================
use App\Http\Controllers\Hotel\HotelController;

// Public
Route::prefix('hotels')->name('hotels.')->group(function () {
    Route::get('/', [HotelController::class, 'index'])->name('index');
    Route::get('/{hotel}', [HotelController::class, 'show'])->name('show');
    Route::get('/{hotel}/book/{room}', [HotelController::class, 'bookingForm'])->name('book')->middleware('auth');
    Route::post('/{hotel}/book/{room}', [HotelController::class, 'storeBooking'])->name('book.store')->middleware('auth');
    Route::get('/booking/{booking}/success', [HotelController::class, 'bookingSuccess'])->name('booking.success')->middleware('auth');
});

// Vendor
Route::middleware(['auth'])->prefix('hotel/vendor')->name('hotel.vendor.')->group(function () {
    Route::get('/dashboard', [HotelController::class, 'vendorDashboard'])->name('dashboard');
    Route::get('/create', [HotelController::class, 'vendorCreate'])->name('create');
    Route::post('/store', [HotelController::class, 'vendorStore'])->name('store');
    Route::get('/edit', [HotelController::class, 'vendorEdit'])->name('edit');
    Route::put('/update', [HotelController::class, 'vendorUpdate'])->name('update');
    Route::delete('/destroy', [HotelController::class, 'vendorDestroy'])->name('destroy');
    Route::post('/add-room', [HotelController::class, 'addRoom'])->name('addRoom');
    Route::delete('/rooms/{room}', [HotelController::class, 'deleteRoom'])->name('deleteRoom');
    Route::put('/bookings/{booking}', [HotelController::class, 'vendorUpdateBooking'])->name('updateBooking');
});

// Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin/hotels')->name('admin.hotels.')->group(function () {
    Route::get('/', [HotelController::class, 'adminIndex'])->name('index');
    Route::get('/create', [HotelController::class, 'adminCreate'])->name('create');
    Route::post('/', [HotelController::class, 'adminStore'])->name('store');
    Route::get('/bookings', [HotelController::class, 'adminBookings'])->name('bookings');
    Route::get('/{hotel}', [HotelController::class, 'adminShow'])->name('show');
    Route::get('/{hotel}/edit', [HotelController::class, 'adminEdit'])->name('edit');
    Route::put('/{hotel}', [HotelController::class, 'adminUpdate'])->name('update');
    Route::delete('/{hotel}', [HotelController::class, 'adminDestroy'])->name('destroy');
    Route::put('/{hotel}/approve', [HotelController::class, 'adminApprove'])->name('approve');
    Route::put('/{hotel}/reject', [HotelController::class, 'adminReject'])->name('reject');
    Route::put('/{hotel}/featured', [HotelController::class, 'adminToggleFeatured'])->name('featured');
    Route::post('/{hotel}/rooms', [HotelController::class, 'adminAddRoom'])->name('rooms.store');
    Route::delete('/{hotel}/rooms/{room}', [HotelController::class, 'adminDeleteRoom'])->name('rooms.destroy');
    Route::put('/bookings/{booking}/status', [HotelController::class, 'adminUpdateBooking'])->name('bookings.update');
});


