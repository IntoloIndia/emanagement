<?php
    use Illuminate\Support\facades\DB;
    // use App\Models\Order;
    use App\Models\SubCategory;
    use App\Models\PurchaseEntry;
    use App\Models\Supplier;

    function subCategoryItems($category_id){
        $subCategory_item = SubCategory::where(['category_id'=>$category_id])->get();
        return $subCategory_item; 
    }

    function updateProductStatus($product_id){
        $purchase = PurchaseEntry::find($product_id);
        $purchase->status = MyApp::SOLD;
        $purchase->save();
        return 200; 
    }

    function supplierCode(){
        // $supplier_count = Supplier::count();
        $supplier_count = Supplier::latest()->first()->id;

        $count = $supplier_count + 1 ;
        // $supplier_code = "SH".$count ."D";
        $supplier_code = $count;
        return $supplier_code;
    }


    // function invoiceNo(){
    //     $orders_count = Order::count();
    //     // $orders_count = Order::latest()->first()->id;

    //     $count = $orders_count + 1 ;
    //     $invoice_no = "SH".$count ."D";
    //     return $invoice_no;
    // }

