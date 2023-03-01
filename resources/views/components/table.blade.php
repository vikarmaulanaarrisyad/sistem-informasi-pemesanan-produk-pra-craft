<table {{ $attributes->merge(['class' => 'table table-striped']) }}>
    @isset($thead)
        <thead>
            <tr>
                {{ $thead }}
            </tr>
        </thead>
    @endisset
    <tbody>
        <tr>
            {{ $slot }}
        </tr>
    </tbody>

    @isset($tfoot)
        <tfoot>
            {{ $tfoot }}
        </tfoot>
    @endisset
</table>
