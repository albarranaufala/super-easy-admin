import{d as N,T as R,o as a,g as s,a as e,u as m,w as l,F as i,Z as V,b as t,f as x,k as c,e as $,c as A,n as B,t as F}from"./app-d47b57c5.js";import{_ as O}from"./AuthenticatedLayout.vue_vue_type_script_setup_true_lang-f9f02b0e.js";import{_ as S}from"./TextInput.vue_vue_type_script_setup_true_lang-045f4316.js";import{_,a as D}from"./InputLabel.vue_vue_type_script_setup_true_lang-de433851.js";import{_ as H,C as v,a as g}from"./Breadcrumb.vue_vue_type_script_setup_true_lang-34d729bc.js";import{C as k}from"./CardHeader-d4e92317.js";import{F as b}from"./FormGroup-33d65c6b.js";import{_ as w}from"./Checkbox.vue_vue_type_script_setup_true_lang-25c89828.js";import{_ as I}from"./PrimaryButton.vue_vue_type_script_setup_true_lang-862cfd90.js";import{_ as P}from"./SecondaryButton.vue_vue_type_script_setup_true_lang-763082ad.js";import"./ApplicationLogo-05667216.js";import"./_plugin-vue_export-helper-c27b6911.js";const T=t("h1",{class:"text-xl font-semibold leading-tight text-gray-800"}," Add New Role ",-1),U=t("h2",{class:"text-lg font-semibold"},"Role Information",-1),z=t("h2",{class:"text-lg font-semibold"},"Role Permissions",-1),E={class:"py-3"},G={class:"font-medium"},L={class:"flex mt-6"},M={class:"mr-6"},Z={class:"mr-6"},ne=N({__name:"Create",props:{modules:{}},setup(q){const d=R({name:"",permissions:[]}),C=[{name:"View",types:[{name:"All"},{name:"Owned"}]},{name:"Create"},{name:"Update",types:[{name:"All"},{name:"Owned"}]},{name:"Delete",types:[{name:"All"},{name:"Owned"}]}];return(n,u)=>(a(),s(i,null,[e(m(V),{title:"Add New Role"}),e(O,null,{default:l(()=>[T,e(H,{links:[{name:"Home",href:n.route("dashboard")},{name:"Roles",href:n.route("roles.index")},{name:"Add New Role",href:n.route("roles.create")}],class:"mt-2"},null,8,["links"]),e(v,{class:"mt-6 lg:mt-8"},{default:l(()=>[e(k,null,{default:l(()=>[U]),_:1}),e(g,null,{default:l(()=>[t("form",{onSubmit:u[1]||(u[1]=x(o=>m(d).post(n.route("roles.store")),["prevent"]))},[e(b,null,{label:l(()=>[e(_,{for:"name",value:"Role Name"})]),input:l(()=>[e(S,{id:"name",modelValue:m(d).name,"onUpdate:modelValue":u[0]||(u[0]=o=>m(d).name=o),placeholder:"Input role name",class:"w-full"},null,8,["modelValue"]),e(D,{message:m(d).errors.name},null,8,["message"])]),_:1})],32)]),_:1})]),_:1}),e(v,{class:"mt-6 lg:mt-8"},{default:l(()=>[e(k,null,{default:l(()=>[z]),_:1}),e(g,null,{default:l(()=>[(a(!0),s(i,null,c(n.modules,(o,y)=>(a(),A(b,{class:B({"mt-6":y!==0})},{label:l(()=>[e(_,{value:o.name},null,8,["value"])]),input:l(()=>[(a(),s(i,null,c(C,(h,f)=>t("div",E,[t("p",G,F(h.name),1),t("div",L,[(a(!0),s(i,null,c(h.types,(p,r)=>(a(),s("div",M,[e(w,{id:`check${f}-${r}`,checked:!1},null,8,["id"]),e(_,{for:`check${f}-${r}`,value:p.name,class:"inline-block ml-3 align-middle"},null,8,["for","value"])]))),256)),(a(!0),s(i,null,c(o.fillable_attributes,(p,r)=>(a(),s("div",Z,[e(w,{id:`check${f}-${r}`,checked:!1},null,8,["id"]),e(_,{for:`check${f}-${r}`,value:p.name,class:"inline-block ml-3 align-middle"},null,8,["for","value"])]))),256))])])),64))]),_:2},1032,["class"]))),256))]),_:1})]),_:1}),e(P,{href:n.route("roles.index"),class:"mt-6 mr-4"},{default:l(()=>[$(" Cancel ")]),_:1},8,["href"]),e(I,{class:"mt-6"},{default:l(()=>[$(" Save New Role ")]),_:1})]),_:1})],64))}});export{ne as default};
