@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if(Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                    @if(Session::has('fail'))
                    <div class="alert alert-danger">
                        {{ Session::get('fail') }}
                    </div>
                    @endif
                   <form action="{{ route('email.verify') }}" method="post" id="preventing-multiple-submit">
                        {{ csrf_field() }}
                       <div>
                            <label for="">email</label>
                            <input type="email" name="email" class= "@error('email')is-invalid @enderror" id="">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <button type="submit" class="preventing-multiple-submit" >Submit</button>
                       </div>
                   </form>

                   {{-- <table class="table">
                    @foreach ($students as $day => $students_list)
                        <tr>
                            <th colspan="3"><strong>{{ $day }}: {{ $students_list->count() }} students<strong></th>
                        </tr>
                        @foreach ($students_list as $student)
                            <tr>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->created_at }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                    </table> --}}
                    {{-- <table class="table">
                        <tr>
                          <td>{{ $students->id }}</td>  
                          <td>{{ $students->name }}</td>  
                          <td>{{ $students->email }}</td>  
                          <td>{{ $students->created_at }}</td>  
                        </tr>
                    </table> --}}
                    {{-- <table class="table">
                        @foreach ($students as $student)
                            
                                <tr>
                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->created_at }}</td>
                                </tr>
                           
                        @endforeach
                    </table> --}}
                    {{-- <form action="{{ route('test') }}" method="post">
                        {{ csrf_field() }}
                       <div>
                            
                            <button type="submit">Submit</button>
                       </div>
                   </form>  --}}

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')

<script>
$(document).ready(function () {
    // #preventing-multiple-submit is id of form
    $("#preventing-multiple-submit").submit(function () {

        // .preventing-multiple-submit is class of button
        $(".preventing-multiple-submit").attr("disabled", true);
        return true;
    });
});
</script>

@endsection