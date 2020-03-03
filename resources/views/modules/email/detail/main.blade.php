@extends('uccello::modules.default.detail.main')

@section('content')
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">
                    {{ $record->subject }}
                    @if ($record->sent_at)
                    <small class="right right-align" style="line-height: 1rem;">
                        {{ $record->sent_at->format(config('uccello.format.php.datetime')) }}<br>

                        {{-- To --}}
                        {{ uctrans('field.to', $module)}} {{ $record->to }}

                        {{-- CC --}}
                        @if ($record->cc)
                        |  {{ uctrans('field.cc', $module)}} {{ $record->cc }}
                        @endif

                        {{-- BCC --}}
                        @if ($record->bcc)
                        |  {{ uctrans('field.bcc', $module)}} {{ $record->bcc }}
                        @endif
                    </small>
                    @endif

                    @if ($record->user)
                    <small>{{ $record->user->recordLabel }} &lt;{{ $record->user->email }}&gt;</small>
                    @endif
                </span>


                <p>{{ $record->body }}</p>
            </div>
            @if (!empty($record->attachment))
            <div class="card-action right-align">
                @foreach ((array) $record->attachment as $fileName => $filePath)
                <a href="{{ ucroute('email_history.attachment.download', $domain, $module, [ 'id' => $record->getKey(), 'file' => $fileName ]) }}"
                    title="{{ uctrans('button.download_file', $module) }}"
                    class="primary-text">{{ $fileName }}</a>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection