@extends('layouts.app')

@section('content')


            <h3>Users
            </h3>
            <hr>
 
                {{-- <div class="table-responsive"> 
                    <button type="button" class="btn  btn-primary float-right add"> <i class="fa fa-plus"></i></button> --}}
                    <button class="btn  btn-secondary float-right add" data-bs-toggle="modal" data-bs-target="#modal-default"><svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg> Add Element</button>
                <p>
                    <table class="datatable  table table-borderless table-striped  mb-1 ">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0 rounded-start">#</th>
                                <th class="border-0">Username</th>
                                <th class="border-0">Email</th>
                                <th class="border-0 rounded-end">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </p>
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
                                    <label for="name">Username</label>
                                    <input type="text" name="name" class="form-control input-sm">
                                     <div class="name_err text-danger error-text  invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control input-sm">
                                     <div class="email_err text-danger error-text  invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control input-sm">
                                     <div class="password_err text-danger error-text  invalid-feedback"></div>
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


            <!--js code here-->
            @push('scripts')
                <script type="module" type="text/javascript">

                        import {setDatatable, getDatatable} from "{{ asset("js/modules/datatables/UserDataTable.js") }}";

                        import {btnAdd} from "{{ asset("js/buttons/btnAdd.js") }}";
                        import {btnEdit} from "{{ asset("js/buttons/btnEdit.js") }}";
                        import {btnSave} from "{{ asset("js/buttons/btnSave.js") }}";
                        import {btnUpdate} from "{{ asset("js/buttons/btnUpdate.js") }}";
                        import {btnDelete} from "{{ asset("js/buttons/btnDelete.js") }}";

                        $(document).ready(function() {

                            jQuery(function($) {

                                setDatatable()

                                btnAdd('@lang("messages.Create")')
                                btnEdit('@lang("messages.Edit")', 'edit', 'User', '{{csrf_token()}}', '@lang("messages.Edit")', getDatatable(@json($users)))
                                
                                btnSave('users', '{{csrf_token()}}', getDatatable(@json($users)))
                                btnUpdate('users', '{{csrf_token()}}', getDatatable(@json($users)))
                                btnDelete('users', '{{csrf_token()}}', getDatatable(@json($users)))


                                
                            })
                        })
                </script>
            @endpush
        </div>

@endsection