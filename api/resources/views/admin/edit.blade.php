@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @error('filename')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        @error('fileFilename')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        @error('fileDescription')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="container">
                            <form method="POST" action="{{ route('admin.file.update', [
                                'user_hash' => $file->user_hash,
                                'file_hash' => $file->file_hash
                            ]) }}">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <label for="fileFilename">Filename</label>
                                    <input type="text" class="form-control @error('filename') is-invalid @enderror"
                                           name='filename' id='fileFilename'
                                           value="{{ old('filename', $file->filename) }}">
                                </div>
                                <div class="form-group">
                                    <label for="fileDescription">Description</label>
                                    <input type="text"
                                           class="form-control @error('fileDescription') is-invalid @enderror"
                                           name='fileDescription' id='fileDescription'
                                           value="{{ old('fileDescription', $file->description) }}">
                                </div>
                                <div class="form-group">
                                    <label for="fileSenderEmail">Email address</label>
                                    <input type="email"
                                           class="form-control @error('fileSenderEmail') is-invalid @enderror"
                                           name='fileSenderEmail' id='fileSenderEmail'
                                           aria-describedby="emailHelp"
                                           value="{{ old('fileSenderEmail', $file->email) }}"
                                           placeholder="Enter email">
                                </div>

                                <input class="btn btn-primary" type="submit">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
