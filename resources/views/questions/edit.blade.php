@extends('layouts.app')

@section('content')

    <h1>{{ $title }}</h1>
    <div class="panel user-panel">
        <div class="row">
            <div class="col-md-12">
                @include('flash::message')
                {!! Form::open(['route' => ['questions::update',$quizz], 'method' => 'POST']) !!}
                <div class="form-group">
                    {!! Form::label('question',  'create question' . ':' ) !!}
                    {!! Form::text('question' ,$quizz->question, ['class'=>'form-control', 'required'] ) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('A', 'answer A:', ['class'=>'control-label'] ) !!}
                    {!! Form::input('A', 'A',  $quizz->A, ['class'=>'form-control', 'required'] ) !!}
                </div>
             
             <div class="form-group">
                    {!! Form::label('B', 'answer B:', ['class'=>'control-label'] ) !!}
                    {!! Form::input('B', 'B',  $quizz->B, ['class'=>'form-control', 'required'] ) !!}
                </div>
                   <div class="form-group">
                    {!! Form::label('C', 'answer C:', ['class'=>'control-label'] ) !!}
                    {!! Form::input('text', 'C',  $quizz->C, ['class'=>'form-control', 'required'] ) !!}
                </div>
                  <div class="form-group">
                    {!! Form::label('D', 'answer D:', ['class'=>'control-label'] ) !!}
                    {!! Form::input('text', 'D',  $quizz->D, ['class'=>'form-control', 'required'] ) !!}
                </div>

                      <div class="form-group">
                    {!! Form::label('section', '  section:', ['class'=>'control-label'] ) !!}
                    <select name="quiz_id" class="form-control">

                       @foreach($quizzs as $q) 
                        <option value="{{$q->id}}">{{$q->title}}</option>
                        @endforeach
                         
                     </select>

                      </div>

                       <div class="form-group">
                    {!! Form::label('correct_answer', 'conrrect answer:', ['class'=>'control-label'] ) !!}
                    {!! Form::input('text', 'correct_answer',  $quizz->correct_answer, ['class'=>'form-control', 'required'] ) !!}
                </div>
             

                <input type="submit" class="button button-submit primary" value="@lang('labels.save')"/>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection