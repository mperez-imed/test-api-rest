@extends('layouts.app')

@section('title')
Register
@endsection

@section('content')
<div class="container" ng-controller="userController">
    @include('layouts.errors')
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header text-primary">Nuevo registro de usuario</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label for="rut">Rut</label>
                                <input type="text" name="rut" id="rut" class="form-control" maxlength="12" ng-model="user.rut"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" name="name" id="name" class="form-control" maxlength="50" ng-model="user.name"/>
                            </div>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input type="text" name="email" id="email" class="form-control" maxlength="50" ng-model="user.email"/>
                            </div>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label for="phone">Teléfono</label>
                                <input type="text" name="phone" id="phone" class="form-control" maxlength="11" ng-model="user.phone"/>
                            </div>
                        </div>
                    </div>                                                           
                    <div class="row">
                        <div class="col-12 col-md-12 text-right">
                            <button type="submit" class="btn btn-primary inline-button" ng-click="createUser()">
                                <i class="fa fa-check"></i>&nbsp;Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
