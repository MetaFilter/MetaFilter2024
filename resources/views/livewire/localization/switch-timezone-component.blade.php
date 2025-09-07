<div style="display: none;" wire:init="$js.setDisplayTimezone"></div>

@script
<script>
    $js('setDisplayTimezone', () => {
        const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        $wire.setDisplayTimezone(timezone);
    });
</script>
@endscript
