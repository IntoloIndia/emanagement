<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoleController;
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
use App\Http\Controllers\CustomerBillInvoiceController;
use App\Http\Controllers\ExcalProductDataController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\StyleNoController;
use App\Http\Controllers\AlterationVoucherController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\SalesReturnController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PaymentReceivingController;
use App\Http\Controllers\CompanySupplierController;
use App\Http\Controllers\CompanyPurchaseController;
use App\Http\Controllers\CompanySalesController;
use App\Http\Controllers\ReportController;

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


// Route::get('/getmacshellexec',function()
//     {
//         $shellexec = shell_exec('getmac'); 
//         dd($shellexec);
//     }
// );

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

    Route::controller(CompanySupplierController::class)->group(function () {
        Route::get('admin/company-supplier','index');

        Route::post('admin/save-company-supplier', 'saveCompanySupplier');
        Route::get('admin/edit-company-supplier/{supplier_id}', 'editCompanySupplier');
        Route::post('admin/update-company-supplier/{supplier_id}', 'updateCompanySupplier');
        Route::get('admin/delete-company-supplier/{supplier_id}', 'deleteCompanySupplier');
        Route::get('admin/company-supplier-detail/{supplier_id}', 'companySupplierDetail');
        
    });
    
    Route::controller(CompanyPurchaseController::class)->group(function () {
        Route::get('admin/company-purchase','index');
        
    });

    Route::controller(CompanySalesController::class)->group(function () {
        Route::get('admin/company-sales','index');
        
        Route::post('admin/save-company-sales', 'saveCompanySales');
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
        // Route::get('admin/get-customer/{customer_id}','getCustomerData');
        Route::get('admin/customer-detail/{customer_id}','CustomerDetail');
    //  Route::get('admin/get-customer-points/{customer_id}','getCustomerPoints');
        // Route::get('admin/generate-invoice/{customer_id}','generateInvoice');
    
    });

    // discount route 
    Route::controller(DiscountController::class)->group(function () {
        Route::get('admin/discount','index');
          
    });

    Route::controller(BarcodeController::class)->group(function () {
        Route::get('admin/barcode','index');
        Route::get('admin/filter-barcode/{sub_category_id?}/{brand_id?}/{style_no_id?}/{color?}','filterBarcode');
        Route::get('admin/barcode-by-purchase-entry/{purchase_entry_id}','getBarcodeByPurchaseEntry');

        Route::get('admin/barcode-all-purchase-entry/{purchases_id}','getAllBarcodeByPurchaseEntry');
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
    
        // Route::get('admin/get-state-by-country/{country_id}', 'getStateByCountry');
        // Route::get('admin/get-city-by-state/{state_id}', 'getCityByState');
        // Route::post('admin/manage-city', 'manageCity');
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
    Route::controller(CustomerBillInvoiceController::class)->group(function () {
        Route::get('admin/customer_bill_invoices','index');
        Route::post('admin/save-order', 'saveOrder');
        Route::get('admin/get-customer-data/{mobile_no}', 'getCustomerData');
        Route::get('admin/generate-invoice/{bill_id}','generateInvoice');
    });

    // Alteration voucher 
    
    Route::controller(AlterationVoucherController::class)->group(function () {
        Route::get('admin/alteration_voucher','index');
        Route::get('admin/alter-voucher/{bill_id}','alterVoucher');
        Route::post('admin/save-alteration-voucher','saveAlterationVoucher');
        Route::get('admin/get-customers-bills/{customer_id}','getCustomerBills');
        Route::get('admin/get-alter-item/{alteration_voucher_id}','getAlterItem');
        Route::get('admin/update-delivery-status/{alteration_voucher_id}','updateDeliveryStatus');

    });

    Route::controller(AdminController::class)->group(function () {
        Route::get('admin/admin','index');
        Route::post('admin/save-admin', 'saveAdmin');
        Route::get('admin/edit-admin/{admin_id}', 'editAdmin');
        Route::post('admin/update-admin/{admin_id}', 'updateAdmin');
        Route::get('admin/delete-admin/{admin_id}', 'deleteAdmin');
    });

    Route::controller(RoleController::class)->group(function(){
        Route::get('admin/role','index');
        Route::post('admin/save-role','saveRole');
        Route::get('admin/edit-role/{role_id}','editRole');
        Route::post('admin/update-role/{role_id}','updateRole');
        Route::get('admin/delete-role/{role_id}','deleteRole');
        Route::get('admin/active-deactive-role/{role_id}','activeDeactiveRole');
    });


    Route::controller(UserController::class)->group(function () {
        Route::get('admin/user','index');
        Route::post('admin/save-user', 'saveUser');
        Route::get('admin/edit-user/{user_id}', 'editUser');
        Route::post('admin/update-user/{user_id}', 'updateUser');
        // Route::get('admin/delete-user/{user_id}', 'deleteUser');
        Route::get('admin/user-is-active/{user_id}/{user_role_id}', 'userIsActive');
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

    // sales return 
    Route::controller(SalesReturnController::class)->group(function () {
        Route::get('admin/sales-return', 'index');
        Route::get('admin/sales-return-item/{bill_no}/{barcode_code}', 'getSalesReturnData');
        Route::get('admin/get-customer-details/{bill_no}', 'getCustomerDetails');
        Route::post('admin/save-sales-return-item', 'saveSalesReturnProduct');
        // Route::get('admin/update-release-status/{sales_return_id}', 'updateSalesReleaseStatus');
        Route::get('admin/sales-return-invoice/{sales_return_id}','salesReturnInvoice');
        Route::get('admin/sales_return-status-update/{sales_return_id}', 'updateSalesReturnStatus');
    });

    // offer return 
    Route::controller(OfferController::class)->group(function () {
        Route::get('admin/offer', 'index');
        Route::post('admin/save-offer-apply', 'saveApplyOffer');
        Route::post('admin/save-create-offer', 'saveCreateOffers');
        Route::get('admin/edit-offer/{offer_id}', 'editOffer');
        Route::post('admin/update-offer/{offer_id}', 'updateOffer');
        Route::get('admin/delete-offer/{offer_id}', 'deleteOffer');
        Route::get('admin/offer-type/{offer_type}', 'getOfferType');
        Route::get('admin/applye_offer_update_status/{apply_offer_id}', 'applyOfferUpdateStatus');

    });

    Route::controller(PurchaseEntryController::class)->group(function () {
        Route::get('admin/purchase-entry', 'index');
        Route::post('admin/save-purchase-entry', 'savePurchaseEntry');
        Route::get('admin/edit-purchase-entry/{purchase_entry_id}', 'editPurchaseEntry');
        Route::post('admin/update-purchase-entry/{purchase_id}/{purchase_entry_id}', 'updatePurchaseEntry');
        Route::get('admin/delete-purchase-entry-item-wise/{purchase_entry_item_id}','deletePurchaseEntryItemWise');
        Route::get('admin/delete-purchase-entry-style-wise/{purchase_entry_id}','deletePurchaseEntryStyleWise');

        // Route::get('admin/delete-purchase-entry/{product_id}', 'deleteProductDetail');

        Route::get('admin/get-product-detail/{product_code}', 'getProductDetail');
        // Route::get('admin/get-product-detail/{barcode}', 'getProductDetail');

        // Route::get('admin/barcode', 'getBarcode');
        Route::get('admin/get-color_code/{color_code}','getcolorcode');

        // excel file route 

        Route::get('admin/import-data','importProduct');
        Route::post('admin/export-excel-data','exportProduct');

        // category of purchase entry
        // Route::post('admin/save-category', 'saveCategory');
        // Route::post('admin/save-sub-category', 'saveSubCategory');
        // Route::post('admin/save-brand','saveBrand');
        // Route::post('admin/save-style-no','manageStyleNo');

        Route::get('admin/get-purchase-entry/{supplier_id}/{bill_no}','getPurchaseEntry');
        Route::get('admin/generate-purchase-invoice/{purchase_id}','generatePurchaseInvoice');
        Route::get('admin/view-purchase-entry/{purchase_id}','viewPurchaseEntry');

        Route::post('admin/load-pt-file-data','loadPtFileData');
        Route::post('admin/save-pt-file','savePtFile');

    });

    Route::controller(PurchaseReturnController::class)->group(function () {
        Route::get('admin/purchase-return', 'index');
        Route::get('admin/purchase-return-show-data', 'purchaseReturnShowData');
        Route::get('admin/get-return-product-item/{barcode_code}', 'getReturnData');
        Route::post('admin/save-return-item', 'saveReturnProduct');
        Route::get('admin/update-release-status/{supplier}', 'updateReleaseStatus');
        Route::get('admin/purchase-return-invoice/{purchase_return_id}','purchaseReturnInvoice');
    });

    
    Route::controller(ManageStockController::class)->group(function () {
        Route::get('admin/manage-stock', 'index');
        Route::get('admin/show-product/{category_id}/{sub_category_id?}/{brand_id?}/{style_no_id?}/{color?}','showProduct');
        Route::get('admin/get-style-no/{style_no_id}','getstyleNo');
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

    Route::controller(PaymentReceivingController::class)->group(function () {
        Route::get('admin/payment-receiving', 'index');
        Route::get('admin/get-payment-receiving/{bill_id}', 'paymentReceiving');
        Route::post('admin/save-payment-receiving', 'savePaymentReceiving');
        
    });

    Route::controller(ReportController::class)->group(function () {
        Route::get('admin/offer-report','offerReport');
        // Route::get('admin/month-report-data/{month_id}','filterOfferReport');

        // Route::get('admin/filter-barcode/{sub_category_id?}/{brand_id?}/{style_no_id?}/{color?}','filterBarcode');
        Route::get('admin/sales-report','salesReport');
        // Route::get('admin/sales-report-detail','salesReportDetail');
        Route::get('admin/sales-report-detail/{month_id?}','salesReportDetail');
        // Route::get('admin/brand-report/{from_date}','brandReport');
        Route::get('admin/brand-report/{month_id?}','brandReport');
        Route::get('admin/get-sales-payment/{customer_id}','getSalesPayment');
        // Route::get('admin/get-sales-payment/{customer_id}/{month}','getSalesPayment');
        
    });

    
    Route::get('admin/logout', [AuthController::class, 'logout']);
});


Route::group(['middleware'=>'user_auth'], function(){
    Route::fallback(function () {
        return view('404');
    });
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::controller(CountryStateCityController::class)->group(function () {
        Route::get('/country-state-city','index');

        Route::post('/manage-country', 'manageCountry');
        Route::get('/edit-country/{country_id}', 'editCountry');
        Route::get('/delete-country/{country_id}', 'deleteCountry');

        Route::post('/manage-state', 'manageState');
        Route::get('/edit-state/{state_id}', 'editState');
        Route::get('/delete-state/{state_id}', 'deleteState');        

        Route::post('/manage-city', 'manageCity');
        Route::get('/edit-city/{city_id}', 'editCity');
        Route::get('/delete-city/{city_id}', 'deleteCity');

        Route::get('/get-state-by-country/{country_id}', 'getStateByCountry');
        Route::get('/get-city-by-state/{state_id}', 'getCityByState');

    });

    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category', 'index');
        Route::post('/save-category', 'saveCategory');
        Route::get('/edit-category/{category_id}', 'editCategory');
        Route::post('/update-category/{category_id}', 'updateCategory');
        Route::get('/delete-category/{category_id}', 'deleteCategory');
        // Route::post('/orders', 'store');
    });

    Route::controller(SubCategoryController::class)->group(function () {
        Route::get('/sub-category', 'index');
        Route::post('/save-sub-category', 'saveSubCategory');
        Route::get('/edit-sub-category/{sub_category_id}', 'editSubCategory');
        Route::post('/update-sub-category/{sub_category_id}', 'updateSubCategory');
        Route::get('/delete-sub-category/{sub_category_id}', 'deleteSubCategory');

        Route::get('/get-sub-category-by-category/{category_id}', 'getSubCategoryByCategory');
        
    });

    Route::controller(SizeColorController::class)->group(function () {
        Route::get('/size-color', 'index');
        //size
        Route::post('/save-size', 'saveSize');
        Route::get('/edit-size/{size_id}', 'editSize');
        Route::post('/update-size/{size_id}', 'updateSize'); 
        Route::get('/delete-size/{size_id}', 'deleteSize');

        //color
        Route::post('/save-color', 'saveColor');
        Route::get('/edit-color/{color_id}', 'editColor');
        Route::post('/update-color/{color_id}', 'updateColor'); 
        Route::get('/delete-color/{color_id}', 'deleteColor');
    });

    Route::controller(BrandController::class)->group(function () {
        Route::get('/brand','index');
        Route::post('/save-brand','saveBrand');
        Route::get('/edit-brand/{brand_id}','editBrand');
        Route::post('/update-brand/{brand_id}','updateBrand');
        Route::get('/delete-brand/{brand_id}','deleteBrand');

    });

    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customer','index');
        // Route::get('admin/get-customer/{customer_id}','getCustomerData');
        Route::get('/customer-detail/{customer_id}','CustomerDetail');
        // Route::get('admin/get-customer-points/{customer_id}','getCustomerPoints');
        // Route::get('admin/generate-invoice/{customer_id}','generateInvoice');
    });

    // sales invoice 
    Route::controller(CustomerBillInvoiceController::class)->group(function () {
        Route::get('/customer_bill_invoices','index');
        Route::post('/save-order', 'saveOrder');
        Route::get('/get-customer-data/{mobile_no}', 'getCustomerData');
        Route::get('/generate-invoice/{bill_id}','generateInvoice');
    });

    // sales return 
    Route::controller(SalesReturnController::class)->group(function () {
        Route::get('/sales-return', 'index');
        Route::get('/sales-return-item/{bill_no}/{barcode_code}', 'getSalesReturnData');
        Route::get('/get-customer-details/{bill_no}', 'getCustomerDetails');
        Route::post('/save-sales-return-item', 'saveSalesReturnProduct');
        Route::get('/sales-return-invoice/{sales_return_id}','salesReturnInvoice');
        Route::get('/sales_return-status-update/{sales_return_id}', 'updateSalesReturnStatus');
    });

    // supplier 
    Route::controller(SupplierController::class)->group(function () {
        Route::get('/supplier','index');
        Route::post('/save-supplier-order', 'saveSupplier');
        Route::get('/edit-supplier-order/{supplier_id}', 'editSupplier');
        Route::post('/update-supplier-order/{supplier_id}', 'updateSupplier');
        Route::get('/delete-supplier-order/{supplier_id}', 'deleteSupplier');
        Route::get('/supplier-detail/{supplier_id}', 'supplierDetail');
    
        // Route::get('admin/get-state-by-country/{country_id}', 'getStateByCountry');
        // Route::get('admin/get-city-by-state/{state_id}', 'getCityByState');
        // Route::post('admin/manage-city', 'manageCity');
    });

    Route::controller(StyleNoController::class)->group(function () {
        Route::get('/style-no','index');
        Route::get('/style-no-by-supplier/{supplier_id}','styleNoBySupplier');
        Route::post('/save-style-no','manageStyleNo');
        Route::get('/supplier-style-no/{supplier_id}','supplierStyleNo');

        Route::get('/edit-style-no/{style_id}','editStyleNo');
        Route::get('/delete-style-no/{style_no_id}','deleteStyleNo');

    });

    Route::controller(PurchaseEntryController::class)->group(function () {
        Route::get('/purchase-entry', 'index');
        Route::post('/save-purchase-entry', 'savePurchaseEntry');
        Route::get('/edit-purchase-entry/{purchase_entry_id}', 'editPurchaseEntry');
        Route::post('/update-purchase-entry/{purchase_id}/{purchase_entry_id}', 'updatePurchaseEntry');
        Route::get('/get-product-detail/{product_code}', 'getProductDetail');
        Route::get('/get-color_code/{color_code}','getcolorcode');

        // excel file route 
        Route::get('/import-data','importProduct');
        Route::post('/export-excel-data','exportProduct');

        Route::get('/get-purchase-entry/{supplier_id}/{bill_no}','getPurchaseEntry');
        Route::get('/generate-purchase-invoice/{purchase_id}','generatePurchaseInvoice');
        Route::get('/view-purchase-entry/{purchase_id}','viewPurchaseEntry');
        Route::post('/load-pt-file-data','loadPtFileData');
        Route::post('/save-pt-file','savePtFile');

    });

    Route::controller(PurchaseReturnController::class)->group(function () {
        Route::get('/purchase-return', 'index');
        Route::get('/purchase-return-show-data', 'purchaseReturnShowData');
        Route::get('/get-return-product-item/{barcode_code}', 'getReturnData');
        Route::post('/save-return-item', 'saveReturnProduct');
        Route::get('/update-release-status/{supplier}', 'updateReleaseStatus');
        Route::get('/purchase-return-invoice/{purchase_return_id}','purchaseReturnInvoice');
    });

    Route::controller(BarcodeController::class)->group(function () {
        Route::get('/barcode','index');
        Route::get('/filter-barcode/{sub_category_id?}/{brand_id?}/{style_no_id?}/{color?}','filterBarcode');
        Route::get('/barcode-by-purchase-entry/{purchase_entry_id}','getBarcodeByPurchaseEntry');
        Route::get('/barcode-all-purchase-entry/{purchases_id}','getAllBarcodeByPurchaseEntry');
    });

    Route::controller(ManageStockController::class)->group(function () {
        Route::get('/manage-stock', 'index');
        Route::get('/show-product/{category_id}/{sub_category_id?}/{brand_id?}/{style_no_id?}/{color?}','showProduct');
        Route::get('/get-style-no/{style_no_id}','getstyleNo');
    });

    
    Route::get('logout', [AuthController::class, 'logout']);

});

//billing
// Route::group(['middleware'=>'billing_auth'], function(){

//     Route::fallback(function () {
//         return view('404');
//     });

//     Route::get('billing', [BillingController::class, 'index']);

//     Route::controller(CategoryController::class)->group(function () {
//         Route::get('category', 'index');
//     });

//     Route::controller(SizeColorController::class)->group(function () {
//         Route::get('size-color', 'index');
//         Route::post('save-size', 'saveSize');
//         Route::get('edit-size/{size_id}', 'editSize');
//         Route::post('update-size/{size_id}', 'updateSize'); 
//         Route::get('delete-size/{size_id}', 'deleteSize');

//         Route::post('save-color', 'saveColor');
//         Route::get('edit-color/{color_id}', 'editColor');
//         Route::post('update-color/{color_id}', 'updateColor'); 
//         Route::get('delete-color/{color_id}', 'deleteColor');
//     });

//     Route::controller(PurchaseReturnController::class)->group(function () {
//         Route::get('purchase-return', 'index');
        
//     });
   

//     Route::get('logout', [AuthController::class, 'logout']);
// });
