@extends('layouts.app')

@section('content')
    <h1>{{ $title }}</h1>
    <div class="panel user-panel">
        <div class="row">
            <div class="col-md-12">
                @include('flash::message')
                {!! Form::open(['route' => 'questions::store', 'method' => 'POST']) !!}
                <div class="form-group">
                    {!! Form::label('question',  'create question' . ':' ) !!}
                    {!! Form::text('question',  null, ['class'=>'form-control', 'required'] ) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('A', '  A:', ['class'=>'control-label'] ) !!}
                    {!! Form::input('A', 'A',  null, ['class'=>'form-control', 'required'] ) !!}
                </div>
             
             <div class="form-group">
                    {!! Form::label('B', ' B:', ['class'=>'control-label'] ) !!}
                    {!! Form::input('B', 'B',  null, ['class'=>'form-control', 'required'] ) !!}
                </div>
                   <div class="form-group">
                    {!! Form::label('C', '  C:', ['class'=>'control-label'] ) !!}
                    {!! Form::input('C', 'C',  null, ['class'=>'form-control', 'required'] ) !!}
                </div>
                  <div class="form-group">
                    {!! Form::label('D', '  D:', ['class'=>'control-label'] ) !!}
                    {!! Form::input('D', 'D',  null, ['class'=>'form-control', 'required'] ) !!}
                </div>
                     <div class="form-group">
                    {!! Form::label('section', '  section:', ['class'=>'control-label'] ) !!}
                    <select name="quiz_id" class="form-control">

                       @foreach($quizzs as $quizz) 
                        <option value="{{$quizz->id}}">{{$quizz->title}}</option>
                        @endforeach
                         
                     </select>

                      </div>

                 <div class="form-group">
                    {!! Form::label('correct_answer', 'correct answer:', ['class'=>'control-label'] ) !!}
                    {!! Form::input('correct_answer', 'correct_answer',  null, ['class'=>'form-control', 'required'] ) !!}
                </div>
             

                <input type="submit" class="button button-submit primary" value="@lang('labels.save')"/>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection