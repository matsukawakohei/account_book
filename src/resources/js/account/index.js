import DataTable from 'datatables.net-dt';

let table = new DataTable('#account-table', {
    language: {
        url: "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Japanese.json"
    },
    searching: false,
    columns: [
        { "orderable": true },
        { "orderable": false },
        { "orderable": true },
        { "orderable": false },
        { "orderable": false },
        { "orderable": false },
    ]
});