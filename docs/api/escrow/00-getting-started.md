# How our Escrow API works

Our Escrow API allows you to create LipaSafe transactions directly from your shopping website. You simply add a button on your website that your customers can click to buy from you through LipaSafe.

Our implementation is based purely on HTTP **POST**, so it should be swift and simple to hook up your website.

# Getting your shop ID
Before you start the integration, you must retrieve your shop ID from the [LipaSafe Developer Centre](https://lipasafe.com/developer/home). If you have not created a shop, [click here for instructions](https://help.lipasafe.com/api/creating-a-shop/)

1. Login to your LipaSafe account
2. Click on **Developer Centre** in the dropdown at the top right corner of your screen
3. Click **View** on the shop you want
4. You will see the shop ID among the displayed fields. Copy is somewhere safe

# Integrating your website
To start using the Escrow API, you must add an HTML POST form on your checkout page. This form should contain all the required fields as specified in this document.

The `action` property of the form should point to:-

!!! info ""
    https://lipasafe.com/api/escrow/create

This form will require the following fields:-

* `shop_id` - use the shop ID you retrieved in the previous step

* `role` - this field is always set to `SELLER` because your e-commerce application is selling to the visitor. The usage of this field will be expanded with future updates

* `product` - name of the item you are selling. Max length is 255 characters, extra characters will be truncated

* `price` - how much does the product cost? Value should be Ksh 100 and Ksh 70,000

* `customer_telephone` - your customer's telephone number. If your customer is not registered with LipaSafe, he/she has to register and verify their number before depositing money.

* `description` - more Information about this product

!!! hint
    Your e-commerce website should allow the customer to provide their telephone number (preferably a registered M-PESA number) in your website so you can attach it on the `customer_telephone` field when sending your **POST** request to LipaSafe.

# Code sample

``` html
<form action="https://lipasafe.com/api/escrow/create" method="POST" target="_blank">
    <!-- Get the account_no from your LipaSafe profile -->
    <input type="hidden" name="shop_id" value="[SHOP ID]">
    <!-- Will always be SELLER for now -->
    <input type="hidden" name="role" value="SELLER">
    <!-- Max 255 characters -->
    <input type="hidden" name="product" value="Apple iPhone 6">
    <!-- Float -->
    <input type="hidden" name="price" value="11000">
    <!-- Must be in 0700123456 format -->
    <input type="hidden" name="telephone" value="07001234565">
    <input type="hidden" name="description" value="Description here">
    <button type="submit">Buy with LipaSafe</button>
</form>
```
> The form sends a **POST** request to the API endpoint with HTTP data that describes the purchase

!!! tip "User Experience Tip"
    It is recommended to keep the ` target="_blank"` tag so that your customer's shopping experience is not diverted
