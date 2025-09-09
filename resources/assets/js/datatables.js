$(function (e) {

    // basic datatable
    $('#datatable-basic').DataTable({
        language: {
            lengthMenu: "Mostrando _MENU_ registros por página",
            zeroRecords: "No hay registros",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "Sin nada que mostrar",
            infoFiltered: "(filtrado de _MAX_ registros totales)",
            search: "Buscar",
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            paginate: {
                previous: 'Anterior',
                next: 'Siguiente'
            }
        },
        "pageLength": 10,
        // scrollX: true
    });
    // basic datatable

    // responsive datatable
    $('#responsiveDataTable').DataTable({
        responsive: true,
        language: {
            lengthMenu: "Mostrando _MENU_ registros por página",
            zeroRecords: "No hay registros",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "Sin nada que mostrar",
            infoFiltered: "(filtrado de _MAX_ registros totales)",
            search: "Buscar",
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            paginate: {
                previous: 'Anterior',
                next: 'Siguiente'
            }
        },
        "pageLength": 10,
    });
    // responsive datatable

    // responsive modal datatable
    $('#responsivemodal-DataTable').DataTable({
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return data[0] + ' ' + data[1];
                    }
                }),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                    tableClass: 'table'
                })
            }
        },
        language: {
            lengthMenu: "Mostrando _MENU_ registros por página",
            zeroRecords: "No hay registros",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "Sin nada que mostrar",
            infoFiltered: "(filtrado de _MAX_ registros totales)",
            search: "Buscar",
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            paginate: {
                previous: 'Anterior',
                next: 'Siguiente'
            }
        },
        "pageLength": 10,
    });
    // responsive modal datatable

    // file export datatable
    $('#file-export').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        language: {
            lengthMenu: "Mostrando _MENU_ registros por página",
            zeroRecords: "No hay registros",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "Sin nada que mostrar",
            infoFiltered: "(filtrado de _MAX_ registros totales)",
            search: "Buscar",
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            paginate: {
                previous: 'Anterior',
                next: 'Siguiente'
            }
        },
    });
    // file export datatable

    // delete row datatable
    var table = $('#delete-datatable').DataTable({
        language: {
            lengthMenu: "Mostrando _MENU_ registros por página",
            zeroRecords: "No hay registros",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "Sin nada que mostrar",
            infoFiltered: "(filtrado de _MAX_ registros totales)",
            search: "Buscar",
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            paginate: {
                previous: 'Anterior',
                next: 'Siguiente'
            }
        },
    });
    $('#delete-datatable tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
    $('#button').on("click", function () {
        table.row('.selected').remove().draw(false);
    });
    // delete row datatable

    // scroll vertical
    $('#scroll-vertical').DataTable({
        scrollY: '265px',
        scrollCollapse: true,
        paging: false,
        scrollX: true,
        language: {
            lengthMenu: "Mostrando _MENU_ registros por página",
            zeroRecords: "No hay registros",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "Sin nada que mostrar",
            infoFiltered: "(filtrado de _MAX_ registros totales)",
            search: "Buscar",
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            paginate: {
                previous: 'Anterior',
                next: 'Siguiente'
            }
        },
    });
    // scroll vertical

    // hidden columns
    $('#hidden-columns').DataTable({
        columnDefs: [
            {
                target: 2,
                visible: false,
                searchable: false,
            },
            {
                target: 3,
                visible: false,
            },
        ],
        language: {
            lengthMenu: "Mostrando _MENU_ registros por página",
            zeroRecords: "No hay registros",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "Sin nada que mostrar",
            infoFiltered: "(filtrado de _MAX_ registros totales)",
            search: "Buscar",
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            paginate: {
                previous: 'Anterior',
                next: 'Siguiente'
            }
        },
        "pageLength": 10,
        // scrollX: true
    });
    // hidden columns
    
    // add row datatable
    var t = $('#add-row').DataTable({
        
        language: {
            lengthMenu: "Mostrando _MENU_ registros por página",
            zeroRecords: "No hay registros",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "Sin nada que mostrar",
            infoFiltered: "(filtrado de _MAX_ registros totales)",
            search: "Buscar",
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            paginate: {
                previous: 'Anterior',
                next: 'Siguiente'
            }
        },
    });
    var counter = 1;
    $('#addRow').on('click', function () {
        t.row.add([counter + '.1', counter + '.2', counter + '.3', counter + '.4', counter + '.5']).draw(false);
        counter++;
    });
    // add row datatable

});

