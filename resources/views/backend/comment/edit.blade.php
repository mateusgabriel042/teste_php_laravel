@extends('backend.layouts.master')

@section('title','Editar comentário')

@section('main-content')
<div class="card">
  <h5 class="card-header">Editar comentário</h5>
  <div class="card-body">
    <form action="{{route('comment.update',$comment->id)}}" method="POST">
      @csrf
      @method('PATCH')
      <div class="form-group">
        <label for="name">Para:</label>
        <input type="text" disabled class="form-control" value="{{$comment->user_info->name}}">
      </div>
      <div class="form-group">
        <label for="comment">Comentário</label>
      <textarea name="comment" id="" cols="20" rows="10" class="form-control">{{$comment->comment}}</textarea>
      </div>
      <div class="form-group">
        <label for="status">Status :</label>
        <select name="status" id="" class="form-control">
          <option value="">--Selecionar Status--</option>
          <option value="active" {{(($comment->status=='active')? 'selected' : '')}}>Ativo</option>
          <option value="inactive" {{(($comment->status=='inactive')? 'selected' : '')}}>Inativo</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Modificar</button>
    </form>
  </div>
</div>
@endsection

@push('styles')
<style>
    .order-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.shipping-info h4{
        text-decoration: underline;
    }
</style>
@endpush