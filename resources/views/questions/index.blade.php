@extends('layouts.app')

@section('title', $title)

@section('content')
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<div class="users">
        <div class="row">
        <div class="header-with-content">
            <h1 class="inline-header">{{ $title }}</h1>
            @if(!empty($user->fcm_token))
                <button type="button" class="btn btn-primary btn-lg pull-right mt5" data-toggle="modal"
                        data-target="#sendPushNotificationModal">
                    @lang('labels.send_push_notification')
                </button>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @include('flash::message')
            <div class="row table-responsive">

                <div id="toolbar">
                    <div class="form-inline mb20" role="form">
                    
                        <div class="form-group">
                            <a class="button bordered" href="{{route('questions::create')}}"
                                     >
                        create a question
                             </a>
                        </div>
                    </div>
                </div>

     <!--            <table data-sort-order="desc"
                       data-route="withdraw"
                       data-toggle="table"
                       data-url="{{ route('withdraw::getRequests') }}"
                       data-page-size="10"
                       data-filter-show-clear="true"
                       data-filter-starts-with-search="true"
                       data-side-pagination="server"
                       data-pagination="true"
                       data-locale="{{ App::isLocale('ru') ? 'ru-RU' : 'en-US' }}"
                       data-query-params="queryParams">
                    <thead>
                    <tr>
 
                        <th data-field="player_id"
                            data-sortable="true">player_id</th>

                        <th data-field="amount"
                            data-sortable="true">amount</th>

                        <th data-field="status"
                            data-sortable="true">status</th>

                        <th data-field="type" data-align="center"  
                            data-sortable="true">type
                        </th>
                        
                        <th data-field="created_at" data-sortable="true">@lang('labels.registered_at')</th>
 
                    </tr>
                    </thead>
                </table> -->

           <table data-sort-order="desc"
                       data-route="withdraw"
                       data-toggle="tablea"
                       
                       data-page-size="10"
                        data-filter-starts-with-search="true"
                       data-side-pagination="server"
                       data-pagination="true"
                       data-locale="{{ App::isLocale('ru') ? 'ru-RU' : 'en-US' }}"
                       data-query-params="queryParams">
                    <thead>
                 <tr>
                        <th>question</th>
                        <th>A</th>
                        <th>B</th>
                        <th>C</th>
                        <th>D</th>
                        <th>Correct Answer</th>
                        <th>Section</th>
                        <th>Edit</th>
                        <th>delete</th>
                  </tr>

                    

        @foreach($rows as $req)
                  <tr>
                    <td>{{$req->question}}</td>
                    <td>{{$req->A}}</td>
                    <td>{{$req->B}}</td>
                    <td>{{$req->C}}</td>
                    <td>{{$req->D}}</td>
                    <td>{{$req->correct_answer}}</td>
                    <td>{{$req->quiz->title}}</td>
                    <td><a  class="btn btn-primary" href="{{route('questions::edit',['quizz_id'=>$req->id])}}">Edit</a></td>
                    <td><a  class="btn btn-warning  "  href=" {{route('questions::delete',['quizz_id'=>$req->id])}}">Delete</a></td>
   
                 </tr>           
       @endforeach 



             
                    </thead>
                </table>




            </div>

            
            @include('partials._sendPushNotificationModal', ['url' => route('users::send-push')])
        </div>
    </div>
</div>
@endsection