import{D as a}from"./common-Bm_rDy6i.js";$(document).ready(function(){$("#states-table").DataTable({...a,ajax:{...a.ajax,url:"/dashboard/states"},columns:[...a.columns,{data:"code"},{data:"alias"},{data:"name"},{data:"variant"},{data:"ciudades_count"},{data:null,className:"text-right",render:({human_created_at:t,created_dmy:e})=>`<small class="human-date" data-tooltip="Creado el ${e}">${t}</small>`},{data:"action",className:"text-center"}]})});