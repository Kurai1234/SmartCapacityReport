
<table>
    <thead>
        <tr>
            <th>
                Access Point Name
            </th>
            <th>
                Mac Address
            </th>
            <th>
                Product
            </th>
            <th>
                Peak Throughput
            </th>
            <th>
                Capacity Throughput
            </th>
            <th>
                Connected Sms
            </th>
            <th>
                Time Stamp
            </th>
        <tr>
    </thead>
    <tbody>
            @foreach ($peakData as $key)
                <tr>
                    <td colspan="2">{{ $key->name }}</td>
                    <td> {{ $key->mac_address }}</td>
                    <td>{{ $key->product }} </td>
                    <td>{{ $key->peak }}</td>
                    <td>{{ $key->dl_capacity_throughput }}</td>
                    <td>{{ $key->connected_sms }}</td>
                    <td>{{ $key->created_at }}</td>
                </tr>
            @endforeach
    </tbody>
</table>

