@extends('master') 
@section('content')
<div class="container d-flex justify-content-between mt-5">
  <h2>All Users</h2>
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add</button>
</div>
<div class="container mt-5">
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Email</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <th scope="row"></th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><a href="{{ route('user.edit',$user->id )}}" class="btn btn-primary mx-1 btn-sm">Edit</a>
                    <button class="btn btn-danger mx-1 btn-sm delete_user_btn" data-user_id="{{ $user->id }}">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form class="col-12 m-auto" action="{{ route('user.create') }}" id="createUserForm" method="post">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add User</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            @csrf
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name">
                <span class="text-danger errorBox" id="nameError"> </span>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" id="exampleInputEmail1">
                <span class="text-danger errorBox" id="emailError"> </span>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="exampleInputpassword">
                <span class="text-danger errorBox" id="passwordError"> </span>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add</button>
      </div>
    </form>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        let table = new DataTable('#myTable');
        $('.delete_user_btn').click(function() {
            let conf = confirm('Are you sure to delete?');
            if (conf == false) {
                return false
            }
            let user_id = $(this).data('user_id');
            deleteUser(user_id);
        })

        $('#createUserForm').submit(function(e) {
            e.preventDefault();
            $(".errorBox").text('');
            let data = $(this).serializeArray();
            createUser(data);
        })
        
    })

    function createUser(data) {
        $.ajax({
            type: "POST",
            url: "{{ route('user.create') }}",
            data: data,
            dataType: "json",
            success: function(result) {
                if (result.status == 'success') {
                    location.reload();
                } else {
                    alert('Something went wrong');
                }
            },
            error: function(result) {
                $.each(result.responseJSON.errors, function(key,val) {
                    $("#"+key+"Error").text("* "+val[0]);
                })
            }
        })
    }

    function deleteUser(id) {
        $.ajax({
            type: "DELETE",
            url: "{{ route('user.delete') }}",
            data: {id:id,"_token": "{{ csrf_token() }}"},
            dataType: "json",
            success: function(result){
                if (result.status == 'success') {
                    location.reload();
                } else {
                    alert('Something went wrong');
                }
            }
        })
    }
</script>
@endsection
