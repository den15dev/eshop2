<tr>
    <td>
        <x-stars size="xsmall" :rating="$mark" />
    </td>
    <td>
        <div class="rating-chart-bar">
            <div class="fill" style="width: {{ $max ? round($num * 100 / $max) : 0 }}%"></div>
        </div>
    </td>
    <td class="small">
        @if($num)
            {{ $num }}
        @else
            <span class="lightgrey-text">0</span>
        @endif
    </td>
</tr>
