
@extends('adminlte::page')
@section('title')
 {!! trans("admin.etxs")  !!} <!-- changed from app. to admin. -->
@endsection
@push('css')
 <link href="{{asset('/assets/admin/mycustom.css')}}" rel="stylesheet">
 <link href="{{asset('/assets/admin/datatables.min.css')}}" rel="stylesheet">
@endpush

@section('content_header')
     <h1>
        {!! trans("admin.etxs")  !!} <!-- changed from app. to admin. -->
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {!! trans("admin.dashboard")  !!}</a></li>
        <li class="active">{!! trans("admin.etxs")  !!}</li> <!-- changed from app. to admin. -->
    </ol>
@endsection

@section("content")

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">

            <div class="box">
                <div class="box-body">
					<a data-table="Etx"  href="{{ route('admin.etxs.masstoggle') }}" data-ids="[]" class="btn btn-info btn-sm mass ajax_link refresh confirm" data-confirm="{{__('app.confirm_enable_selected')}}" data-status="1" title="{{__('admin.Enable')}} Etxs">
                            {{__('admin.Enable')}} : <span class="count">0</span> {{__('admin.selected')}} 
                        </a>
						<a data-table="Etx" href="{{ route('admin.etxs.masstoggle') }}" data-ids="[]" class="btn btn-info btn-sm mass ajax_link refresh confirm" data-confirm="{{__('app.confirm_disable_selected')}}"  data-status="0" title=" {{__('admin.Disable')}} Etxs">
                            {{__('admin.Disable')}} : <span class="count">0</span> {{__('admin.selected')}} 
                        </a>
						<a data-table="Etx"   href="{{ route('admin.etxs.massdelete') }}" data-ids="[]" class="btn btn-danger btn-sm ajax_link mass refresh confirm" data-confirm="{{__('app.confirm_delete_selected')}}" title="{{__('admin.Delete')}} Etxs">
                            {{__('admin.Delete')}} : <span class="count">0</span> {{__('admin.selected')}} 
                        </a>
						<a   href="javascript:;" class="btn btn-default btn-sm clear" title="Clear Selection Etxs">
                            {{__('admin.reset')}} : <span class="count">0</span> {{__('admin.selected')}} 
                        </a>
						
				    <hr>
                    <table id="Etx" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th >#</th>
                            <th>{{ __('etxs.user_id') }}</th>
							<th>{{ __('etxs.txid') }}</th>
							<th>{{ __('etxs.address') }}</th>
							<th>{{ __('etxs.amount') }}</th>
							<th>{{ __('etxs.status') }}</th>
							<th>{!! trans("admin.actions")  !!}</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
	@include('modals.modal-delete')
</section><!-- /.content -->


@endsection

@push('js')
<script src="{{asset('/assets/admin/FileSaver.min.js')}}"></script>
<script src="{{asset('/assets/admin/sweetalert2.all.js')}}"></script>
<script src="{{asset('/assets/admin/jquery.blockUI.min.js')}}"></script>
<script src="{{asset('/assets/admin/datatables.min.js')}}"></script>
<script src="{{asset('/assets/admin/init.js')}}"></script>

@endpush

@section('js')

    <script>
        $(function() {
			@include('scripts.delete-modal-script')
			var selected = [];
          	window.Etx = $('#Etx').dataTable({
                "order": [[ 5, 'asc' ]],
                "language": {
                    "sDecimal":        ",",
                    "sEmptyTable":     "{!! trans("admin.sEmptyTable")  !!}",
                    "sInfo":           "{!! trans("admin.sInfo")  !!}",
                    "sInfoEmpty":      "{!! trans("admin.sInfoEmpty")  !!}",
                    "sInfoFiltered":   "{!! trans("admin.sInfoFiltered")  !!}",
                    "sInfoPostFix":    "",
                    "sInfoThousands":  ".",
                    "sLengthMenu":     "{!! trans("admin.sLengthMenu")  !!}",
                    "sLoadingRecords": "{!! trans("admin.sLoadingRecords")  !!}",
                    "sProcessing":     "{!! trans("admin.sProcessing")  !!}",
                    "sSearch":         "{!! trans("admin.sSearch")  !!}",
                    "sZeroRecords":    "{!! trans("admin.sZeroRecords")  !!}",
                    "oPaginate": {
                        "sFirst":    "{!! trans("admin.sFirst")  !!}",
                        "sLast":     "{!! trans("admin.sLast")  !!}",
                        "sNext":     "{!! trans("admin.sNext")  !!}",
                        "sPrevious": "{!! trans("admin.sPrevious")  !!}"
                    },
                    "oAria": {
                        "sSortAscending":  "{!! trans("admin.sSortAscending")  !!}",
                        "sSortDescending": "{!! trans("admin.sSortDescending")  !!}"
                    }
                },
                processing: true,
				responsive: true,
                serverSide: true,
                "autoWidth": false,
				"rowCallback": function( row, data ) {
					if ( $.inArray(data.DT_RowId, selected) !== -1 ) {
						$(row).addClass('info');
						$(row).find('input.chkbx').prop('checked', true);
					}
				},
			    "ajax": {
					"url": "{{route('admin.etxs.table')}}",
					"type": "POST",
					'headers': { 'X-CSRF-TOKEN': '{{ csrf_token() }}'}
				},
				type:'POST',
                columns: [
                    {data: 'id', name:  'id', orderable: true},
                    {data: 'user_id', name:  'user_id', orderable: true},
                    {data: 'txid', name:  'txid', orderable: true},
                    {data: 'address', name:  'address', orderable: true},
                    {data: 'amount', name:  'amount', orderable: true},
                    {data: 'status', name:  'status', orderable: true},
					{data: 'actions', name: 'actions'},
                  
                ]
            });
			$('#Etx tbody').on('click', 'input', function () {
				var tr = $(this).parents('tr')
				var id = tr.attr('id');
				
				var index = $.inArray(id, selected);
				if ( index === -1 ) {
					selected.push( id );
				} else {
					selected.splice( index, 1 );
				}
				
				$(tr).toggleClass('info');
				$('a.btn.mass').data('ids',selected);
				$('.count').text(selected.length);
			} );
			
			$('a.btn.clear').click(function(e) {
				selected =[];
				$('.count').text(0);
				$('a.btn.mass').data('ids',[]);
				$('.chkbx').prop('checked', false);
				$('tr.info','#Etx tbody').removeClass('info');
			});



        });
    </script>
@endsection
