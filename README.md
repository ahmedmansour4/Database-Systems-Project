# Amazoff – An Online Discount Store
> COP4710 Project - Spring 2020

## The Company

The Amazoff team owns an online store selling selected products available at Amazon.com. Amazon gives us large volume discounts when your company purchases products in large quantities. The discount is proportional to the purchase volume. We need only forward the orders from our customers; and Amazon takes care of all the logistics including shipping and accounting. At the end of each month, Amazon sends our company a check for the total discount amount we have earned for the month. Pretty sweet deal!

## The Online Store
- Potential customers may visit our store to browse the products.
- When a customer is interested in an item, she may request a discount code for this item. She can then organize a buying group by sharing this discount code with her friends and family. Each discount code expires in seven days.
- Customers can apply a discount code, issued by Amazoff, towards their purchase. The exact discount for an order, calculated at the time the discount code expires, depends on the total number of times this discount code has been used by the group members, i.e., a larger buying group earns a larger discount. You want to encourage larger buying groups in order to get better volume discounts from Amazon.
- At the end of each day, we run the software to look up any discount codes about to expire and compute the final discount percentage for the respective customers (who have used this discount code over the seven-day period). Note that the exact discount could not be determined at the time of placing the order.

## The Project

Use only the programming environments discussed in class to develop an online database application to support your discount store. There are two primary components: (1) the Storefront for selling products, and (2) the Store Management System (SMS) for managing the store activities.

### Storefront

The software allows the customer to browse the products listed in one single page (for simplicity). The store can take orders and record the typical purchase information such as name, address, and credit card information. It also creates distinct discount codes upon request and manages information about the buying groups. For simplicity, you can assume that each order contains only one item and a unique order number is created. This number can be used later to look up the discount for the purchased item after the discount code has expired.

### Store Management System

This subsystem allows you to add or remove items from your store. You can also set the discount policy to specify how the final group-buy discounts should be computed. When a discount code expires, you can print out the list of orders associated with this discount code and forward it to Amazon.com through the Post Office. For a newly created discount code, you want SMS to be able to identify former customers who might be interested in the given product. This allows you to contact them (not through this application) to promote the product by offering the same discount code.

## Extra Credit

The design as described above is intentionally simplified to leave room for innovations. Individual students may add creative features to make the store more user friendly and/or improve the business model to make the company more profitable. These students should make an appointment to demonstrate the extra effort before May 2nd , 2020 for extra credits.

## Project Diagram

```
+----------------------------------------------------------------+
|                                                                |
|                           AMAZOFF.FUN                          |
|                                                                |
|      +-------------------+           +-------------------+     |
|      |     Storefront    |           |        SMS        |     |
|      +-------------------+           +-------------------+     |
|      | Used by Customers |           | Used by Employees |     |
|      +-------------------+           +-------------------+     |
|      |  www.amazoff.fun  |           |  sms.amazoff.fun  |     |
|      +-------------------+           +-------------------+     |
|      |    Stack: LAMP    |           |    Stack: LAMP    |     |
|      +-------------------+           +-------------------+     |
|      |      Ahmed        |           |      Connor       |     |
|      |      Jason        |           |        Gus        |     |
|      +-------------------+           +-------------------+     |
|                                                                |
+----------------------------------------------------------------+


```