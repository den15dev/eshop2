<p class="small grey-text">
    {{ __('pagination.shown', ['start' => 1, 'end' => 12, 'total' => 18]) }}
</p>

<nav class="mb-3" id="pagination">
    <ul class="pagination">
        <li class="page-item disabled">
            <span class="page-link">&lsaquo;</span>
        </li>
        <li class="page-item active">
            <span class="page-link">1</span>
        </li>
        <li class="page-item">
            <a class="page-link dark-link" href="#">2</a>
        </li>
        <li class="page-item">
            <a class="page-link dark-link" href="#">3</a>
        </li>
        <li class="page-item">
            <a class="page-link dark-link" href="#">4</a>
        </li>
        <li class="page-item">
            <a class="page-link dark-link" href="#" rel="next">&rsaquo;</a>
        </li>
    </ul>
</nav>