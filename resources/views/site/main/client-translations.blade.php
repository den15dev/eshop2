<script>
    @php
        $trans_arr = Lang::get('general', [], app()->getLocale());
        $trans_json = json_encode($trans_arr['modal']);
    @endphp
    const trans = {!! $trans_json !!};
</script>