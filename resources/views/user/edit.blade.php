@extends('master')
@section('content')
<div class="container mt-5 col-6 m-auto">
    <h2 class="text-center">Edit User</h2>
    @if(Session::has('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success!</strong> {{ Session::get('success') }}.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      @if(Session::has('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Error!</strong> {{ Session::get('error') }}.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
    {!! Form::model($user, ['route' => ['user.update', $user->id],'class' => 'col-6 m-auto']) !!}
        @csrf
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Name</label>
          {!! Form::hidden('id',$user->id) !!}
          {!! Form::text('name',null,['class' => 'form-control']) !!}
          @error('name')
              <div class="text-danger">* {{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Email address</label>
          {!! Form::text('email',null,['class' => 'form-control','disabled' => 'true']) !!}
        </div>
        @method('PUT')
        {!! Form::submit('Submit',['class' => 'btn btn-primary']) !!}
      {!! Form::close() !!}
</div>

    
    

@endsection