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

                <a  class="btn btn-primary" href="{{route('withdraw::index')}}">Withdraw</a>

             <!--    <div id="toolbar">
                    <div class="form-inline mb20" role="form">
                        <div class="form-group">
                            <input name="search" class="form-control"
                                   placeholder="@lang('labels.search')"/>
                        </div>

                        <div class="form-group">
                            <input name="promocode" class="form-control"
                                   placeholder="@lang('labels.promo_code')"/>
                        </div>

                     

                        <div class="form-group">
                            <button class="button bordered" type="button"
                                    data-toggle="modal"
                                    data-target="#sendPushNotificationModal">
                                @lang('labels.send_push_notification')
                            </button>
                        </div>
                    </div>
                </div> -->

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
                    <th>player_id</th>
                    <th>amount</th>
                    <th>status</th>
                    <th>type</th>
                      <th>user </th>
                   </tr>

                    

        @foreach($rows as $req)
                  <tr>
                    <td>{{$req->player_id}}</td>
                    <td>{{$req->amount}}</td>
                    <td>{{$req->status}}</td>
                    <td>@if($req->type==1) 
                             {{$req->amount/$uc_rate}}  uc credit


                        @else
                             {{$req->amount/$popularity_rate}}  popularity

                      
                        @endif</td>

                   
                             
                    <td><?php echo $req->user['name']; ?></td>
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