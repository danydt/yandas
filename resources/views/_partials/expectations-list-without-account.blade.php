<table class="table table-sm table-hover">
    <thead>
    <tr>
        <th style="width: 5%">#</th>
        <th>Code</th>
        <th>Budget</th>
        <th>Entité</th>
        <th style="width: 5%">Action</th>
    </tr>
    </thead>
    <tbody>
    @forelse($expectations as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->code }}</td>
            <td>{{ $item->budget_code }}</td>
            <td>{{ $item->entity->name }}</td>
            <td><a href="{{ route('expectations.show', $item->code) }}">
                    <span class="fas fa-eye fa-fw"></span>
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5">Aucune prévision !</td>
        </tr>
    @endforelse
    </tbody>
</table>
