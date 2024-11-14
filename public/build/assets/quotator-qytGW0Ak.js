import{S as n}from"./sweetalert2.esm.all-Br4OTrmy.js";import{a as r}from"./axios-CCb-kr4I.js";document.querySelectorAll("[data-quote-add]").forEach(i=>{i.addEventListener("click",function(){let t=JSON.parse(this.getAttribute("data-quote-add")),e=JSON.parse(localStorage.getItem("products"));e||(e=[]);let a=!1;e=e.map(l=>(l.id===t.id&&(a=!0,l.cant=l.cant+1),l));let o=[...e];a||o.push({...t,cant:1}),console.log(o),localStorage.setItem("products",JSON.stringify(o)),n.mixin({toast:!0,position:"bottom",showConfirmButton:!1,timer:4e3,timerProgressBar:!0,didOpen:l=>{l.addEventListener("mouseenter",n.stopTimer),l.addEventListener("mouseleave",n.resumeTimer)}}).fire({icon:"success",title:`${t.title} agregado al cotizador`}),document.getElementById("link_quotation").classList.remove("empty")})});if(document.getElementById("quotation-table"))if(JSON.parse(localStorage.getItem("products"))&&JSON.parse(localStorage.getItem("products")).length>0){let i=JSON.parse(localStorage.getItem("products")),t="";i.map((e,a)=>{t+=`<tr data-quote-tr_index="${a}">
                <td class="pt-3">
                    <div class="position-relative mb-1 w-75 p-0 mx-auto">
                        <input type="hidden" name="id[]" value="${e.id}">
                        <label class="form-label" style="left:23px">Cant</label>
                        <input data-quote-update="${e.id}"
                            name="qty[${e.id}][]"
                            class="form-control text-center"
                            type="number"
                            min="1"
                            value="${e.cant}"
                            required
                        >
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <img width="60"
                                height="60"
                                class="img-fluid"
                                src="${e.image}"
                                alt="Vista previa"
                            >
                        </div>
                        <div>
                            <strong>${e.model}</strong><br>
                            <small>${e.title}</small>
                        </div>
                    </div>
                </td>
                <td class="pt-3">
                    <button data-quote-remove="${e.id}"
                        data-quote-index="${a}"
                        data-bs-toggle="tooltip"
                        title="Quitar producto del cotizador"
                        class="btn btn-danger"
                    >
                        <i class="bi bi-trash text-white"></i>
                    </button>
                </td>
            </tr>`}),document.getElementById("quotation-table").innerHTML=t}else document.getElementById("send_form").setAttribute("hidden","hidden"),document.getElementById("quotation-table").innerHTML=`<tr>
            <td>
                <div class="alert alert-warning" role="alert">
                    Aún no has agregado productos al cotizador.
                </div>
            </td>
        </tr>`;document.querySelectorAll("[data-quote-update]").forEach(i=>{i.addEventListener("change",function(){let t=parseInt(this.getAttribute("data-quote-update")),e=parseInt(this.value),a=JSON.parse(localStorage.getItem("products"));a=a.map(o=>(parseInt(o.id)===t&&(o.cant=e),o)),localStorage.setItem("products",JSON.stringify(a))})});document.querySelectorAll("[data-quote-remove]").forEach(i=>{i.addEventListener("click",function(){let t=parseInt(this.getAttribute("data-quote-remove")),e=parseInt(this.getAttribute("data-quote-index")),a=JSON.parse(localStorage.getItem("products"));a=a.filter(o=>{if(parseInt(o.id)!==t)return console.log(o.id,t,parseInt(o.id)!==t),o}),document.querySelector('[data-quote-tr_index="'+e+'"]').remove(),localStorage.setItem("products",JSON.stringify(a)),document.getElementById("quotation-table").querySelectorAll("tr").length===0&&location.reload()})});$(document).ready(function(){$("#email").on("focusout",function(i){r.post("/contacto/find",{email:$(this).val()}).then(({data:t})=>{t&&($("#uuid").val(t.uuid),$("#name").val(t.name),$("#phone").val(t.phone),$("#company").val(t.company),$("#state_id").val(t.state_id).change())}).catch(t=>console.error(t))})});
