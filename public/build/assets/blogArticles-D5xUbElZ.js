import{D as t,s as e}from"./common-Bm_rDy6i.js";$(document).ready(function(){$("#blogArticles-table").DataTable({...t,ajax:{...t.ajax,url:url_route,data:{with_trashed}},columns:[...t.columns,{data:"title"},{data:"category"},{data:"summary"},{data:"preview",className:"text-center"},{data:"published_at",className:"text-right",render:a=>moment(a).format("DD/MM/YYYY")},{data:null,className:"text-right",render:a=>e(a)},{data:"action",className:"text-center"}]})});