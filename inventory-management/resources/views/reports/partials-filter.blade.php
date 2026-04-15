<form method="GET" action="{{ $action }}">
    <label>From
        <input type="date" name="date_from" value="{{ $dateFrom }}">
    </label>
    <label>To
        <input type="date" name="date_to" value="{{ $dateTo }}">
    </label>
    <button type="submit">Filter</button>
    <a href="{{ $action }}">Reset</a>
</form>
