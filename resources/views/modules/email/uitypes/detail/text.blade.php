@if ($field->name === 'attachment')
    <?php $isLarge = $forceLarge ?? $field->data->large ?? false; ?>
    <div class="col m2 s5 field-label">
        <?php $label = uctrans($field->label, $module); ?>
        <b title="{{ $label }}">{{ $label }}</b>
    </div>
    <div class="col {{ $isLarge ? 's7 m10' : 's7 m4' }}">
        @if ($record->{$field->column} && is_array($record->{$field->column}))
            @foreach ($attachments as $fileName => $filePath)
                <div class="truncate">
                    <a href="{{ ucroute('email_history.attachment.download', $domain, $module, [ 'id' => $record->getKey(), 'file' => $fileName ]) }}"
                        title="{{ uctrans('button.download_file', $module) }}"
                        class="primary-text">{{ $fileName }}</a>
                </div>
            @endforeach
        @else
            &nbsp;
        @endif
    </div>
@else
    @include('uccello::modules.default.uitypes.detail.textarea')
@endif