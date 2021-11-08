$(function () {
  $('#posts_table').DataTable({
    processing: true,
    serverSide: true,
    order: [[ 1, "asc" ]],
    ajax  : window.location.href,
    columns: [
        {data: 'check', name:'check', orderable: false, searchable: false},
        {data: 'id', name: 'id'},
        {data: 'title', name: 'title'},
        {data: 'category', name: 'category'},
        {data: 'image', name: 'image'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
    ],
  });
});