@extends('layouts.app')
@section('content')
<h3>📜 Log Aktivitas</h3>
<table class="table table-striped">
<thead>
    <tr>
        <th>Waktu (WIB)</th>
        <th>Aktivitas</th>
    </tr>
</thead>
<tbody>
@foreach($logs as $log)
<tr>
    <td>{{ \Carbon\Carbon::parse($log->waktu)->timezone('Asia/Jakarta')->format('d M Y H:i:s') }}</td>
    <td>{{ $log->aktivitas }}</td>
</tr>
@endforeach
</tbody>
</table>
@endsection
