@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Setting</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        {{-- Put Content Here --}}
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <form method="post" id="dynamic_form">
                        @csrf
                        <span id="result"></span>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Model Ai</label>
                                        <select name="ai_model" id="ai_model" class="form-control">
                                            @foreach ($model_ai as $m)
                                                <option
                                                    value="{{ $m }}" {{ $m == $setting->ai_model ? 'selected' : '' }}>{{ $m }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Temperature</label>
                                        <input type="number" step="any" min="0" max="2" name="temperature"
                                               id="temperature" class="form-control"
                                               value="{{ $setting->temperature }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Max Tokens</label>
                                        <input type="number" name="max_tokens" id="max_tokens" class="form-control"
                                               value="{{ $setting->max_tokens }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">System Context</label>
                                        <textarea name="system_context" id="system_context" cols="10" rows="10"
                                                  class="form-control">{{ $setting->system_context }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer" style="text-align: right">
                            <button type="submit" id="submit_setting" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#ai_model').select2();

            $('#dynamic_form').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    url:'{{ route("setting.store") }}',
                    method:'post',
                    data:$(this).serialize(),
                    dataType:'json',
                    beforeSend:function(){
                        $('#submit_setting').html('Loading...');
                    },
                    success:function(data) {
                        $('#result').html('<div class="alert alert-success">Setting Updated</div>');

                        $('#submit_setting').html('Submit');
                    },
                    error: function (data) {
                        $('#result').html('<div class="alert alert-danger">Please Try Again</div>');
                        $('#submit_setting').html('Submit');
                    }
                })
            });
        });
    </script>
@endsection
