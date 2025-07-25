<div class="form-group">
    <label for="nom">Nom du Pressing</label>
    <input type="text" name="nom" id="nom" class="form-control" value="{{ $pressing->nom ?? old('nom') }}" required>
</div>
<div class="form-group">
    <label for="adresse">Adresse</label>
    <textarea name="adresse" id="adresse" class="form-control">{{ $pressing->adresse ?? old('adresse') }}</textarea>
</div>
