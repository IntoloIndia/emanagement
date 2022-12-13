<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SizeColorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\PurchaseEntryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BusinessDetailsController;
use App\Http\Controllers\ManageStockController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CountryStateCityController;
use App\Http\Controllers\SalesInvoiceController;
use App\Http\Controllers\ExcalProductDataController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\StyleNoController;
use App\Http\Controllers\AlterationVoucherController;
use App\Http\Controllers\BrandController;

use App\MyApp;
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

Route::get('/', function () {
    return view('/login');
});


Route::get('/login', [AuthController::class, 'index']);
Route::post('/login-auth', [AuthController::class, 'loginAuth']);

//admin
Route::group(['middleware'=>'admin_auth'], function(){

    Route::fallback(function () {
        return view('404');
    });

    Route::get('admin/dashboard', [DashboardController::class, 'index']);
    // Route::get('admin/billing', [BillingController::class, 'index']);

    // Route::controller(BillingController::class)->group(function () {
    //     Route::get('admin/billing','index');
    //     Route::post('admin/save-order', 'saveOrder');
    //     Route::get('admin/get-item-price/{product_code}', 'getItemPrice');

    //     Route::get('admin/generate-invoice/{customer_id}','generateInvoice');
        
    // });

    // business details 

    Route::controller(BusinessDetailsController::class)->group(function () {
        Route::get('admin/business-details','index');
        Route::post('admin/save-company-details','saveCompanyDetail');
        Route::get('admin/edit-company-details/{company_id}','editCompanyDetails');
        Route::post('admin/update-company-details/{company_id}','updateCompanyDetails');
        Route::get('admin/delete-company-details/{company_id}','deleteCompanyDetail');

    });

    Route::controller(CountryStateCityController::class)->group(function () {
        Route::get('admin/country-state-city','index');

        Route::post('admin/manage-country', 'manageCountry');
        Route::get('admin/edit-country/{country_id}', 'editCountry');
        Route::get('admin/delete-country/{country_id}', 'deleteCountry');

        Route::post('admin/manage-state', 'manageState');
        Route::get('admin/edit-state/{state_id}', 'editState');
        Route::get('admin/delete-state/{state_id}', 'deleteState');        

        Route::post('admin/manage-city', 'manageCity');
        Route::get('admin/edit-city/{city_id}', 'editCity');
        Route::get('admin/delete-city/{city_id}', 'deleteCity');

        Route::get('admin/get-state-by-country/{country_id}', 'getStateByCountry');
        Route::get('admin/get-city-by-state/{state_id}', 'getCityByState');

    });

    Route::controller(CustomerController::class)->group(function () {
        Route::get('admin/customer','index');
        Route::get('admin/get-customer/{customer_id}','getCustomerData');

        
    });


    // discount route 
    Route::controller(DiscountController::class)->group(function () {
        Route::get('admin/discount','index');
          
    });

    Route::controller(ExcalProductDataController::class)->group(function () {
        Route::get('admin/excel_data','index');
        Route::get('admin/import-data-product','import');
        Route::post('admin/export-excel-data-product','export');
          
    });

    // supplier 

    Route::controller(SupplierController::class)->group(function () {
        Route::get('admin/supplier','index');
        Route::post('admin/save-supplier-order', 'saveSupplier');
        Route::get('admin/edit-supplier-order/{supplier_id}', 'editSupplier');
        Route::post('admin/update-supplier-order/{supplier_id}', 'updateSupplier');
        Route::get('admin/delete-supplier-order/{supplier_id}', 'deleteSupplier');
        Route::get('admin/supplier-detail/{supplier_id}', 'supplierDetail');

        Route::get('admin/get-city-short/{city_id}', 'getCityShortName');
    });

    Route::controller(StyleNoController::class)->group(function () {
        Route::get('admin/style-no','index');
        Route::get('admin/style-no-by-supplier/{supplier_id}','styleNoBySupplier');
        Route::post('admin/save-style-no','manageStyleNo');
        Route::get('admin/supplier-style-no/{supplier_id}','supplierStyleNo');

        Route::get('admin/edit-style-no/{style_id}','editStyleNo');
        Route::get('admin/delete-style-no/{style_no_id}','deleteStyleNo');

    });
    

     // sales invoice 

     Route::controller(SalesInvoiceController::class)->group(function () {
        Route::get('admin/sales_invoice','index');
        Route::post('admin/save-order', 'saveOrder');
        Route::get('admin/get-item-price/{product_code}', 'getItemPrice');
        Route::get('admin/get-customer-data/{mobile_no}', 'getCumosterData');
        Route::get('admin/generate-invoice/{customer_id}','generateInvoice');
        

    });

    // Alteration voucher 
    
    Route::controller(AlterationVoucherController::class)->group(function () {
        Route::get('admin/alteration_voucher','index');
        Route::post('admin/save-alteration-voucher-order','saveAlterationVoucher');
        Route::get('admin/generate-invoice-voucher/{customer_id}','generateAlerationVoucher');
        // Route::get('admin/get-customer-data-bill/{customer_id}', 'getCumosterDataBills');
        Route::get('admin/get-customers-bills/{customer_id}','getCustomerBillData');

          
    });

    Route::controller(AdminController::class)->group(function () {
        Route::get('admin/admin','index');
        Route::post('admin/save-admin', 'saveAdmin');
        Route::get('admin/edit-admin/{admin_id}', 'editAdmin');
        Route::post('admin/update-admin/{admin_id}', 'updateAdmin');
        Route::get('admin/delete-admin/{admin_id}', 'deleteAdmin');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('admin/user','index');
        Route::post('admin/save-user', 'saveUser');
        Route::get('admin/edit-user/{user_id}', 'editUser');
        Route::post('admin/update-user/{user_id}', 'updateUser');
        Route::get('admin/delete-user/{user_id}', 'deleteUser');
    });
    
    Route::controller(CategoryController::class)->group(function () {
        Route::get('admin/category', 'index');
        Route::post('admin/save-category', 'saveCategory');
        Route::get('admin/edit-category/{category_id}', 'editCategory');
        Route::post('admin/update-category/{category_id}', 'updateCategory');
        Route::get('admin/delete-category/{category_id}', 'deleteCategory');
        

        // Route::post('/orders', 'store');
    });

    Route::controller(SubCategoryController::class)->group(function () {
        Route::get('admin/sub-category', 'index');
        Route::post('admin/save-sub-category', 'saveSubCategory');
        Route::get('admin/edit-sub-category/{sub_category_id}', 'editSubCategory');
        Route::post('admin/update-sub-category/{sub_category_id}', 'updateSubCategory');
        Route::get('admin/delete-sub-category/{sub_category_id}', 'deleteSubCategory');

        Route::get('admin/get-sub-category-by-category/{category_id}', 'getSubCategoryByCategory');
        
    });

    Route::controller(SizeColorController::class)->group(function () {
        Route::get('admin/size-color', 'index');
        //size
        Route::post('admin/save-size', 'saveSize');
        Route::get('admin/edit-size/{size_id}', 'editSize');
        Route::post('admin/update-size/{size_id}', 'updateSize'); 
        Route::get('admin/delete-size/{size_id}', 'deleteSize');

        //color
        Route::post('admin/save-color', 'saveColor');
        Route::get('admin/edit-color/{color_id}', 'editColor');
        Route::post('admin/update-color/{color_id}', 'updateColor'); 
        Route::get('admin/delete-color/{color_id}', 'deleteColor');

    });

    Route::controller(PurchaseEntryController::class)->group(function () {
        Route::get('admin/purchase-entry', 'index');
        Route::post('admin/save-purchase-entry', 'savePurchaseEntry');
        Route::get('admin/edit-purchase-entry/{product_id}', 'editPurchaseEntry');
        Route::post('admin/update-purchase-entry/{product_id}', 'updatePurchaseEntry');
        Route::get('admin/delete-purchase-entry/{product_id}', 'deletePurchaseEntry');

        Route::get('admin/barcode', 'getBarcode');
        Route::get('admin/get-color_code/{color_code}','getcolorcode');

        // excel file route 

        Route::get('admin/import-data','importProduct');
        Route::post('admin/export-excel-data','exportProduct');

        // category of purchase entry
        Route::post('admin/save-category', 'saveCategory');
        Route::post('admin/save-sub-category', 'saveSubCategory');
        Route::post('admin/save-style-no','manageStyleNo');

        Route::post('admin/save-brand','saveBrand');
        Route::get('admin/edit-brand/{brand_id}','editBrand');
        Route::post('admin/update-brand/{brand_id}','updateBrand');
        Route::get('admin/delete-brand/{brand_id}','deleteBrand');

    });
    
    Route::controller(ManageStockController::class)->group(function () {
        Route::get('admin/manage-stock', 'index');
    });

    Route::controller(DepartmentController::class)->group(function () {
        Route::get('admin/department', 'index');
        Route::post('admin/save-department', 'saveDepartment');
        Route::get('admin/edit-department/{department_id}', 'editDepartment');
        Route::post('admin/update-department/{department_id}', 'updateDepartment');
        Route::get('admin/delete-department/{department_id}', 'deleteDepartment');
    });

    Route::controller(DiscountController::class)->group(function () {
        Route::get('admin/discountt', 'index');
        Route::post('admin/save-discount', 'saveDiscount');
        Route::get('admin/edit-discount/{discount_id}', 'editDiscount');
        Route::post('admin/update-discount/{discount_id}', 'updateDiscount');
        Route::get('admin/delete-discount/{discount_id}', 'deleteDiscount');
    });

    Route::controller(BrandController::class)->group(function () {
        Route::get('admin/brand','index');
        Route::post('admin/save-brand','saveBrand');
        Route::get('admin/edit-brand/{brand_id}','editBrand');
        Route::post('admin/update-brand/{brand_id}','updateBrand');
        Route::get('admin/delete-brand/{brand_id}','deleteBrand');

    });
    
    Route::get('admin/logout', [AuthController::class, 'logout']);
});

//billing
Route::group(['middleware'=>'billing_auth'], function(){

    Route::fallback(function () {
        return view('404');
    });

    Route::get('billing', [BillingController::class, 'index']);

    Route::controller(CategoryController::class)->group(function () {
        Route::get('category', 'index');
        // Route::post('/orders', 'store');
    });

    Route::controller(SizeColorController::class)->group(function () {
        Route::get('size-color', 'index');
        //size
        Route::post('save-size', 'saveSize');
        Route::get('edit-size/{size_id}', 'editSize');
        Route::post('update-size/{size_id}', 'updateSize'); 
        Route::get('delete-size/{size_id}', 'deleteSize');

        //color
        Route::post('save-color', 'saveColor');
        Route::get('edit-color/{color_id}', 'editColor');
        Route::post('update-color/{color_id}', 'updateColor'); 
        Route::get('delete-color/{color_id}', 'deleteColor');
    });


    Route::get('logout', [AuthController::class, 'logout']);
});
    

    



