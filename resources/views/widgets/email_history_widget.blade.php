<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                {{-- Title --}}
                <span class="card-title">
          {{-- Icon --}}
          <i class="material-icons left primary-text">lock</i>

          {{-- Label --}}
                    {{ trans($label) }}
        </span>

                <div class="row">
                        <ul class="collection">
                            @forelse ($emails as $email)
                            <li class="collection-item avatar">
                                <i class="material-icons circle">email</i>
                                <span class="title">{{ (($email->created_at))->format(config('uccello.format.php.datetime')) }}</span>
                                <p><a class="modal-trigger open-email-modal" href="#email-modal" data-email='{{ json_encode($email) }}' data-date-format="{{ config('uccello.format.js.datetime') }}">{{ $email->subject }}</a> <br>
                                </p>
                            </li>
                    @empty
                           <li class="collection-item">Pas de mail</li>
                    @endforelse
                        </ul>
                <!-- Modal Structure -->
                    <div id="email-modal" class="modal">
                        <div class="modal-content section">
                            <ul class="collection">
                                <li class="collection-item">
                                    <span class="title secondary-content" id="emailCreated_at"></span> <!-- date -->
                                    <p id="emailDestinataire"> <!-- Destinataire -->
                                    </p>
                                </li>
                            </ul>
                            <ul class="collection">
                                <li class="collection-item"><h5></h5></li>
                                <li class="collection-item"><p></p></li>
                            </ul>
                            <div>
                                <span class="secondary-content">Pièce Jointe</span>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <a class="modal-close waves-effect waves-green btn-flat">{{ trans('email-history::widgets.widget.close') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@section('extra-script')
    <script src="{{ mix('/js/app.js', 'vendor/uccello/email-history') }}"></script>
@append

