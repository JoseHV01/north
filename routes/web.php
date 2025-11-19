<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{HomeController, AuthenticateController, RecoverAccessController, BillsController, CustomersController, ProvidersController, SalesController, ShoppingController, ReportsController, StockController, CategorysController, RatesController, ShapesPaymentController, CompanyController, BackupController, LogsController, UsersController, StatusController, SessionsController, ProductsController};

// Routes Inauthenticate
Route::middleware(['guest'])->group(function () {
	//Principal
	Route::get('/', [HomeController::class, 'login'])->name('login');

	//Authenticate
	Route::post('/login', [AuthenticateController::class, 'login']);

	// Check Email
	Route::post('/check/email', [RecoverAccessController::class, 'checkEmail']);
	Route::get('/ask', [RecoverAccessController::class, 'askForm']);
	Route::post('/recover/access', [RecoverAccessController::class, 'recoverAccess']);
});

//Routes Authenticate
Route::middleware(['auth'])->group(function () {
    Route::middleware(['verify_session'])->group(function () {
        //Dashboard
        Route::get('/dashboard', [HomeController::class, 'dashboard']);

        //Customers
        Route::middleware(['customers'])->group(function () {
            Route::resource('/customers', CustomersController::class);
            Route::get('customers/search/list', [CustomersController::class, 'searchCustomer']);
        });

        //Providers
        Route::middleware(['providers'])->group(function () {
            Route::resource('/providers', ProvidersController::class);
            Route::get('providers/search/list', [ProvidersController::class, 'searchProvider']);
        });

        //Sales
        Route::middleware(['sales'])->group(function () {
            Route::resource('/sales', SalesController::class);
            Route::get('report/sales', [BillsController::class, 'SalesReports']);
            // Export sales filtered or all
            Route::get('export/sales', [BillsController::class, 'exportSalesPdf']);
            Route::get('/bills/sales', [BillsController::class, 'sales']);
            Route::get('/bills/sales/{id}', [BillsController::class, 'detailsSales']);
        });

        //Shoppings
        Route::middleware(['shoppings'])->group(function () {
            Route::resource('/shopping', ShoppingController::class);
            Route::get('/bills/shopping', [BillsController::class, 'shopping']);
            Route::get('/bills/shopping/{id}', [BillsController::class, 'detailsShopping']);
        });

        //Bills
        Route::group(['prefix' => '/bills'], function(){
            Route::put("cancel/{type}/{id}", [BillsController::class, 'cancelBills']);
            Route::get("pdf/{type}/{id}", [BillsController::class, 'generatePdfBills']);
            Route::put("change/{type}/{id}", [BillsController::class, 'changeStateOperation']);
            Route::get("search/{type}", [BillsController::class, 'searchBills']);
        });

        //Rate BCV
        Route::put("changebcv", [RatesController::class, 'changeBCV']);

        //Products
        Route::middleware(['products'])->group(function () {
            Route::resource('/products', ProductsController::class);
            Route::get("products/search/list", [ProductsController::class, 'searchProduct']);
            Route::get('export/products', [ProductsController::class, 'exportProductsPdf']);
        });
        Route::post('/sales/search', [SalesController::class, 'search']);
        Route::post('/shopping/list/search', [ShoppingController::class, 'search']);

        //Users
        Route::get('/profile', [UsersController::class, 'loadProfile']);
        Route::post('/change/email', [UsersController::class, 'changeEmail']);
        Route::post('/change/password', [UsersController::class, 'changePassword']);
        Route::post('/change/asks/security', [UsersController::class, 'changeAsks']);

        Route::middleware(['admin'])->group(function () {
            //Reports
            Route::get('/reports', [ReportsController::class, 'index']);

            // Reports table for products more sale
            Route::get('/reports-table/{year}/{month}', [ReportsController::class, 'productMoreSale']);

            //Exportaciones a PDF de los reportes
            Route::get('export/products-more-sale/{year}/{month}', [ReportsController::class, 'exportProductsMoreSale']);
            Route::get('export/transaction/{year}/{month}', [ReportsController::class, 'exportTransactionsPdf']);
            Route::get('export/operations-volume/{year}', [ReportsController::class, 'exportOperationsPdf']);
           
            // Export PDF: lista de providers/customers (filtrable)
            Route::get('export/providers', [ProvidersController::class, 'exportProvidersPdf']);
            Route::get('export/customers', [CustomersController::class, 'exportCustomersPdf']);

            // Reports charts
            Route::get('/reports-distribution/{year}/{month}', [ReportsController::class, 'distributionTransaction']);

            // pendiente
            Route::get('/reports-operations/{year}', [ReportsController::class, 'queryOperations']);
            
            

            //Stock
            Route::get('/stock', [StockController::class, 'index']);

            //Categorys
            Route::resource('/categorys', CategorysController::class);

            //Rates
            Route::resource('/rates', RatesController::class);
            Route::put('change/status/rates/{id}', [RatesController::class, 'changeStatus']);

            //Shpaes Payment
            Route::resource('/shapes_payment', ShapesPaymentController::class);

            //Company
            Route::get('/company', [CompanyController::class, 'index']);
            Route::post('/company', [CompanyController::class, 'store']);

            //Backup DB
            Route::get('/backup/db', [BackupController::class, 'index']);

            //Logs
            Route::get('/logs', [LogsController::class, 'index']);
            Route::get('/logs/search', [LogsController::class, 'searchLogs']);

            //Users
            Route::resource('/users', UsersController::class);
            Route::post('/user/status/{id}', [UsersController::class, 'changeStatus']);
            Route::post('/user/permissions/{id}', [UsersController::class, 'changePermissions']);
        });

        //ChangeStatusRegister
        Route::put('/change/status/{type}/{id}', [StatusController::class, 'update']);

        // Extend Session
        Route::post('/extend-session', [SessionsController::class, 'generateSession']);

        //Authenticate
        Route::get('/logout', [AuthenticateController::class, 'logout']);
    });
});

Route::get('/home', [AuthenticateController::class, 'logout'])->name('home');
