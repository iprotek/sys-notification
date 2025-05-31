
@extends('iprotek_core::layout.pages.view-dashboard')
@section('logout-link','/logout')
@section('site-title', 'SMS SCHEDULE TRIGGER')
@section('head')
    <script src="/js/xlsx.full.min.js"></script>
@endsection
@section('breadcrumb')
    <!--
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">Widgets</li>
    -->
@endsection
@section('content') 
  <div id="main-content">
    <sys-notification-trigger-sms :group_id="{{$group_id}}" :branch_id="{{$selected_branch_id}}" :scheduler_id="{{$scheduler_id}}"/>
  </div>
  
@endsection

@section('foot')
  <script>
    ActivateMenu(['menu-sys-notification-scheduler']);
  </script>
  <script src="/iprotek/js/manage/sys-notification/triggers/sms.js"> </script>
@endsection
