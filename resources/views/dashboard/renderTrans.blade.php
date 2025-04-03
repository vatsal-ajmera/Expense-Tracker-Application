<table class="table datatable " id="transactions-table">
    <thead>
        <tr>
            <th>Sno</th>
            <th>Account</th>
            <th>Category</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($recent_transations as $key => $transaction)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $transaction->account->name }}</td>
                <td>{{ $transaction->category->category_name }}</td>
                <td>{{ $transaction->amount }}</td>
            </tr>
        @endforeach
        
    </tbody>
</table>