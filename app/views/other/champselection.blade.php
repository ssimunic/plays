<?php
$champions = League::getChampions();
?>
<select name="champ" id="champs" class="form-control image-picker show-html">
    <option></option>
    @foreach($champions as $champion)   
    <option data-img-src="/img/champions/squares/{{ Lop::getChampImg($champion) }}Square.png" value="{{ $champion }}" @if(Input::get('champ')==$champion) selected @endif>{{ $champion }}</option>
    @endforeach
</select>