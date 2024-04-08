@if ($data)

    @php
        $i = 1;
    @endphp
    @foreach ($data as $item)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $item->nama_pelajaran }}</td>
            <td>
                <button type="button" class="btn btn-outline-secondary" data-toggle="modal"
                    data-target="#editUserModal{{ $item->id }}">
                    Edit
                </button>

                <form action="{{ route('mata-pelajaran.destroy', ['mata_pelajaran' => $item->id]) }}" method="POST"
                    style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-secondary" type="submit"
                        onclick="return confirm('Anda yakin ingin menghapus data ini?')">Delete</button>
                </form>
            </td>
        </tr>
        @php
            $i++;
        @endphp
    @endforeach
@else
    <p class="text-danger text-center">Data tidak ditemukan</p>
@endif
