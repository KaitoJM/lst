@extends('admin._templates.main_tpl')

@section('main_content')
<form action="{{ route('admin.user.update', [$user->id]) }}" method="post" enctype="multipart/form-data">
@csrf
    <div>
        <label for="">Name</label>
        <input type="text" name="fname" value="{{$user->fname}}" />
    </div>
    <div>
        <label for="">Last Name</label>
        <input type="text" name="lname" value="{{$user->lname}}" />
    </div>
    <div>
        <label for="">Email</label>
        <input type="text" name="email" value="{{$user->email}}" />
    </div>
    <div>
        <label for="">Type</label>
        <select name="type">
            <option value="normal" {{ ($user->type=='normal')  ? 'selected' : ''}}>Normal</option>
            <option value="finance" {{ ($user->type=='finance')  ? 'selected' : ''}}>Finance</option>
        </select>
    </div>
    <div>
        <label for="">Photo</label>
        <input type="file" name="photo"/>
    </div>
    <button type="submit">Save</button>
</form>
@endsection