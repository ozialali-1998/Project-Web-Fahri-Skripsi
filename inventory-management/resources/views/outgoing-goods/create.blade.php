@extends('layouts.app')

@section('content')
<h1>Outgoing Goods (Sales) Transaction</h1>

<nav>
    <a href="{{ route('products.index') }}">Products</a> |
    <a href="{{ route('suppliers.index') }}">Suppliers</a> |
    <a href="{{ route('incoming-goods.create') }}">Incoming Goods</a>
</nav>

@if(session('status'))
    <p>{{ session('status') }}</p>
@endif

@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('outgoing-goods.store') }}" id="outgoing-form">
    @csrf
    <label>Reference Number
        <input type="text" name="reference_number" value="{{ old('reference_number') }}" required>
    </label><br>

    <label>Product
        <select name="product_id" id="product_id" required>
            <option value="">-- Select Product --</option>
            @foreach($products as $product)
                <option
                    value="{{ $product->id }}"
                    data-price="{{ $product->selling_price }}"
                    data-stock="{{ $product->stock }}"
                    @selected((string) old('product_id') === (string) $product->id)
                >
                    {{ $product->sku }} - {{ $product->name }} (Stock: {{ $product->stock }})
                </option>
            @endforeach
        </select>
    </label><br>

    <label>Unit Price
        <input type="number" id="unit_price_preview" step="0.01" readonly>
    </label><br>

    <label>Quantity
        <input type="number" name="quantity" id="quantity" min="1" value="{{ old('quantity', 1) }}" required>
    </label><br>

    <label>Discount Type
        <select name="discount_type" id="discount_type" required>
            <option value="none" @selected(old('discount_type') === 'none')>None</option>
            <option value="nominal" @selected(old('discount_type') === 'nominal')>Nominal</option>
            <option value="percentage" @selected(old('discount_type') === 'percentage')>Percentage</option>
        </select>
    </label><br>

    <label>Discount Value
        <input type="number" step="0.01" name="discount_value" id="discount_value" value="{{ old('discount_value', 0) }}" min="0" required>
    </label><br>

    <label>Calculated Total Price
        <input type="number" id="total_price_preview" step="0.01" readonly>
    </label><br>

    <label>Customer Name
        <input type="text" name="customer_name" value="{{ old('customer_name') }}">
    </label><br>

    <label>Sold At
        <input type="datetime-local" name="sold_at" value="{{ old('sold_at') }}" required>
    </label><br>

    <label>Notes
        <textarea name="notes">{{ old('notes') }}</textarea>
    </label><br>

    <button type="submit">Save Outgoing Goods</button>
</form>

<h2>Recent Outgoing Goods</h2>
<table border="1" cellpadding="8">
    <thead>
    <tr>
        <th>Reference</th>
        <th>Product ID</th>
        <th>Qty</th>
        <th>Discount</th>
        <th>Total Price</th>
    </tr>
    </thead>
    <tbody>
    @forelse($recentOutgoingGoods as $item)
        <tr>
            <td>{{ $item->reference_number }}</td>
            <td>{{ $item->product_id }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->discount_amount }}</td>
            <td>{{ $item->total_price }}</td>
        </tr>
    @empty
        <tr><td colspan="5">No transactions yet.</td></tr>
    @endforelse
    </tbody>
</table>

<script>
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    const discountTypeInput = document.getElementById('discount_type');
    const discountValueInput = document.getElementById('discount_value');
    const unitPricePreview = document.getElementById('unit_price_preview');
    const totalPricePreview = document.getElementById('total_price_preview');

    function recalculate() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const unitPrice = parseFloat(selectedOption?.dataset?.price || 0);
        const quantity = parseFloat(quantityInput.value || 0);
        const discountType = discountTypeInput.value;
        const discountValue = parseFloat(discountValueInput.value || 0);

        const subtotal = unitPrice * quantity;
        let discountAmount = 0;

        if (discountType === 'percentage') {
            discountAmount = subtotal * discountValue / 100;
        } else if (discountType === 'nominal') {
            discountAmount = discountValue;
        }

        const total = Math.max(subtotal - discountAmount, 0);

        unitPricePreview.value = unitPrice.toFixed(2);
        totalPricePreview.value = total.toFixed(2);
    }

    productSelect.addEventListener('change', recalculate);
    quantityInput.addEventListener('input', recalculate);
    discountTypeInput.addEventListener('change', recalculate);
    discountValueInput.addEventListener('input', recalculate);

    recalculate();
</script>
@endsection
