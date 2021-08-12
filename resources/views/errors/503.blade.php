@extends('partials.form')
<?php $title = 'Error'; 
$breadcrumb = [];
$header = '503';
?>
@section('content-form')
<div class="row align-items-center">
  <div class="col-lg-4 ms-auto">
    <div class="ex-page-content">
      <h1 class="text-dark display-3 mt-4">Kesalahan!</h1>
      <h4 class="mb-4">Maaf, halaman tidak ditemukan</h4>
      <p class="mb-5">Anda tidak dapat mengakses halaman ini, atau halaman ini tidak Tersedia.</p>
      </div>
  </div>
</div>
@endsection
