@if ($fetchTableDetails->count() > 0)
    <small class="p-2">
        <table class="table table-stripped table-hover">
            <thead>
                <tr>
                <th>#</th>
                <th>Customer Name</th>
                <th>Archive Date</th>
                <th>Archive Category</th>
                <th>Description</th>
                <th>Reference</th>
                <th>Reminder Date</th>
                <th>Uploaded By</th>
                <th><span class="glyphicon glyphicon-download"></span></th>
                <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $amount_total = 0;
                    $reconciled_total = 0;
                @endphp
                @foreach ($fetchTableDetails as $key => $fetchDetail)
                    @php
      				    $customer_name = "***";
                        $customer_code = "***";

                        if($fetchDetail->customer_id){
                            $getCustomer = \App\Models\Customers::where('id', $fetchDetail->customer_id)->first();
                            $customer_name = $getCustomer->company ?? "***";
                            $customer_code = $getCustomer->code ?? "***";;
                        }


                        $getArchiveCategory = \App\Models\ArchiveCategories::where('id', $fetchDetail->category_id)->first();
                        $getAllRoutePermisssions = \App\Models\RoutesPermissions::where('user_id', Auth::user()->id)->get();
                        $getAccountSubCategories = \App\Models\AcAccountSubCategories::where('id', $fetchDetail->sub_category_id)->first();

                        $getAllSystemUsers = \App\Models\SystemUsers::where('id', $fetchDetail->uploaded_by)->first();


                        $currentRoute = request()->route()->getName();
                        $parentRoute = 'index.'.explode('.', $currentRoute)[0].'';


                        $subcategoryName = ($getAccountSubCategories && $getAccountSubCategories->name) ? $getAccountSubCategories->name : '';
                        $isControll = ($fetchDetail && $fetchDetail->is_control == 1) ? 'Yes' : 'No';
                        $isFloating = ($fetchDetail && $fetchDetail->is_floating == 1) ? 'Yes' : 'No';
                        $isStatus = ($fetchDetail && $fetchDetail->status == 1) ? 'Active' : 'Inactive';



                            $canEdit = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                                return $permission->permission_type == 'update' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                            });

                            $canRead = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                                return $permission->permission_type == 'read' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                            });

                            $canDelete = $getAllRoutePermisssions->contains(function ($permission) use ($currentRoute, $parentRoute) {
                                return $permission->permission_type == 'delete' && ($permission->route == $currentRoute || $permission->route == $parentRoute);
                            });

                            $updateRoutePath = 'cusattachements.updatecusattachement';
                            $deleteRoutePath = 'cusattachements.deletecusattachement';

                            $deletebtn = '';
                            $activebtn = '';

                            $editButton = '';
                            if ($canEdit) {
                                if($fetchDetail->id > 0){
                                    $editButton .= '<button type="button" class="btn btn-xs btn-info" onClick="editArchive('
                                        . $fetchDetail->id . ', '
                                        . $fetchDetail->category_id . ', '
                                        . '\'' . addslashes($fetchDetail->description) . '\', '
                                        . '\'' . $fetchDetail->reminder_date . '\');" title="Edit">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </button>';
                                }
                            }

                            $readButton = '';
                            if ($canRead) {
                                if($fetchDetail->id > 0){
                                    $readButton .= '
                                    <button type="button" class="btn btn-xs btn-link" onclick="download_attachement_file('.$fetchDetail->id.', \''.$fetchDetail->file.'\');" title="Post Receipt"><span class="glyphicon glyphicon-download"></span></button>';
                                }
                            }

                            $deleteButton = '';
                            if($fetchDetail->uploaded_by == Auth::user()->id){
                                if ($canDelete) {
                                    if($fetchDetail->id > 0){
                                        $deleteButton .= '
                                        <button type="button" class="btn btn-xs btn-danger" onclick="deleteArchive('.$fetchDetail->id.');" title="Post Receipt" id="cr_post171834"><span class="glyphicon glyphicon-remove"></span></button>';
                                    }
                                }

                            }

                    @endphp

                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $customer_code.' '.$customer_name }}</td>
                                <td>{{ $fetchDetail->archive_date ?? '***' }}</td>
                                <td>{{ $getArchiveCategory->name ?? '' }}</td>
                                <td>{{ $fetchDetail->description ?? '' }}</td>
                                <td>{{ $fetchDetail->reference ?? '' }}</td>
                                <td>{{ $fetchDetail->reminder_date ?? '' }}</td>
                                <td>{{ $getAllSystemUsers->full_name ?? '' }}</td>
                                <td>{!! $readButton !!}</td>
                                <td class="tbl_row_width">{!! $deleteButton !!} {!! $editButton !!}</td>
                            </tr>

                @endforeach


            </tbody>
        </table>
    </small>

    <!-- Render Pagination Links -->
    {{-- <div class="pagination">
        {{ $fetchTableDetails->links() }}
    </div> --}}
@else
    <h4>No Data found in the system!</h4>
@endif


@push('scripts')
<script>

</script>
@endpush
