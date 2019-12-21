<template>
  <transition name="fade" mode="out-in">
    <router-view v-on:content='enviaDash'></router-view>
  </transition>
</template>
<script>
  export default {
    methods: {
      enviaDash (itens) {
        this.$emit('enviaDash', itens)
      }
    }
  }
</script>
<style>
  .main-panel {
    width: 100%!important;
  }

  html{
    overflow: hidden;
  }

  @font-face {
    font-family: Campton;
    src: url(/static/fonts/subset-Campton-Black/woff) format(woff),
        url(/static/fonts/subset-Campton-Black/woff2) format(woff2);
  }

  h1, h2, h3, h4, a, p {
    font-family: 'Campton', sans-serif;
  }

/*   a {
    font-family: 'Campton', sans-serif;
  } */

  .texto-title{
    margin: 0;
    line-height: 31px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    display: inline-flex;
    opacity: 0.96;
  }

  .fade-enter-active,
  .fade-leave-active {
    transition: opacity .1s
  }

  .fade-enter,
  .fade-leave-to
    /* .fade-leave-active in <2.1.8 */
  {
opacity: 0
  }

  .btn-change {
    position: sticky;
    left: 8px;
  }
  .card {
    border-color: rgba(0, 0, 0, 0.225);
  }

  .card-flat {
    border-color: rgba(0, 0, 0, 0.225);
    border-top: 3px solid #c7c4c4;
  }

  .card-info {
/*     border-color: rgba(0, 0, 0, 0.225); */
    border-top: 3px solid #1274b4;
  }
  .card-warn {
/*     border-color: rgba(0, 0, 0, 0.225); */
    border-top: 3px solid #ffc107;
  }

  .card-error {
/*     border-color: rgba(0, 0, 0, 0.225); */
    border-top: 3px solid #fb0000;
  }

  .card-success {
    border-color: rgba(0, 0, 0, 0.225);
    border-top: 3px solid #28a745;
  }
  .error--text {
    color: #fb0000 !important;
    caret-color: #fd0000 !important;
  }
  .card .card-title {
    margin: 0;
    color: #333333;
    font-weight: 500;
}

.card .card-category, .card label {
    color: rgba(0, 0, 0, 0.87);
}

.v-dialog{
  overflow-y: none;
}

.v-dialog.v-dialog--active {
  z-index: initial;
}

.label{
  opacity: 0.87;
  font-family: 'Roboto', sans-serif;
  font-weight: 400;
  font-size: 12.4px;
  margin-top: 2px;
}

.custom-control-inline {
    margin-right: 0px;
}
/*
.main-panel {
  background: rgba(187, 187, 187, 0.61)
}

.navbar {
  background-color: #005dab
}

.navbar .navbar-nav .nav-item .nav-link {
    color:white;
    font-weight: 400
}
*/

.navbar .navbar-toggler .burger-lines {
  background-color: black
}

.navbar .navbar-nav .notification{
  line-height: 14px;
}

footer {
  left: 0;
  bottom: 0;
}

.fixed-bottom {
    position: static;
}

.Underline>.v-input__control>.v-input__slot:before{
  border-style: hidden;
}

input[type='file'] {
  display: none
}

/* Aparência que terá o seletor de arquivo */
#foto {
  background-color: #3498db;
  border-radius: 5px;
  color: #fff;
  cursor: pointer;
  padding: 6px 20px
}

.form-control{
  border: 1px solid rgb(169, 169, 169)
}

.v-text-field--box .v-input__slot,
.v-text-field--outline .v-input__slot {
  min-height: auto!important;
  display: flex!important;
  align-items: center!important;
}

.stroke-transparent {
 -webkit-text-stroke: 1px #FFF;
 -webkit-text-fill-color: transparent;
}

.notice {
    padding: 8px 15px 2px 15px;
    background-color: #fafafa;
    border-left: 6px solid #b8b8b9;
    margin-bottom: 10px;
    -webkit-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
       -moz-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
            box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
}
.notice-sm {
    padding: 10px;
    font-size: 80%;
}
.notice-lg {
    padding: 35px;
    font-size: large;
}
.notice-success {
    border-color: #80D651;
}
.notice-success>strong {
    color: #80D651;
}
.notice-info {
    border-color: #45ABCD;
}
.notice-info>strong {
    color: #45ABCD;
}
.notice-warning {
    border-color: #FEAF20;
}
.notice-warning>strong {
    color: #FEAF20;
}
.notice-danger {
    border-color: #d73814;
}
.notice-danger>strong {
    color: #d73814;
}

.v-dialog.v-dialog--active.v-dialog--fullscreen::-webkit-scrollbar-track{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
	border-radius: 10px;
}

.v-dialog.v-dialog--active.v-dialog--fullscreen::-webkit-scrollbar{
	width: 8px;
	background-color: #F5F5F5;
}

.v-dialog.v-dialog--active.v-dialog--fullscreen::-webkit-scrollbar-thumb{
	border-radius: 10px;
	background-color: rgb(179, 179, 184);
}

</style>
