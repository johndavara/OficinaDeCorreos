@extends('principal')
@section('contenido')

<template v-if="menu==0">
<cliente-component></cliente-component>
</template>

<template v-if="menu==1">
    <oficina-component></oficina-component>
</template>

<template v-if="menu==2">
    <paquete-component></paquete-component>
 </template>

<template v-if="menu==3">
    <ruta-component></ruta-component>
</template>

<template v-if="menu==5">
        <ruta-repartidor-component></ruta-repartidor-component>

</template>

@endsection
