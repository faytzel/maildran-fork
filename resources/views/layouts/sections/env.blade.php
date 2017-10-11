<script>
    window.Laravel = {!! json_encode([
        'version'       => app_version(),
        'csrfToken'     => csrf_token(),
        'navigatorAjax' => navigator_ajax($exception),
        'routes'        => [
            'legal.cookie' => route('legal.cookie'),
        ]
    ]) !!};
</script>
