import{D as o}from"./common-Bm_rDy6i.js";import{A as s}from"./alerts-ClLvi9ZR.js";import{a as c}from"./axios-CCb-kr4I.js";import"./sweetalert2.esm.all-Br4OTrmy.js";const d=e=>{e?$("[data-loader]").removeClass("hidden"):$("[data-loader]").addClass("hidden")};$(document).ready(function(){$(document).on("click","#btn-filter",function(e){e.preventDefault(),$("#productFreights-table").removeClass("hidden").addClass("display"),$("#productFreights-table").DataTable().destroy(),d(!0);let a={product_brand_id:$("#product_brand_id").val()||null,product_category_id:$("#product_category_id").val()||null,product_subcategory_id:$("#product_subcategory_id").val()||null,is_featured:$("#is_featured").is(":checked")?1:0,with_freight:$("#with_freight").is(":checked")?1:0};$("#productFreights-table").DataTable({...o,pageLength:-1,ajax:{...o.ajax,url:url_route,data:a,error:i=>{$("#btn-update").removeClass("display").addClass("hidden"),d(!1),s.error("Lo sentimos, la tabla no pudo ser cargada","Es necesario contactar a un administrador.")}},columns:[...o.columns,{data:"title"},{data:"category"},{data:"subcategory"},{data:"brand"},{data:"old_freight",className:"text-center"},{data:"new_freight",className:"text-center"}],drawCallback:i=>{$("#freight_change_controller").removeClass("hidden").addClass("display"),$("#btn-update-wrapper").removeClass("hidden").addClass("display"),d(!1)}})}),$(document).on("click","#btn-change-freights",function(e){e.preventDefault(),$.each($('[data-freight-type="new_freight"]'),function(a){switch($("#change_type").val()){case"with_freight":$(this).prop("checked",!0);break;default:$(this).prop("checked",!1);break}})}),$(document).on("click","#btn-update",function(e){e.preventDefault(),d(!0);let a=[];$.each($('[data-freight-type="new_freight"]'),function(i){let t=$(this).attr("data-original-id"),r=$(this).is(":checked")?1:0;a.push({id:t,with_freight:r})}),s.confirm(`Vas a actualizar ${a.length} productos, esta acción no se podrá revertir`,i=>{c.post(update_massive_route,{dataset:a}).then(({status:t,data:r})=>{if(r.success){$("#btn-filter").click(),s.success(r.message);return}s.error(r.message)}).catch(t=>{s.error(t.code+": "+t.message,"Lo sentimos, no se pudieron actualizar los fletes.")}).finally(()=>d(!1))})})});