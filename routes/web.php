<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\SiteSettingController;

use App\Http\Controllers\Frontend\{
    ProductViewController,
    CartController,
    OrderController,
    WishlistController,
    searchController,
   
};
use App\Http\Controllers\Backend\{
    HomeController,
    SettingController,
    OrderManageController,
    CategoryController,
    SubcategoryController,
    ColorController,
    SizeController,
    BrandController,
    UnitController,
    ProductController,
    SpecialBannerController,
    AdditionalController,
    MessageController,
    SeconderyBannerController,
    SliderController
};






// Start unauthenticated Frontend routes

Route::get('/',[IndexController::class,'index'])->name('home');

Route::get('/product/details/{id}',[ProductViewController::class,'productDetails'])->name('product.details');

Route::get('/category/products/{id}',[ProductViewController::class,'categoryProducts'])->name('category.products');

// routes for user profile related
Route::get('/user/register', [UserLoginController::class, 'userRegister'])->name('user.register');
Route::post('/store/register', [UserLoginController::class, 'storeRegister'])->name('store.register');

Route::get('/user/login', [UserLoginController::class, 'userLogin'])->name('user.login');

Route::get('/contact/us', [InfoController::class,'contactUs'])->name('contact.us');
Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

Route::get('/about/us', [InfoController::class,'aboutUs'])->name('about.us');




Route::get('/privacy-policy', function () {
    return view('frontend.pages.privacy&policy');
})->name('privacy.policy');


Route::get('/terms-and-conditions', function () {
    return view('frontend.pages.terms&conditions');
})->name('terms.conditions');


Route::get('/shipping-policy', function () {
    return view('frontend.pages.shippingPolicy');
})->name('shipping.policy');

Route::get('/returns-exchanges', function () {
    return view('frontend.pages.returns');
})->name('returns.exchanges');

Route::middleware(['auth'])->group(function () {
    Route::get('/orders/{id}', [UserController::class, 'showOrder'])->name('user.orders.show');
});



Route::post('/orders/{id}/cancel', [UserController::class, 'cancelOrder'])
    ->name('user.orders.cancel')
    ->middleware('auth');



















use Intervention\Image\ImageManagerStatic as Image;


Route::get('/test-image', function () {
    $img = Image::canvas(200, 100, '#ff0000'); // Create a red canvas
    return $img->response('jpg'); // Return the image response
});






Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');

