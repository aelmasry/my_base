<!-- DataTables -->
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.24/datatables.min.js"></script>
<script src = "http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{asset('plugins/datatables/dataTables.bootstrap4.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/datatables/buttons/dataTables.buttons.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/datatables/buttons.js') }}"></script>
<script type="text/javascript" src="{{asset('plugins/datatables/buttons/buttons.colVis.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('plugins/datatables/buttons.server-side.js') }}"></script>

<script type="text/javascript" src="{{ asset('https://cdn.datatables.net/colreorder/1.5.0/js/dataTables.colReorder.js') }}"></script>
<script type="text/javascript" src="{{ asset('https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.js') }}"></script>
<script type="text/javascript" src="{{ asset('https://cdn.datatables.net/rowgroup/1.0.3/js/dataTables.rowGroup.js') }}"></script>


<script type="text/javascript">
    function initICheck(){
        $('input[type="checkbox"].permission').on('ifCreated', function (event) {
            var checkbox = $(this);
            var roleId = $(this).data('role-id');
            var permission = $(this).data('permission');
            $.ajax({
                method: "GET",
                url: "{{url('admin/permissions/role-has-permission')}}",
                data: {roleId: roleId, permission: permission},
                dataType: "json"
            })
                .done(function (msg) {
                    if (msg.result) {
                        checkbox.iCheck('check');
                    }

                }).always(function () {
            });
        });

        $('.icheck input').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue',
            increaseArea: '20%' // optional
        });


        $('input[type="checkbox"].permission').on('ifClicked', function (event) {
            var url = "";
            var roleId = $(this).data('role-id');
            var permission = $(this).data('permission');
            if ($(this).parent('[class*="icheckbox"]').hasClass("checked")) {
                url = "{{url('admin/permissions/revoke-permission-to-role')}}";
            } else {
                url = "{{url('admin/permissions/give-permission-to-role')}}";
            }
            $.ajax({
                method: "POST",
                url: url,
                data: {_token: "{{csrf_token()}}", roleId: roleId, permission: permission}
            })
                .done(function (msg) {

                });

        });
    }

    function initColVis(_this,column){
        if(column.visible()){
            _this.addClass('text-bold');
            _this.find('i.fa').removeClass('text-light');
        }else{
            _this.removeClass('text-bold');
            _this.find('i.fa').addClass('text-light');
        }
    }

    function renderButtons(tableId) {

        var dtable = $("#" + tableId).DataTable();
        $('a#refreshDatatable').on('click', function () {
            dtable.button('4').trigger();
        });
        $('a#exportCsvDatatable').on('click', function () {
            dtable.button('1-0').trigger();
        });
        $('a#exportExcelDatatable').on('click', function () {
            dtable.button('1-1').trigger();
        });

        $('a#exportPdfDatatable').on('click', function () {
            dtable.button('1-2').trigger();
        });
        $('a#printDatatable').on('click', function () {
            dtable.button('2').trigger();
            //window.open(window.location.href);
        });
        $('a#resetDatatable').on('click', function () {
            dtable.button('3').trigger();
            $('.dataTables_filter input').val('');
        });
        $('li#colVisDatatable').on('hide.bs.dropdown', function (e) {
            var target = $(e.target);
            if(target.hasClass("keepopen") || target.parents(".keepopen").length){
                return false; // returning false should stop the dropdown from hiding.
            }else{
                return true;
            }
        }).find('.dropdown-toggle').on('click',function (e) {
            var target = $(e.target);
            target.parents('li#colVisDatatable').removeClass("keepopen");
        });
        $('li#colVisDatatable .dropdown-item').on('click', function (e) {
            e.preventDefault();
            var target = $(e.target);
            target.parents('li#colVisDatatable').addClass("keepopen");
            // Get the column API object
            var column = dtable.column( $(this).data('column') );
            // Toggle the visibility
            column.visible( ! column.visible() );
            initColVis($(this),column);
        });

        $('li#colVisDatatable .dropdown-item').each(function (e) {
            // Get the column API object
            var column = dtable.column( $(this).data('column') );
            initColVis($(this),column);
        });

        $("#" + tableId + "_filter").html("<div class=\"input-group input-group-sm\">\n" +
            "  <input type=\"text\" class=\"form-control\" placeholder=\"{{trans('lang.search')}}\" aria-label=\"{{trans('lang.search')}}\">\n" +
            "  <div class=\"input-group-append\">\n" +
            "    <span class=\"input-group-text\"><i class=\"fa fa-search\"></i></span>\n" +
            "  </div>\n" +
            "</div>");
        $("#" + tableId + "_filter input").on('keyup', function () {
            dtable.search(this.value).draw();
        });

        $('[data-toggle=tooltip]').tooltip();
    }

    function renderiCheck(tableId){
        initICheck();

        $("#" + tableId).on( 'draw.dt', function () {
            initICheck();
        } );
    }
    $(document).ready(function() { $.fn.dataTableExt.sErrMode = 'none'; });

</script>

@push('scripts')
<script>
    $( "table" ).delegate(".switchStatus", "change", function(event) {
            var Id = $(this).data('id');
            var modelName = $(this).data('model');
            var attributeName = $(this).find('input[type="checkbox"]').attr('name');
            $.ajax({
                method: "POST",
                url: 'switchStatus',
                data: {
                    _token: "{{csrf_token()}}",
                    id: Id,
                    model:modelName,
                    attributeName:attributeName,
                }
            }).done(function (msg) {
                Noty.overrideDefaults({
                    layout: 'topRight',
                    theme: 'backstrap',
                    timeout: 2500,
                    closeWith: ['click', 'button'],
                });

                new Noty({
                    type: msg.status,
                    text: msg.message,
                    timeout : 5000,
                }).show();
            });
        });

        window.deleteConfirm = function(formId) {
            Swal.fire({
                title: "<strong> {{trans('lang.error')}} </strong>",
                icon: "warning",
                html: "<strong> {{trans('lang.do_you_want_to_delete_this')}} </strong>",
                showCancelButton: true,
                confirmButtonText: "<i class='fa fa-trash fa-3'></i> {{trans('lang.yes_do_it')}}",
                confirmButtonColor: "#e3342f",
                focusConfirm: false,
                showCloseButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
</script>
@endpush
