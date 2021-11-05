<table class="table table-sm table-hover text-nowrap" style="font-size: 14px">
    <thead>
    <tr>
        <th style="width: 5%">#</th>
        @if($show_budget)
            <th>Budget</th>
        @endif
        <th>Code</th>
        <th>Type</th>
        <th>Entité</th>
        <th>Rubrique</th>
        <th>Date de création</th>
        <th>Statut</th>
        <th style="width: 5%">Action</th>
    </tr>
    </thead>
    <tbody>
    @forelse($expectations as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>

            @if($show_budget)
                <td>{{ $item->budget_code }}</td>
            @endif
            <td>
                @if($item->user_id != auth()->id())
                    <em>{{ $item->code }}</em>
                @else
                    <strong>{{ $item->code }}</strong>
                @endif
            </td>
            <td>
                {{ $item->group_name }}
            </td>
            <td>{{ $item->entity_code }} ({{ $item->entity_name }})</td>
            <td>{{ $item->account_code }}</td>
            <td>
                {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
            </td>
            <td>
                @if($item->completely_approved)
                    Approuvée
                @elseif($item->status == 0 && $item->availability == 'available')
                    Rejetée
                    @endif
            </td>
            <td><a href="{{ route('expectations.show', $item->code) }}">
                    <span class="fas fa-eye fa-fw"></span>
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8">{{ $message }}!</td>
        </tr>
    @endforelse
    </tbody>
</table>
