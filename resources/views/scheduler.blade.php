
@extends('iprotek_core::layout.pages.view-dashboard')
@section('logout-link','/logout')
@section('site-title', 'Schedule Notification')
@section('head')
    <link rel="stylesheet" href="/css/w3school/searchinput.css">
    <link rel="stylesheet" href="/css/redtable.css">
    <link rel="stylesheet" href="/css/Xpose-hover.css">
    <script src="/js/xpose/Xpose-Events.js"></script>
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
    <sys-notification-scheduler :group_id="{{$group_id}}" :branch_id="{{$selected_branch_id}}"/>
  </div>
  
@endsection

@section('foot')
  <script>
    ActivateMenu([' menu-sys-notification-scheduler']);
  </script>
  <script src="/iprotek/js/manage/sys-notification/scheduler.js"> </script>
@endsection
