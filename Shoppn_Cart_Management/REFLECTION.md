# Shoppn Cart Management Lab Reflection

## What I learned

I learned how the parts of a small PHP and MySQL application fit together to provide a shopping-cart workflow. The lab uses views for the interface, controllers to connect requests to application logic, and classes to read and update data. I also learned to use prepared SQL statements for database operations and to validate request values before using them.

## How this lab works

This lab is a PHP e-commerce application where visitors can browse and search products, view product details, and add products to a cart. The cart page shows the selected products, quantities, unit prices, and subtotal. It also lets a visitor update quantities or remove items. Product and cart information is read from and written to a MySQL database.

For the cart flow, an action receives a request, the `CartController` passes the operation to `CartClass`, and the class performs database queries. The cart is associated with the visitor's IP address in the current implementation. The views display the resulting data and provide forms for cart changes.

## What was challenging

The challenging part was keeping the cart behavior consistent across the product pages, request-handling actions, database operations, and cart view. For example, a quantity change needs to identify the right product, reject invalid quantities, update the correct cart row, and then show the updated subtotal.

## How I solved the problem

I followed the existing separation between views, controllers, and classes, and traced each cart operation from its form or link through to the database method. I used prepared statements for database queries and validated product IDs and quantities before attempting changes. I also checked that cart feedback and totals were displayed on the cart page.

## One piece of code

In `classes/CartClass.php`, `getCartTotal()` calls `getCartItems()` for the current visitor, then adds each item's quantity multiplied by its product price. This keeps subtotal calculation in the cart class rather than duplicating the calculation in the view. The view can request one total and focus on displaying it.

## Use of AI

I used GitHub Copilot through VS Code (Copilot SDK) as an AI assistant while working on this lab. It helped me review and explain the cart flow and organize this reflection around the lab requirements. I learned that AI can help me explore and communicate an implementation, but I still need to compare suggestions with the actual code and verify that they match what the application does.

## What I would do differently with more time

With more time, I would add automated tests for adding, updating, and removing cart items, including invalid inputs and empty-cart behavior. I would also consider associating carts with a customer account or session instead of only an IP address, since multiple people can share an IP address and one person's address can change.

## Where else I could apply what I learned

I could apply these ideas to other database-backed applications that accept user actions and display changing data, such as a booking system, an inventory tracker, or a saved-items list. The separation between request handling, application logic, data access, and views is useful beyond shopping carts.