Route::get('/cart/index', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');

// Route::get('/cart/items', [CartController::class, 'fetchCartItems'])->name('cart.items');
Route::get('/cart/items', [CartController::class, 'fetchCartItems'])->name('cart.items');


//shipping routes
Route::get('/shipping',[OrderController::class,'shipping'])->name('shipping');


Route::post('/store/order', [OrderController::class, 'store'])->name('store.order');
Route::get('/order/success/{orderNumber}', [OrderController::class, 'success'])->name('order.success');


Route::get('/order/{orderNumber}', [OrderController::class, 'show'])->name('order.show');

Route::get('/product/quick-view/{id}', [ProductViewController::class, 'quickView'])->name('product.quickView');


Route::get('/live-search', [searchController::class, 'liveSearch'])->name('live.search');




Route::middleware(['auth'])->group(function() {
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
});





Route::middleware('auth')->group(function () {

    // Start Frontend Authorized routes for logged in User 

    Route::post('/new/password/update', [UserController::class, 'UpdateUserPassword'])->name('new.password.update')->middleware('auth');;
    Route::get('/user/dashboard', [UserController::class, 'userProfile'])->name('user.dashboard')->middleware('auth'); // Profile dashboard
    Route::post('/user/user/profile/update', [UserController::class, 'UpdateUserProfile'])->name('user.profile.update');
    

    Route::get('/user/orders', [UserController::class, 'orders'])->name('user.orders'); // View all orders
    Route::get('/user/orders/{order}', [UserController::class, 'showOrder'])->name('user.orders.show'); // View specific order

    // **Wishlist**
    Route::get('/user/wishlist', [UserController::class, 'wishlist'])->name('user.wishlist'); // View wishlist
    Route::post('/user/wishlist/add/{product}', [UserController::class, 'addToWishlist'])->name('user.wishlist.add'); // Add product to wishlist
    Route::delete('/users/wishlist/remove/{product}', [UserController::class, 'removeFromWishlist'])->name('users.wishlist.remove'); // Remove product from wishlist

    // **Profile Management**
    Route::get('/user/edit', [UserController::class, 'editProfile'])->name('user.edit'); // Edit profile
    Route::put('/user/update', [UserController::class, 'updateProfile'])->name('user.update'); // Update profile details
    Route::put('/user/password/update', [UserController::class, 'updatePassword'])->name('user.password.update'); // Update password

    // **Address Management**
    Route::get('/user/addresses', [UserController::class, 'addresses'])->name('user.addresses'); // View all addresses
    Route::post('/user/addresses/store', [UserController::class, 'storeAddress'])->name('user.addresses.store'); // Add a new address
    Route::put('/user/addresses/{address}/update', [UserController::class, 'updateAddress'])->name('user.addresses.update'); // Update an address
    Route::delete('/user/addresses/{address}/delete', [UserController::class, 'deleteAddress'])->name('user.addresses.delete'); // Delete an address
// Frontend Authorized routes for loggedin User end

    });
    

require __DIR__.'/auth.php';

// backend routes










Route::group(['middleware' => ['auth', 'admin']], function() {
   

    Route::get('/admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('/all/users', [HomeController::class, 'allUsers'])->name('all.users');
     Route::get('/delete/user/{id}', [HomeController::class, 'deleteUser'])->name('delete.users');
    Route::post('/user/change-role', [HomeController::class, 'changeUserRole'])
        ->name('user.change.role');
    
// routes for category start
Route::group(['prefix'=>"category",'as'=>'category.'], function(){
    Route::get('/manage',[CategoryController::class,'index'])->name('index');
    Route::get('/create',[CategoryController::class,'create'])->name('create');
    Route::post('/store',[CategoryController::class,'store'])->name('store');
    Route::get('/edit/{id}',[CategoryController::class,'edit'])->name('edit');
    Route::post('/update',[CategoryController::class,'update'])->name('update');
    Route::get('/delete/{id}',[CategoryController::class,'delete'])->name('delete');
    Route::post('/update-status',[CategoryController::class,'updateStatus'])->name('updateStatus');
});
// routes for category end

Route::group(['prefix'=>"subcategory",'as'=>'subcategory.'], function(){
    Route::get('/manage', [SubcategoryController::class, 'index'])->name('index');
    Route::get('/create', [SubcategoryController::class, 'create'])->name('create');
    Route::post('/store', [SubcategoryController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [SubcategoryController::class, 'edit'])->name('edit');
    Route::post('/update', [SubcategoryController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [SubcategoryController::class, 'delete'])->name('delete');
    Route::post('/update-status', [SubcategoryController::class, 'updateStatus'])->name('updateStatus');
});

// Color Routes
Route::group(['prefix'=>"color",'as'=>'color.'], function(){
    Route::get('/manage', [ColorController::class, 'index'])->name('index');
    Route::get('/create', [ColorController::class, 'create'])->name('create');
    Route::post('/store', [ColorController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [ColorController::class, 'edit'])->name('edit');
    Route::post('/update', [ColorController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [ColorController::class, 'delete'])->name('delete');
    Route::post('/update-status', [ColorController::class, 'updateStatus'])->name('updateStatus');
});

// Size Routes
Route::group(['prefix'=>"size",'as'=>'size.'], function(){
    Route::get('/manage', [SizeController::class, 'index'])->name('index');
    Route::get('/create', [SizeController::class, 'create'])->name('create');
    Route::post('/store', [SizeController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [SizeController::class, 'edit'])->name('edit');
    Route::post('/update', [SizeController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [SizeController::class, 'delete'])->name('delete');
    Route::post('/update-status', [SizeController::class, 'updateStatus'])->name('updateStatus');
});

// Brand Routes
Route::group(['prefix'=>"brand",'as'=>'brand.'], function(){
    Route::get('/manage', [BrandController::class, 'index'])->name('index');
    Route::get('/create', [BrandController::class, 'create'])->name('create');
    Route::post('/store', [BrandController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [BrandController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [BrandController::class, 'delete'])->name('delete');
    Route::post('/update-status', [BrandController::class, 'updateStatus'])->name('updateStatus');
});

// Unit Routes
Route::group(['prefix'=>"unit",'as'=>'unit.'], function(){
    Route::get('/manage', [UnitController::class, 'index'])->name('index');
    Route::get('/create', [UnitController::class, 'create'])->name('create');
    Route::post('/store', [UnitController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [UnitController::class, 'edit'])->name('edit');
    Route::post('/update', [UnitController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [UnitController::class, 'delete'])->name('delete');
    Route::post('/update-status', [UnitController::class, 'updateStatus'])->name('updateStatus');
});

// Product Routes
Route::group(['prefix'=>"product",'as'=>'product.'], function(){
    Route::get('/list', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::get('/get-subcategories/{categoryId}', [ProductController::class, 'getSubcategories'])->name('get.subcategories');
    Route::get('/view/details/{id}', [ProductController::class, 'ViewDetails'])->name('view.details');
    Route::post('/product/update-status/', [ProductController::class, 'updateStatus'])->name('updateStatus');
    Route::post('/product/varient/update-status/', [ProductController::class, 'updateVarientStatus'])->name('varient.updateStatus');
    Route::post('/store', [ProductController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [ProductController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('delete');
    Route::delete('/delete/gallery-image/{id}', [ProductController::class, 'deleteGalleryImage'])->name('delete.gallery-image');
    Route::post('/duplicate/{id}', [ProductController::class, 'duplicateProduct'])->name('duplicate');
    Route::delete('/delete/variant/{id}', [ProductController::class, 'deleteVariant'])->name('delete.variant');
});

// Order Management Routes
Route::group(['prefix'=>"order",'as'=>'order.'], function(){
    Route::get('/manage/order', [OrderManageController::class, 'index'])->name('index');
    Route::get('/each/details/{id}', [OrderManageController::class, 'orderDetails'])->name('details');
    Route::post('/store', [OrderManageController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [OrderManageController::class, 'edit'])->name('edit');
    Route::post('/update', [OrderManageController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [OrderManageController::class, 'delete'])->name('delete');
    Route::post('/update-status', [OrderManageController::class, 'updateStatus'])->name('updateStatus');
    Route::get('/invoice/{id}', [OrderManageController::class, 'invoice'])->name('invoice');
    Route::get('/download-pdf/{id}', [OrderManageController::class, 'downloadPDF'])->name('download-pdf');
    Route::post('/update-payment-status', [OrderController::class, 'updatePaymentStatus'])->name('updatePaymentStatus');


});



Route::group(['prefix' => 'special-banner', 'as' => 'special-banner.'], function() {
    Route::get('/', [SpecialBannerController::class, 'index'])->name('index');
    Route::post('/store', [SpecialBannerController::class, 'store'])->name('store');
    Route::post('/update-status', [SpecialBannerController::class, 'updateStatus'])->name('updateStatus');
});


Route::group(['middleware' => ['auth', 'admin']], function() {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{id}', [MessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');
});





Route::group(['middleware' => ['auth', 'admin']], function() {
    Route::group(['prefix' => 'secondary-banner', 'as' => 'secondary-banner.'], function() {
        Route::get('/', [SeconderyBannerController::class, 'index'])->name('index');
        Route::get('/create', [SeconderyBannerController::class, 'create'])->name('create');
        Route::post('/store', [SeconderyBannerController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [SeconderyBannerController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [SeconderyBannerController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [SeconderyBannerController::class, 'destroy'])->name('destroy');
        Route::post('/update-status', [SeconderyBannerController::class, 'updateStatus'])->name('updateStatus');
    });
});



Route::group(['middleware' => ['auth', 'admin']], function() {
    Route::group(['prefix' => 'sliders', 'as' => 'sliders.'], function() {
        Route::get('/', [SliderController::class, 'index'])->name('index'); // List all sliders
        Route::get('/create', [SliderController::class, 'create'])->name('create'); // Show create form
        Route::post('/store', [SliderController::class, 'store'])->name('store'); // Store new slider
        Route::get('/edit/{id}', [SliderController::class, 'edit'])->name('edit'); // Show edit form
        Route::post('/update/{id}', [SliderController::class, 'update'])->name('update'); // Update slider
        Route::delete('/destroy/{id}', [SliderController::class, 'destroy'])->name('destroy'); // Delete slider
        Route::post('/update-status', [SliderController::class, 'updateStatus'])->name('updateStatus'); // Update status via AJAX
    });
});







Route::middleware(['auth', 'admin'])->group(function() {
    Route::get('/settings', [SiteSettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SiteSettingController::class, 'update'])->name('settings.update');
});

});












/* setting */
Route::group(['prefix'=>"setting",'as'=>'setting.','namespace'=>"App\Http\Controllers"],function(){
    Route::get('/create','SettingController@create')->name('create');
    Route::post('/store','SettingController@store')->name('store');
    Route::get('/{id}/edit','SettingController@edit')->name('edit');
    Route::patch('/{id}/update','SettingController@update')->name('update');
 });
/* setting */

/* additional work */
Route::group(['prefix'=>"get",'as'=>'get.','namespace'=>"App\Http\Controllers"],function(){
    Route::get('/products','AdditionalController@getProducts')->name('products');
    Route::get('/customers','AdditionalController@getCustomers')->name('customers');
    Route::get('/invoices','AdditionalController@getInvoices')->name('invoices');
    Route::get('/customer/group','AdditionalController@getCustomerGroup')->name('customer.group');
 });




