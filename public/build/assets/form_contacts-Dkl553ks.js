import{n}from"./common-Bm_rDy6i.js";import{A as m}from"./alerts-ClLvi9ZR.js";import"./sweetalert2.esm.all-Br4OTrmy.js";$(document).ready(function(){const l=e=>{let a=0,t=0;$("[data-product_id]").each((o,u)=>{let d=$(u).data("product_id"),i=$('[name="quotation.in_stock['+d+']"]').val()==="1",s=$('[name="quotation.is_deleted['+d+']"]').val()==="1";if(!i||s)return;let r=parseFloat($('[name="quotation.quantity['+d+']"]').val()),c=parseFloat($('[name="quotation.total['+d+']"]').val()),p=parseFloat($('[name="quotation.original['+d+']"]').val()),h=r*c;a+=h,t+=p,$('[data-update-amount="'+d+'"]').text(`$${n(h)}`)}),console.log(t),$("[data-original-price]").text(`$${n(t)}`),$("[data-gran-total]").text(`$${n(a)}`)};$(document).on("change",'[data-table="quantity"]',function(e){l()}),$(document).on("click","[data-no-stock]",function(e){e.preventDefault();const a=$(this).attr("data-no-stock"),t=$(this);m.confirm(`El producto ${a} será marcado sin existencias y no podrá ser restaurado en la cotización.`,o=>{t.remove(),$('[data-product_id="'+a+'"]').addClass("bg-red-50"),$('[data-if-not-stock="'+a+'"]').html(""),$('[data-delete="'+a+'"]').remove(),$('[data-restore="'+a+'"]').remove(),$('[name="quotation.in_stock['+a+']"]').val(0),$('[name="quotation.is_deleted['+a+']"]').val(1),l()})}),$(document).on("click","[data-delete]",function(e){e.preventDefault();const a=$(this).attr("data-delete"),t=$(this);m.confirm(`El producto ${a} será eliminado de la cotización.`,o=>{t.addClass("hidden"),$('[data-restore="'+a+'"]').removeClass("hidden"),$('[data-product_id="'+a+'"]').addClass("bg-red-100"),$('[name="quotation.quantity['+a+']"]').attr("readonly","readonly"),$('[name="quotation.is_deleted['+a+']"]').val(1),l()})}),$(document).on("click","[data-restore]",function(e){e.preventDefault();const a=$(this).attr("data-restore"),t=$(this);m.confirm(`Se restaurará el producto ${a} en la cotización.`,o=>{t.addClass("hidden"),$('[data-delete="'+a+'"]').removeClass("hidden"),$('[data-product_id="'+a+'"]').removeClass("bg-red-100"),$('[name="quotation.quantity['+a+']"]').removeAttr("readonly"),$('[name="quotation.is_deleted['+a+']"]').val(0),l()})}),$("#send_whatsapp").on("click",function(e){let a=$('[data-field="contact_phone"] > input').val(),t=$('[data-field="contact_name"] > input').val(),o="";$(".quotation > tr:not(.ignore)").each((d,i)=>{let s=$('[name="quotation.in_stock['+$(i).data("product_id")+']"]').val()==="1",r=$('[name="quotation.is_deleted['+$(i).data("product_id")+']"').val()==="1",c=$(i).find('[data-table="quantity"]').val();(!s||r)&&(c="0");let p=$(i).find('[data-table="title"]').text();o+=`${c} x ${p}${!s||r?" (No disponible)":""}
`}),o=encodeURI(o.replaceAll("&","").replaceAll("%","").replaceAll("?",""));let u=`https://api.whatsapp.com/send?phone=521${a}&text=Estimado/a%20${t}%0A%0A¡Gracias%20por%20contactar%20a%20Equi-par%20y%20por%20tu%20interés%20en%20nuestros%20productos!%20Antes%20de%20enviarte%20la%20cotización%20final,%20queremos%20asegurarnos%20de%20que%20la%20información%20proporcionada%20sea%20correcta%20y%20confirmar%20algunos%20detalles%20contigo.%0A%0AAdjunto%20encontrarás%20un%20resumen%20de%20los%20productos%20que%20has%20solicitado.%20Además,%20queremos%20informarte%20que%20algunos%20de%20ellos%20podrían%20no%20estar%20disponibles%20en%20este%20momento.%20Sin%20embargo,%20contamos%20con%20opciones%20similares%20que%20cumplen%20con%20las%20mismas%20características%20y%20que%20podrían%20interesarte.%0A%0A${o}%0APor%20favor,%20revisa%20la%20información%20y%20confírmanos%20si%20todo%20es%20correcto%20o%20si%20deseas%20considerar%20las%20alternativas%20que%20podemos%20ofrecerte.%20Estaremos%20encantados%20de%20ajustarnos%20a%20tus%20necesidades.%0A%0AQuedamos%20atentos%20a%20tu%20respuesta.`;window.open(u,"_blank")}),$(document).on("keydown","#search_title",function(e){e.key==="Enter"&&(e.preventDefault(),$("[data-search-product]").click())}),$(document).on("click","[data-search-product]",function(e){e.preventDefault(),$(this).find(".working").removeClass("hidden"),$(this).find(".static").addClass("hidden"),$("#results").html('<option selected="" disabled>Selecciona uno de la lista</option>'),axios.post("/productos/autocomplete",{query:$("#search_title").val()}).then(({data:a})=>{a||($('[data-show="results_not_found"]').removeClass("hidden"),$('[data-show="results_found"]').addClass("hidden")),$('[data-show="results_not_found"]').addClass("hidden"),$('[data-show="results_found"]').removeClass("hidden"),a.sort((t,o)=>t.title.localeCompare(o.title)),a.forEach(t=>{$("#results").append(`<option value="${t.id}"
                                                    data-title="${t.title}"
                                                    data-original_price="${t.price}"
                                                    data-discount="${t.discount}"
                                                    data-total="${t.final_price}"
                                                    data-with_freight="${t.con_flete}"
                                                    data-title="${t.title}"
                                                    data-model="${t.model}"
                                                    data-brand="${t.brand}"
                                                    data-image="${t.image_path}"
                    >(${t.id}) ${t.brand} :: ${t.title} | $${n(t.final_price)}<option>`)})}).catch(a=>console.error(a)).finally(a=>{$(this).find(".working").addClass("hidden"),$(this).find(".static").removeClass("hidden")})}),$(document).on("click","#add_new_product_to_quota",function(e){e.preventDefault();let a=$("#results > option:selected"),t=a.val(),o=$("#new_quantity").val();$("tbody.quotation tr.totales").before(`<tr class="border-b border-neutral-200" data-product_id="${t}">
            <td class="px-3 py-2 text-right">
                <button type="button" data-tooltip="Marcar sin existencia" data-no-stock="${t}">🔴</button>
                <small>${t}</small>
                <input type="hidden" name="quotation.product_id[]" value="${t}">
                <input type="hidden" name="quotation.original[${t}]" value="${a.data("original_price")}">
                <input type="hidden" name="quotation.discount[${t}]" value="${a.data("discount")}">
                <input type="hidden" name="quotation.total[${t}]" value="${a.data("total")}">
                <input type="hidden" name="quotation.in_stock[${t}]" value="1">
                <input type="hidden" name="quotation.is_deleted[${t}]" value="0">
                <input type="hidden" name="quotation.add_after[${t}]" value="1">
                <input type="hidden" name="quotation.title[${t}]" value="${a.data("title")}">
                <input type="hidden" name="quotation.model[${t}]" value="${a.data("model")}">
                <input type="hidden" name="quotation.brand[${t}]" value="${a.data("brand")}">
                <input type="hidden" name="quotation.image[${t}]" value="${a.data("image")}">
            </td>
            <td class="px-3 py-2" style="max-width: 430px">
                <small data-table="title">${a.data("title")}</small>
            </td>
            <td class="px-3 py-2" data-if-not-stock="${t}">
                <small>No disponible</small>
            </td>
            <td class="px-3 py-2 text-right" data-if-not-stock="${t}">
                <input data-table="quantity" type="number" min="1" name="quotation.quantity[${t}]" value="${o}" class="block pt-3 pb-2 p-2 mt-0 bg-white border-0 border-b-2 border-violet-100 rounded appearance-none focus:outline-none focus:ring-0 focus:border-violet-700 text-right" style="max-width: 80px;">
            </td>
            <td class="px-3 py-2 text-right" data-if-not-stock="${t}">$${n(a.data("original_price"))}</td>
            <td class="px-3 py-2 text-right" data-if-not-stock="${t}">$${n(a.data("discount"))}</td>
            <td class="px-3 py-2 text-right" data-if-not-stock="${t}">$${n(a.data("total"))}</td>
            <td class="px-3 py-2 text-right" data-if-not-stock="${t}" data-update-amount="${t}">$${n(o*a.data("total"))}</td>
            <td class="text-center">
                <button class="text-red-500" data-tooltip="Eliminar de la cotización" data-delete="${t}">
                    <i class="fa-solid fa-trash"></i>
                </button>
                <button class="text-sky-500 hidden" data-tooltip="Restaurar en la cotización" data-restore="${t}">
                    <i class="fa-solid fa-trash-restore"></i>
                </button>
            </td>
        </tr>`),a.remove(),$("#results").val(null),$("#new_quantity").val(1),l()})});
