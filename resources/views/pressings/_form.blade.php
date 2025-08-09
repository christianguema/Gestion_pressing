<div class="flex items-center justify-center min-h-screen bg-gray-100 card">
    <div class="card-body">
        <div class="form-group">
            <label for="nom">Nom du Pressing</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ $pressing->nom ?? old('nom') }}"
                required>
        </div>
        <div class="form-group">
            <label for="adresse">Adresse</label>
            <textarea name="adresse" id="adresse"
                class="form-control">{{ $pressing->adresse ?? old('adresse') }}</textarea>
        </div>
    </div>
</div>
