import{S as t}from"./sweetalert2.esm.all-Br4OTrmy.js";import{a as n}from"./axios-CCb-kr4I.js";const i=n.create({headers:{"X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")}});document.querySelectorAll(".blog__view__link").forEach(r=>{r.addEventListener("click",function(){document.getElementById("load8").removeAttribute("hidden"),document.getElementById("porfolio_modal").querySelector(".modal-dialog").innerHTML="",i.get(this.getAttribute("href")).then(({data:e})=>{document.getElementById("porfolio_modal").querySelector(".modal-dialog").innerHTML=e,document.getElementById("load8").setAttribute("hidden","hidden")}).catch(e=>{console.error(e),document.getElementById("load8").setAttribute("hidden","hidden"),t.mixin({toast:!0,position:"bottom",showConfirmButton:!1,timer:4e3,timerProgressBar:!0,didOpen:o=>{o.addEventListener("mouseenter",t.stopTimer),o.addEventListener("mouseleave",t.resumeTimer)}}).fire({icon:"error",title:"Lo sentimos un error impidió abrir el proyecto"})})})});
