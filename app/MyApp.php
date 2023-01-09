<?php
namespace App;

class MyApp {
    const SITE_NAME = 'E-Management';

    const ADMINISTRATOR = 1;
    const BILLING = 2;
    const OTHER = 3;

    const ACTIVE = 1;
    const USED = 2;
    const DEACTIVE = 3;
    const INACTIVE = 0;

    const PENDING = 0;
    const PICK_UP = 1;
    const READY = 2;
    const SERVED = 3;

    const ONLINE = 1;
    const CASH = 2;
    const CARD = 3;
    const CREDIT = 4;

    const KG = 1;
    const LITER = 2;
    const PCS =3;
    
    const READY_MADE = 6;

    const STATUS = 0;

    const INDIA = 1;
    
    const COUNTRY = 1;
    const STATE = 2;
    const CITY = 3;

    const AVAILABLE = 0;
    const SOLD = 1;
    const RETURN = 2;

    const WITH_IN_STATE = 1;
    const INTER_STATE = 2;
    const THOUSAND = 1000;

    const NORMAL_SIZE = 1;
    const KIDS_SIZE = 2;
    const WITHOUT_SIZE = 3;
    
    const DELIVERY = 1;
    const IMPORT_CSV_FILE = 1;
   
    const RELEASE_STATUS = 1;
    const RELEASE_PANDDING_STATUS = 0;
    const SILVER_AMOUNT = 300000;
    const GOLDEN_AMOUNT = 500000;
    const SILVER = 'SILVER';
    const GOLDEN = 'GOLDEN';
    const PLATINUM = 'PLATINUM';

    // const PURCHASE_ENTRY = 'PURCHASE_ENTRY';
    // const UPDATE_PURCHASE_ENTRY = 'PURCHASE_ENTRY';
    // const PURCHASE_RETURN = 'PURCHASE_RETURN';
    // const SALES_INVOICE = 'SALES_INVOICE';
    // const SALES_RETURN = 'SALES_RETURN';

    const PLUS_MANAGE_STOCK = 'PLUS_MANAGE_STOCK';
    const MINUS_MANAGE_STOCK = 'MINUS_MANAGE_STOCK';

}