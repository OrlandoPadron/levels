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
<div class="settings-profile-container" x-data="{sectionTab: 'general'}">
  <div class="settings-navbar">
    <div class="navbar-container">
      <ul>
        <li class="active" x-on:click.prevent @click="sectionTab = 'general'" :class="{'active': sectionTab === 'general'}">
          <a href="">General</a>
        </li>
        <li x-on:click.prevent @click="sectionTab = 'userAvatar'" :class="{'active': sectionTab === 'userAvatar'}">
          <a href="">Imagen de usuario</a>
        </li>
        <li x-on:click.prevent @click="sectionTab = 'athleteRecord'" :class="{'active': sectionTab === 'athleteRecord'}">
          <a href="">Ficha corredor</a>
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
    <div style="display: none;" x-show.transition.in.opacity.duration.500ms="sectionTab === 'athleteRecord'">
      @include('sections_editProfile.athleteRecord')
    </div>
    <div style="display: none;" x-show.transition.in.opacity.duration.500ms="sectionTab === 'thirdparties'">
      @include('sections_editProfile.thirdparties')
    </div>
  </div>
</div>
@endsection
