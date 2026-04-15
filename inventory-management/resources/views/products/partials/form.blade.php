<label>SKU <input type="text" name="sku" value="{{ old('sku', $product?->sku) }}" required></label><br>
<label>Name <input type="text" name="name" value="{{ old('name', $product?->name) }}" required></label><br>
<label>Category <input type="text" name="category" value="{{ old('category', $product?->category) }}"></label><br>
<label>Unit <input type="text" name="unit" value="{{ old('unit', $product?->unit ?? 'pcs') }}" required></label><br>
<label>Description <textarea name="description">{{ old('description', $product?->description) }}</textarea></label><br>
<label>Purchase Price <input type="number" step="0.01" name="purchase_price" value="{{ old('purchase_price', $product?->purchase_price ?? 0) }}" required></label><br>
<label>Selling Price <input type="number" step="0.01" name="selling_price" value="{{ old('selling_price', $product?->selling_price ?? 0) }}" required></label><br>
<label>Stock <input type="number" name="stock" min="0" value="{{ old('stock', $product?->stock ?? 0) }}" required></label><br>
<label>Minimum Stock <input type="number" name="minimum_stock" min="0" value="{{ old('minimum_stock', $product?->minimum_stock ?? 0) }}" required></label><br>
<label>Status
    <select name="is_active" required>
        <option value="1" @selected((string) old('is_active', $product?->is_active ?? 1) === '1')>Active</option>
        <option value="0" @selected((string) old('is_active', $product?->is_active ?? 1) === '0')>Inactive</option>
    </select>
</label><br>
