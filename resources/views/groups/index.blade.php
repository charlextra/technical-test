@extends('layouts.app')

@section('content')

<h3>Groups</h3>
<hr>
@if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{Session::get('message')}}
    </div>
@endif
<div class="table-responsive"> 
                {{-- <div class="table-responsive"> 
                    <button type="button" class="btn  btn-primary float-right add"> <i class="fa fa-plus"></i></button> --}}
                    <button class="btn  btn-secondary float-right add" data-bs-toggle="modal" data-bs-target="#modal-default"><svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg> Add Element</button>
                    <p>
                        <table class="datatable  table table-borderless table-striped table-nowrap  mb-1 ">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0 rounded-start">#</th>
                                    <th class="border-0">Title</th>
                                    <th class="border-0">Description</th>
                                    <th class="border-0 rounded-end">Action</th>
                                </tr>
                            </thead>
                        </table>

                    </p>
                </div>

                <!-- Modal Content -->
                <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">             
                            <form class="form" action="" method="POST">
                                <div class="modal-header">
                                    <h2 class="h6 modal-title">New Group</h2>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id">

                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" class="form-control input-sm">
                                        <div style="display: none;" class="title_err text-danger error-text  invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text" name="description" class="form-control input-sm">
                                        <div style="display: none;" class="description_err text-danger error-text  invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-save">Save</button>
                                    <button type="button" class="btn btn-secondary btn-update">Update</button>
                                    <button type="button" class="btn btn-link text-gray-600 text-gray-600 ms-auto" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End of Modal Content -->

                <!-- Modal Content -->
                <div class="modal fade" id="modal-user" tabindex="-1" role="dialog" aria-labelledby="modal-user" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">     
                            <div class="modal-header">
                                <h2 class="h6 modal-title2" id="exampleModalCenterTitleUser"></h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>        
                            <form id="formUsers" action="{{url('assignusers')}}" method="POST" class="ajax-link-form">
                                <input type="hidden" name="model_id" value="">
                                <input type="hidden" name="model" value="Group">
                                <input type="hidden" name="assignments" id="assignments" value="">
                                @csrf
                                <div class="modal-body table-responsive">
                                    <table class=" table table-hover table-sm  nowrap" id="assignUser">
                                        <thead>
                                            <tr>
                                                <th>@lang('messages.User')</th>
                                                <th>@lang('messages.AssignUser')</th>
                                            </tr>
                                        </thead>
                                            <tbody>
                                            @foreach($users as $user)
                                                <tr>
                                                    <td>{{ $user->name }}</td>
                                                    <td>
                                                        <div class="form-group">
                                                            <label class="air__utils__control air__utils__control__checkbox" style="margin-top: 2px; margin-bottom: -20px;">
                                                                <input name="user_{{ $user->id }}" type="checkbox">
                                                                <span class="air__utils__control__indicator"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>@lang('messages.User')</th>
                                                <th>@lang('messages.AssignUser')</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light"
                                    data-dismiss="modal">@lang('messages.Close')</button>
                                    <button type="submit" class="btn btn-primary">@lang('messages.Submit')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End of Modal Content -->


                <!--js code here-->
                @push('scripts')
                <script type="module" type="text/javascript">

                    import {setDatatable, getDatatable} from "{{ asset("js/modules/datatables/GroupDataTable.js") }}";


                    import {btnAdd} from "{{ asset("js/buttons/btnAdd.js") }}";
                    import {btnEdit} from "{{ asset("js/buttons/btnEdit.js") }}";
                    import {btnSave} from "{{ asset("js/buttons/btnSave.js") }}";
                    import {btnUpdate} from "{{ asset("js/buttons/btnUpdate.js") }}";
                    import {btnDelete} from "{{ asset("js/buttons/btnDelete.js") }}";
                    import {btnUsersClick} from "{{ asset("js/buttons/btnUsers.js") }}";

                    $(document).ready(function() {

                        jQuery(function($) {

                            setDatatable()
    

                            btnAdd('@lang("messages.Create")')
                            btnEdit('@lang("messages.Edit")', 'edit', 'Group', '{{csrf_token()}}', '@lang("messages.Edit")', getDatatable(@json($groups)))

                            btnSave('groups', '{{csrf_token()}}', getDatatable(@json($groups)))
                            btnUpdate('groups', '{{csrf_token()}}', getDatatable(@json($groups)))
                            btnDelete('groups', '{{csrf_token()}}', getDatatable(@json($groups)))
                            btnUsersClick('{{url('usersList')}}', '{{csrf_token()}}', 'Group', '@lang("messages.Link")')
                        })
                    })
                </script>
                @endpush

                @endsection




