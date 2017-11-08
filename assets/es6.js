var modulos={};

modulos.tablas=function (){
    alert('soy una tabla');
}

modulos.forms=function (){
    alert('soy forms');
}

modulos.datos=[1,2,3,4,5,6,7,8,9];

modulos.dict={a:1,b:2,c:3,d:4,e:5};


function saluda(){
  $.notify("mensajito prueba",{className: 'info',autoHideDelay: 1500});
    
}

var iife=(function(){
    function saluda(){
        alert('hola mundo');
        
    };
    
    adios=function (){
        alert('adios mundo');
    };
    
    x=function(){
        alert(window.$('#encabezado').html());
    };
    mislibs={};
    mislibs.saluda=saluda;
    mislibs.adios=adios;
    mislibs.x=x;
    mislibs.utilidades={};
    mislibs.utilidades.hacienda='paso firme';
    jQuery.modulos=mislibs;
    
})();

