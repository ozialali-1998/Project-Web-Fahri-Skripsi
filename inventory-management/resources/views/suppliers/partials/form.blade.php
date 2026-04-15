<label>Supplier Code <input type="text" name="supplier_code" value="{{ old('supplier_code', $supplier?->supplier_code) }}" required></label><br>
<label>Name <input type="text" name="name" value="{{ old('name', $supplier?->name) }}" required></label><br>
<label>Phone <input type="text" name="phone" value="{{ old('phone', $supplier?->phone) }}"></label><br>
<label>Email <input type="email" name="email" value="{{ old('email', $supplier?->email) }}"></label><br>
<label>Address <textarea name="address">{{ old('address', $supplier?->address) }}</textarea></label><br>
<label>City <input type="text" name="city" value="{{ old('city', $supplier?->city) }}"></label><br>
<label>Contact Person <input type="text" name="contact_person" value="{{ old('contact_person', $supplier?->contact_person) }}"></label><br>
<label>Status
    <select name="is_active" required>
        <option value="1" @selected((string) old('is_active', $supplier?->is_active ?? 1) === '1')>Active</option>
        <option value="0" @selected((string) old('is_active', $supplier?->is_active ?? 1) === '0')>Inactive</option>
    </select>
</label><br>
