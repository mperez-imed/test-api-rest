@extends('layouts.app')

@section('title')
Dashboard
@endsection

@section('content')
<div class="container" ng-controller="userController" data-ng-init="loadUsers()">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header text-primary">Dashboard</div>
                <div class="card-body card-table">
                    <div class="table-responsive">
                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:15%">Rut</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center" style="width:30%">Email</th>
                                    <th class="text-center" style="width:15%">Phone</th>
                                    <th class="text-center" style="width:10%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-if="users.length > 0" ng-repeat="(index, user) in users">
                                    <td class="text-center">@{{ user.rut }}</th>
                                    <td class="text-center">@{{ user.name }}</th>
                                    <td class="text-center">@{{ user.email }}</th>
                                    <td class="text-center">@{{ user.phone }}</th>
                                    <td class="text-center">
                                        <span ng-if="user.confirmed == 1" class="text-success">Yes</span>
                                        <span ng-if="user.confirmed != 1" class="text-danger">No</span>
                                    </td>                                    
                                </tr>
                                <tr ng-if="users.length == 0">
                                    <td colspan="5" class="text-center">No records found</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection