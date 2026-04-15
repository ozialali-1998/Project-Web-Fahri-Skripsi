# Inventory Database Schema (Laravel 10)

This schema uses six core tables:

1. `products`
2. `suppliers`
3. `incoming_goods`
4. `outgoing_goods`
5. `returns`
6. `price_histories`

## Relationship overview

- `incoming_goods.product_id` -> `products.id`
- `incoming_goods.supplier_id` -> `suppliers.id`
- `outgoing_goods.product_id` -> `products.id`
- `returns.product_id` -> `products.id`
- `returns.outgoing_good_id` -> `outgoing_goods.id` (nullable)
- `returns.incoming_good_id` -> `incoming_goods.id` (nullable)
- `price_histories.product_id` -> `products.id`

## Stock tracking logic

Recommended app-level logic:

- Incoming goods: add quantity to `products.stock`.
- Outgoing goods: subtract quantity from `products.stock`.
- Returns:
  - `sales_return` adds stock back.
  - `purchase_return` subtracts stock.

Use database transactions when writing `incoming_goods` / `outgoing_goods` / `returns` plus product stock updates.
