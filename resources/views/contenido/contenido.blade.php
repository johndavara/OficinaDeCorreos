@extends('principal')
@section('contenido')
<template v-if="menu==0">
<example-component></example-component>
</template>

<template v-if="menu==1">
    <h1>Oficinas</h1>
</template>

<template v-if="menu==2">
    <h1>Paquetes</h1>
 </template>

<template v-if="menu==3">
   <h1>Rutas</h1>
</template>
@endsection
