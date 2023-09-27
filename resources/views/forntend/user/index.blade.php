@extends('layouts.app')

@section('content')

@if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

<!-- row opened -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                
            <div class="card-body">
                <div class="table-responsive hoverable-table">
                    <table class="table table-striped-columns" id="example"  style=" text-align: center;">
                        <div class="relative flex lg:inline-flex items-center rounded-xl px-3 py-2">
                            <form method="GET" action="#">
                                <div class="input-group mb-3">
                                  <input 
                                    type="text" 
                                    name="search" 
                                    value="#" 
                                    class="form-control" 
                                    placeholder="Search..." 
                                    aria-label="Search" 
                                    aria-describedby="button-addon2">
                                  <button class="btn btn-info" type="submit" id="button-addon2">Search</button>
                                </div>
                            </form>
                        </div>
                        <thead>
                            <tr>
                                <th class="wd-10p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">UserName</th>
                                <th class="wd-20p border-bottom-0">Email</th>
                                
                                <th class="wd-10p border-bottom-0">Add</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0
                            @endphp
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info"
                                            title="{{$user->username}}">{{$user->username}}</a>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        
                                        <a class="modal-effect btn btn-sm btn-primary" style="color:white" href="#" data-user_id="{{ $user->id }}" 
                                            data-toggle="modal" data-target="#addFriend"><i
                                                ></i>&nbsp;&nbsp; Follow
                                                
                                            </a>
                                         
                                    </td>
                                
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="addFriend" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Follow </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            
            <form action="add_user/{id}" method="post">

                @method('post')
                
                
                {{ csrf_field() }}

            </div>
                <div class="modal-body">
                    <p class="text-center">
                       <input type="text" name="user_id" id="user_id" value="">
                    <h6 style="color:rgb(9, 53, 165)">Are you sure to follow this user </h6>
                    </p>
                </div>
                    
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
                    <button type="submit" class="btn btn-primary">Sure</button>
                </div>
            </form>
        </div>
        
    </div>

</div> 

</div>
<!-- /row -->
</div>
<!-- Container closed -->
</div>

@endsection
@section('script')

<script>


$('#addFriend').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var user_id = button.data('user_id')
		var modal = $(this)
		modal.find('.modal-body #user_id').val(user_id);
		console.log(user_id);
	})

</script>
@endsection