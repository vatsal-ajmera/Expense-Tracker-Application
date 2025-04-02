<table class="table datatable">
    <thead>
        <tr>
            <th>Sno</th>
            <th>Account</th>
            <th>Spend</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($account_expense as $key => $account)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $account['name'] }}</td>
                <td>₹ {{ $account['total_amount'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>