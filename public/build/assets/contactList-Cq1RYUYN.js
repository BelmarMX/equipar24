import{D as a}from"./common-Bm_rDy6i.js";$(document).ready(function(){$("#contactList-table").DataTable({...a,ajax:{...a.ajax,url:route},columns:[...a.columns,{data:"name"},{data:"email"},{data:"phone"},{data:"company"},{data:"state_name"},{data:"city_name"},{data:null,className:"text-right",render:({human_created_at:t,created_dmy:e})=>`<small class="human-date" data-tooltip="Creado ${e}">${t}</small>`}]})});