# Inventory System Blackbox Testing Scenarios

This document defines blackbox test scenarios for the Laravel inventory system.

## A. Functional Blackbox Test Scenarios

| ID | Feature | Scenario Type | Preconditions | Test Steps | Test Data | Expected Result |
|---|---|---|---|---|---|---|
| BB-001 | Product CRUD | Valid input | Admin is logged in | Open Products > Add Product > Fill required fields > Save | SKU: `PRD-001`, Name: `Keyboard`, Unit: `pcs`, Purchase: `100000`, Selling: `150000`, Stock: `10` | Product saved successfully, appears in product list |
| BB-002 | Product CRUD | Invalid input | Admin is logged in | Create product with empty required fields | SKU empty, Name empty | Validation errors shown for required fields; data not saved |
| BB-003 | Product CRUD | Edge case | Product `PRD-001` exists | Try creating another product with same SKU | SKU: `PRD-001` | Validation error for duplicate SKU |
| BB-004 | Supplier CRUD | Valid input | Admin is logged in | Open Suppliers > Add Supplier > Save | Code: `SUP-001`, Name: `PT Sumber Makmur` | Supplier saved successfully |
| BB-005 | Supplier CRUD | Invalid input | Admin is logged in | Add supplier with invalid email | Email: `supplier-at-mail` | Email format validation error; record not saved |
| BB-006 | Incoming Goods | Valid input | Product stock = 10, supplier exists | Open Incoming Goods > Select product/supplier > Qty 5 > Save | Qty: `5`, Unit Cost: `120000` | Incoming transaction saved; stock increases from 10 to 15 |
| BB-007 | Incoming Goods | Invalid input | Admin is logged in | Submit incoming goods with quantity 0 | Qty: `0` | Validation error (`min:1`); no stock update |
| BB-008 | Incoming Goods | Edge case | Product stock = 10 | Submit incoming goods with large quantity | Qty: `1000000` | Transaction saved; stock updates correctly without overflow in normal DB integer range |
| BB-009 | Outgoing Goods (Sales) | Valid input | Product stock = 15 | Open Outgoing Goods > Select product > Qty 3 > Discount 10% > Save | Qty: `3`, Discount type: `%`, Discount value: `10` | Outgoing transaction saved; total computed correctly; stock decreases to 12 |
| BB-010 | Outgoing Goods (Sales) | Invalid input | Product stock = 12 | Submit outgoing goods with negative discount | Discount value: `-5` | Validation error (`min:0`); no transaction saved |
| BB-011 | Outgoing Goods (Sales) | Edge case | Product stock = 2 | Submit outgoing goods qty greater than stock | Qty: `3` | Error shown: insufficient stock; no stock change |
| BB-012 | Return | Valid input | Product stock = 12 | Open Returns > Select product > Qty 2 > Add note > Save | Qty: `2`, Note: `Customer return` | Return saved; stock increases to 14 |
| BB-013 | Return | Invalid input | Admin is logged in | Submit return with no product | Product empty | Validation error for required product |
| BB-014 | Return | Edge case | Product stock = 14 | Submit return with very long note text | Note length > 500 chars | Data accepted if within DB/text limits, saved without truncation error |
| BB-015 | Stock History | Valid input | Perform one incoming transaction | Complete incoming save | Qty: 5 | New stock history row created with `change_type=in`, correct before/after stock |
| BB-016 | Reporting - Stock | Valid input | Transactions exist | Open Reports > Stock > Filter by date range | date_from/date_to valid | Table displays only data in range and correct net change |
| BB-017 | Reporting - Incoming History | Invalid input | Admin is logged in | Set invalid date format in URL query | `date_from=2026-99-99` | Validation error response; page does not crash |
| BB-018 | Reporting - Outgoing History | Edge case | No outgoing transaction in selected range | Filter date with empty result window | date_from/date_to range with no data | Empty-state row shown: no outgoing records found |

## B. Cross-Feature Edge Case Scenarios

| ID | Scenario | Steps | Expected Result |
|---|---|---|---|
| BB-019 | Rapid double submit on outgoing form | Click submit twice quickly | Either one transaction is created or handled safely; stock should not become inconsistent |
| BB-020 | Concurrent outgoing requests on same product | Run two outgoing submits in parallel for low stock product | One may succeed, the other should fail due to insufficient stock; final stock not negative |
| BB-021 | Date filter boundary | Filter with same `date_from` and `date_to` | Only records on that exact date appear |
| BB-022 | Decimal price precision | Save outgoing with price containing decimals | Total/discount calculations stored with correct 2-decimal precision |

## C. SEQ (Single Ease Question) Usability Question Examples

Use this prompt after each task:

> **"Overall, how difficult or easy was this task to complete?"**
> Scale: **1 (Very difficult) to 7 (Very easy)**

| Task ID | User Task | SEQ Question | Follow-up (Optional) |
|---|---|---|---|
| SEQ-01 | Add a new product | How easy was it to add a new product? (1-7) | Which field, if any, was confusing? |
| SEQ-02 | Record incoming goods | How easy was it to record incoming goods? (1-7) | Was selecting product/supplier clear? |
| SEQ-03 | Record outgoing goods with discount | How easy was it to complete a sale with discount? (1-7) | Was total price calculation easy to understand? |
| SEQ-04 | Record a return | How easy was it to submit a return transaction? (1-7) | Did the stock impact feel clear? |
| SEQ-05 | Find stock report for a date range | How easy was it to filter stock report by date? (1-7) | Was the date filter placement obvious? |
| SEQ-06 | Find outgoing history report | How easy was it to review outgoing goods history? (1-7) | Did table columns provide enough detail? |

## D. Suggested Acceptance Criteria

| Area | Acceptance Criteria |
|---|---|
| Validation | Required fields must reject blank/invalid values with clear messages |
| Stock Integrity | Stock must never become negative on outgoing transactions |
| Stock Audit | Every stock-changing transaction must generate a stock history record |
| Reporting | Date filters must return correct subset or empty-state table |
| Usability | Average SEQ score target >= 5.5 for core transaction tasks |
