@if ($field->name === 'attachment')
    <?php $isLarge = $forceLarge ?? $field->data->large ?? false; ?>
    <?php
        $attachments = $record->{$field->column};
        $attachmentsCount = $attachments ? count(get_object_vars($attachments)) : 0;
    ?>
    @if ($attachments && $attachmentsCount > 0)
        <span class="badge green white-text" style="border-radius: 10px">{{ $attachmentsCount }}</span>
    @endif
@else
    @include('uccello::modules.default.uitypes.list.text')
@endif