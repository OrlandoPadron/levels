@extends('layouts.base-inside-app')
@section('head')
<link href="{{asset('css/profile_settings.css')}}" rel="stylesheet" />
<script>
  function submit(){
    document.getElementById("myForm").submit();
  }
</script>
@endsection
@section('content')
@php
  $userName = Auth::user()->name . ' ' . Auth::user()->name2;
  trim($userName);
  $userSurnames = Auth::user()->surname . ' ' . Auth::user()->surname2;
  trim($userSurnames);

  $gender = Auth::user()->gender; 

  //Additional info
  $additionalInfo = null;
  if(Auth::user()->additional_info != '{}'){
    $decrypt = Crypt::decryptString(Auth::user()->additional_info);
    $additionalInfo = json_decode($decrypt, true);
  }else{
    $additionalInfo = json_decode(Auth::user()->additional_info, true);
  }
  $birthday = isset($additionalInfo['additionalInfo']['birthday']) ? $additionalInfo['additionalInfo']['birthday'] : null;
  $dni = isset($additionalInfo['additionalInfo']['dni']) ? $additionalInfo['additionalInfo']['dni'] : null;
  $address = isset($additionalInfo['additionalInfo']['address']) ? $additionalInfo['additionalInfo']['address'] : null;
  $phone = isset($additionalInfo['additionalInfo']['phone']) ? $additionalInfo['additionalInfo']['phone'] : null;
  $occupation = isset($additionalInfo['additionalInfo']['occupation']) ? $additionalInfo['additionalInfo']['occupation'] : null;

  //ThirdParties links 
  $strava = isset($additionalInfo['thirdParties']['strava']) ? $additionalInfo['thirdParties']['strava'] : null;
@endphp
<div class="settings-profile-container" x-data="{sectionTab: 'general'}">
  <div class="settings-navbar">
    <div class="navbar-container">
      <ul>
        <li class="active" x-on:click.prevent @click="sectionTab = 'general'" :class="{'active': sectionTab === 'general'}">
          <a href="">Datos personales</a>
        </li>
        <li x-on:click.prevent @click="sectionTab = 'account'" :class="{'active': sectionTab === 'account'}">
          <a href="">Configurar cuenta</a>
        </li>
        <li x-on:click.prevent @click="sectionTab = 'userAvatar'" :class="{'active': sectionTab === 'userAvatar'}">
          <a href="">Imagen de usuario</a>
        </li>
        <li class="active" x-on:click.prevent @click="sectionTab = 'thirdparties'" :class="{'active': sectionTab === 'thirdparties'}">
          <a href="">Servicios de terceros</a>
        </li>
      </ul>
    </div>
  </div>
  <div class="settings-content">
    <div style="display: none;" x-show.transition.in.opacity.duration.500ms="sectionTab === 'general'">
      @include('sections_editProfile.general')
    </div>
    <div style="display: none;" x-show.transition.in.opacity.duration.500ms="sectionTab === 'userAvatar'">
      @include('sections_editProfile.userAvatar')
    </div>
    <div style="display: none;" x-show.transition.in.opacity.duration.500ms="sectionTab === 'account'">
      @include('sections_editProfile.account')
    </div>
    <div style="display: none;" x-show.transition.in.opacity.duration.500ms="sectionTab === 'thirdparties'">
      @include('sections_editProfile.thirdparties')
    </div>
  </div>
</div>
@endsection
