<form method="POST" action='{{url("/uploads/$id")}}' enctype="multipart/form-data">
    @csrf
    @method('put')
    <input type="file" name="upload">
    <input type="submit" value="Change Upload">
</form>
@if( ! empty($id) )	
    <br>
    <a href="{{url('/uploads',[$id,$originalName])}}">{{ $id }} {{$originalName}}</a>
    <br>
    @if(substr($mimeType, 0, 5) == 'image')
        <img height="25%" width="25%" src='{{url('/uploads',[$id,$originalName])}}'>
        <br>
    @endif
@endif
<a href="{{url('/uploads')}}">uploads</a>
@isset($id) 
{{ $id }} <br> {{ $path }} <br> {{ $originalName }} <br> {{ $mimeType }}
@endisset
