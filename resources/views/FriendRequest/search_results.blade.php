@foreach ($users as $user)
    <tr>
        {{-- <td>{{ $user->id }}</td> --}}
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
            @if ($existingRequests->contains($user->email))
                <button type="button" class="btn btn-danger">Request Sent</button>
            @else
                <button type="button" class="btn btn-success" onclick="test('{{ $user->email }}', this)">Send Request</button>
            @endif
        </td>
    </tr>
@endforeach
