<div class="modal fade" id="avatars" tabindex="-1" role="dialog" aria-labelledby="avatars" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="avatars">Avatars <small>by <a href="https://twitter.com/RiotIronStylus" target="_blank">IronStylus<a></h4>
            </div>
            <div class="modal-body">
                {{ Form::open(array(
                        'url' => 'profile/avatar',
                        'method' => 'POST',
                        'role' => 'form',
                        'class' => 'form-horizontal',
                        )) }}

                <select name="avatar">
                    <option @if(Auth::user()->avatar=='avatar/ironstylus/draven') selected @endif data-img-src='/img/avatar/ironstylus/draven.jpg' value='avatar/ironstylus/draven'>1</option>
                    <option @if(Auth::user()->avatar=='avatar/ironstylus/diana') selected @endif data-img-src='/img/avatar/ironstylus/diana.jpg' value='avatar/ironstylus/diana'>2</option>
                    <option @if(Auth::user()->avatar=='avatar/ironstylus/ahri') selected @endif data-img-src='/img/avatar/ironstylus/ahri.jpg' value='avatar/ironstylus/ahri'>3</option>
                    <option @if(Auth::user()->avatar=='avatar/ironstylus/galio') selected @endif data-img-src='/img/avatar/ironstylus/galio.jpg' value='avatar/ironstylus/galio'>4</option>
                    <option @if(Auth::user()->avatar=='avatar/ironstylus/leona') selected @endif data-img-src='/img/avatar/ironstylus/leona.jpg' value='avatar/ironstylus/leona'>5</option>
                    <option @if(Auth::user()->avatar=='avatar/ironstylus/sejuani') selected @endif data-img-src='/img/avatar/ironstylus/sejuani.jpg' value='avatar/ironstylus/sejuani'>6</option>
                    <option @if(Auth::user()->avatar=='avatar/ironstylus/sivir') selected @endif data-img-src='/img/avatar/ironstylus/sivir.jpg' value='avatar/ironstylus/sivir'>7</option>
                    <option @if(Auth::user()->avatar=='avatar/ironstylus/soraka') selected @endif data-img-src='/img/avatar/ironstylus/soraka.jpg' value='avatar/ironstylus/soraka'>8</option>
                    <option @if(Auth::user()->avatar=='avatar/ironstylus/thresh') selected @endif data-img-src='/img/avatar/ironstylus/thresh.jpg' value='avatar/ironstylus/thresh'>9</option>
                    <option @if(Auth::user()->avatar=='avatar/ironstylus/twistedfate') selected @endif data-img-src='/img/avatar/ironstylus/twistedfate.jpg' value='avatar/ironstylus/twistedfate'>10</option>
                    <option @if(Auth::user()->avatar=='avatar/ironstylus/zed') selected @endif data-img-src='/img/avatar/ironstylus/zed.jpg' value='avatar/ironstylus/zed'>11</option>                                                        
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
                {{ Form::close() }}
        </div>
    </div>
</div>