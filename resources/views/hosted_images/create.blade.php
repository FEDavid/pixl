<form method="POST" action="{{ route('uploads.store') }}" enctype="multipart/form-data">
    @csrf

    <input type="file" name="hostedImage">

    <button type="submit">Upload Image</button>
</form>
