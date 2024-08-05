<div wire:ignore
    class="mt-2"
    x-cloak
    x-init="() => {
        const pond = FilePond.create($refs.{{ $attributes->get('ref') ?? 'input' }});

        this.addEventListener('pondReset', e => {
            pond.removeFiles();
        });

        pond.setOptions({
            allowMultiple: {{ $attributes->has('multiple') ? 'true' : 'false' }},
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    @this.upload('{{ $attributes->whereStartsWith('wire:model')->first() }}', file, load, error, progress)
                },
                revert: (filename, load) => {
                    @this.removeUpload('{{ $attributes->whereStartsWith('wire:model')->first() }}', filename, load)
                },
            },
            allowImagePreview: {{ $attributes->has('allowImagePreview') ? 'true' : 'false' }},
            imagePreviewMaxHeight: {{ $attributes->has('imagePreviewMaxHeight') ? $attributes->get('imagePreviewMaxHeight') : '256' }},
            allowFileTypeValidation: {{ $attributes->has('allowFileTypeValidation') ? 'true' : 'false' }},
            acceptedFileTypes: {!! $attributes->get('acceptedFileTypes') ?? 'null' !!},
            allowFileSizeValidation: {{ $attributes->has('allowFileSizeValidation') ? 'true' : 'false' }},
            maxFileSize: {!! $attributes->has('maxFileSize') ? "'" . $attributes->get('maxFileSize') . "'" : 'null' !!},
            labelIdle: '{{ $attributes->has('multiple') ? "Arrastra y suelta tus archivos o examina" : "Arrastra y suelta tu archivo o examina" }}',
            labelInvalidField: 'El campo contiene archivos inválidos',
            labelFileWaitingForSize: 'Esperando tamaño',
            labelFileSizeNotAvailable: 'Tamaño no disponible',
            labelFileLoading: 'Cargando',
            labelFileLoadError: 'Error durante la carga',
            labelFileProcessing: 'Cargando',
            labelFileProcessingComplete: 'Carga completa',
            labelFileProcessingAborted: 'Carga cancelada',
            labelFileProcessingError: 'Error durante la carga',
            labelFileProcessingRevertError: 'Error durante la reversión',
            labelFileRemoveError: 'Error durante la eliminación',
            labelTapToCancel: 'toca para cancelar',
            labelTapToRetry: 'tocar para volver a intentar',
            labelTapToUndo: 'tocar para deshacer',
            labelButtonRemoveItem: 'Eliminar',
            labelButtonAbortItemLoad: 'Abortar',
            labelButtonRetryItemLoad: 'Reintentar',
            labelButtonAbortItemProcessing: 'Cancelar',
            labelButtonUndoItemProcessing: 'Deshacer',
            labelButtonRetryItemProcessing: 'Reintentar',
            labelButtonProcessItem: 'Cargar',
            labelMaxFileSizeExceeded: 'El archivo es demasiado grande',
            labelMaxFileSize: 'El tamaño máximo del archivo es {filesize}',
            labelMaxTotalFileSizeExceeded: 'Tamaño total máximo excedido',
            labelMaxTotalFileSize: 'El tamaño total máximo del archivo es {filesize}',
            labelFileTypeNotAllowed: 'Archivo de tipo no válido',
            fileValidateTypeLabelExpectedTypes: 'Espera {allButLastType} o {lastType}',
            imageValidateSizeLabelFormatError: 'Tipo de imagen no compatible',
            imageValidateSizeLabelImageSizeTooSmall: 'La imagen es demasiado pequeña',
            imageValidateSizeLabelImageSizeTooBig: 'La imagen es demasiado grande',
            imageValidateSizeLabelExpectedMinSize: 'El tamaño mínimo es {minWidth} × {minHeight}',
            imageValidateSizeLabelExpectedMaxSize: 'El tamaño máximo es {maxWidth} × {maxHeight}',
            imageValidateSizeLabelImageResolutionTooLow: 'La resolución es demasiado baja',
            imageValidateSizeLabelImageResolutionTooHigh: 'La resolución es demasiado alta',
            imageValidateSizeLabelExpectedMinResolution: 'La resolución mínima es {minResolution}',
            imageValidateSizeLabelExpectedMaxResolution: 'La resolución máxima es {maxResolution}',
        });
    }">
    <input type="file" x-ref="{{ $attributes->get('ref') ?? 'input' }}" />
</div>
