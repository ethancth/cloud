<div class="container">
  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="file">Choose Excel File</label>
      <input type="file" name="file" id="file" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Import</button>
  </form>
</div>
