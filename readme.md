
Hello! 

 There is the screen of the database scheme in the main folder(file task_db.jpg) where you can see all the connections between the tables.

 Product list is available at the route #DOMAIN#/task

 API instructions:
  1.You need to set "Auth" in the header of every request. Value of this header must be a base64_encode combination of the columns "key:secret" from the table 'api_settings'. The seed value are key = 'firstKey', secret = 'aallsskk33'. So basically it looks like base64_encode("firstKey:aallsskk33")= "Zmlyc3RLZXk6YWFsbHNza2szMw". Example of setting the header using the php curl:
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_HTTPHEADER, array(
       "Auth:Zmlyc3RLZXk6YWFsbHNza2szMw==",
  ));
  2. All request must be sent to url 'http://#DOMAIN#/product/add' .
  3. You can set actions in the post parameter "action". You can set:
    1) "addProduct" - to create a new product. Required post fields: name,price. For example:
     curl_setopt($curl, CURLOPT_POSTFIELDS, "name=new product&price=9999.99");
     1) "addProduct" - to create a new product. Required post fields: name,price. For example:
          curl_setopt($curl, CURLOPT_POSTFIELDS, "action=addProduct&name=new product&price=9999.99");

     2) "addVoucher" - to create a new voucher. Required post fields: IDs, start_date, end_date, discount_tiers_id. For example:
           curl_setopt($curl, CURLOPT_POSTFIELDS, "action=addVoucher&IDs=123654789&start_date=2017-06-20&end_date=2017-10-07&discount_tiers_id=3");

     3) "voucherProductBindAdd" - to create a new voucher bind to a product. Required post fields: products_id,vouchers_id. For example:
        curl_setopt($curl, CURLOPT_POSTFIELDS, "action=voucherProductBindAdd&products_id=4&vouchers_id=2");

     4) "voucherProductBindRemove" - to remove a voucher bind to a product. Required post fields: products_id,vouchers_id. For example:
         curl_setopt($curl, CURLOPT_POSTFIELDS, "action=voucherProductBindRemove&products_id=3&vouchers_id=1");

     5) "orderAdd" - to create a new order. Required post fields products_id. For example:
              curl_setopt($curl, CURLOPT_POSTFIELDS, "action=orderAdd&products_id=3");

   4. Request example:
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://#DOMAIN#/product/add');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
             "Auth:Zmlyc3RLZXk6YWFsbHNza2szMw==",
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "action=addProduct&name=new product&price=9999.99");
        $out = curl_exec($curl);
        curl_close($curl);




"# AgileEngine_task" 
