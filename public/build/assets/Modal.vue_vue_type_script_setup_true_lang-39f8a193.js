import{d as y,bt as v,aH as f,aM as w,j as p,o as h,c as x,a as t,w as o,A as l,y as b,l as n,bq as c,b as a,n as _,r as k,h as g}from"./app-d47b57c5.js";const C={class:"fixed inset-0 z-50 px-4 py-6 overflow-y-auto sm:px-0","scroll-region":""},B=a("div",{class:"absolute inset-0 bg-black opacity-50"},null,-1),E=[B],V=y({__name:"Modal",props:{show:{type:Boolean,default:!1},maxWidth:{default:"2xl"},closeable:{type:Boolean,default:!0}},emits:["close"],setup(d,{emit:m}){const s=d;v(()=>s.show,()=>{s.show?document.body.style.overflow="hidden":document.body.style.overflow="visible"});const i=()=>{s.closeable&&m("close")},r=e=>{e.key==="Escape"&&s.show&&i()};f(()=>document.addEventListener("keydown",r)),w(()=>{document.removeEventListener("keydown",r),document.body.style.overflow="visible"});const u=p(()=>({sm:"sm:max-w-sm",md:"sm:max-w-md",lg:"sm:max-w-lg",xl:"sm:max-w-xl","2xl":"sm:max-w-2xl"})[s.maxWidth]);return(e,M)=>(h(),x(b,{to:"body"},[t(l,{"leave-active-class":"duration-200"},{default:o(()=>[n(a("div",C,[t(l,{"enter-active-class":"duration-300 ease-out","enter-from-class":"opacity-0","enter-to-class":"opacity-100","leave-active-class":"duration-200 ease-in","leave-from-class":"opacity-100","leave-to-class":"opacity-0"},{default:o(()=>[n(a("div",{class:"fixed inset-0 transition-all transform",onClick:i},E,512),[[c,e.show]])]),_:1}),t(l,{"enter-active-class":"duration-300 ease-out","enter-from-class":"translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95","enter-to-class":"translate-y-0 opacity-100 sm:scale-100","leave-active-class":"duration-200 ease-in","leave-from-class":"translate-y-0 opacity-100 sm:scale-100","leave-to-class":"translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"},{default:o(()=>[n(a("div",{class:_(["mb-6 overflow-hidden transition-all transform bg-white rounded-lg shadow-xl sm:w-full sm:mx-auto",u.value])},[e.show?k(e.$slots,"default",{key:0}):g("",!0)],2),[[c,e.show]])]),_:3})],512),[[c,e.show]])]),_:3})]))}});export{V as _};
