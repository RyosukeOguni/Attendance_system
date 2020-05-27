@extends('layouts.common_base')
@section('title', $title)

@section('header')
<div class="container mt-4">
    <div class="row justify-content-center">
        <h2 class="text-center">@yield('title')</h2>
    </div>
</div>
@endsection

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <dl class="form-group row">
                <dt class="col-md-4 col-form-label text-md-right">
                    ID</dt>
                <dd class="col-md-8 col-form-label">

                    {{ $user->id }}
                </dd>
            </dl>
            <dl class="form-group row">
                <dt class="col-md-4 col-form-label text-md-right">
                    氏　名</dt>
                <dd class="col-md-8 col-form-label">

                    {{ $user->getName() }}
                </dd>
            </dl>
            <dl class="form-group row">
                <dt class="col-md-4 col-form-label text-md-right">
                    カナ名</dt>
                <dd class="col-md-8 col-form-label">

                    {{ $user->getNameKana() }}
                </dd>
            </dl>
            <dl class="form-group row">
                <dt class="col-md-4 col-form-label text-md-right">
                    所　属</dt>
                <dd class="col-md-8 col-form-label">

                {{ $user->school->school_name }}
                </dd>
            </dl>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">

                    <a href="user/0" class="button square_min">戻　る</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<div class="container">
    <div class="col-md-auto row justify-content-left">
        {{-- 変数の内容を表示
        <pre>
        {{ var_export($users, true)  }}</pre> --}}
    </div>
</div>
@endsection
