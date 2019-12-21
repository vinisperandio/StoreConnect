<template>
  <div class="sidebar"
      :style="sidebarStyle"
      :data-color="backgroundColor">
    <div class="sidebar-wrapper" id="style">
      <div class="logo" style="height: 50px;">
        <a href="#/" class="simple-text">
          <img class="ml-2" height="" width="140" src="static/img/Educampo-branca.png" alt="">
        </a>
      </div>

      <slot name="content"></slot>
      <ul class="nav">
        <!--By default vue-router adds an active class to each route link. This way the links are colored when clicked-->
        <slot>
          <sidebar-link v-for="(link,index) in sidebarLinks"
                        :key="link.name + index"
                        :to="link.path"
                        @click="closeNavbar"
                        :link="link">
            <i :class="link.icon"></i>
            <p>{{link.name}}</p>
          </sidebar-link>
        </slot>
      </ul>
    </div>
  </div>
</template>
<script>
  import SidebarLink from './SidebarLink.vue'

  export default {
    components: {
      SidebarLink
    },
    props: {
      title: {
        type: String,
        default: 'Educampo'
      },
      backgroundColor: {
        type: String,
        default: 'colorEducampo',
        validator: (value) => {
          let acceptedValues = ['', 'blue', 'azure', 'green', 'orange', 'red', 'purple', 'black', 'colorEducampo']
          return acceptedValues.indexOf(value) !== -1
        }
      },
      backgroundImage: {
        type: String,
        default: 'static/img/design-sidebar.png'
      },
      activeColor: {
        type: String,
        default: 'success',
        validator: (value) => {
          let acceptedValues = ['primary', 'info', 'success', 'warning', 'danger']
          return acceptedValues.indexOf(value) !== -1
        }
      },
      sidebarLinks: {
        type: Array,
        default: () => []
      },
      autoClose: {
        type: Boolean,
        default: true
      }
    },
    provide () {
      return {
        autoClose: this.autoClose
      }
    },
    computed: {
      sidebarStyle () {
        return {
          backgroundImage: `url(${this.backgroundImage})`
        }
      }
    }
  }

</script>
<style>

#style::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
	border-radius: 10px;
}

#style::-webkit-scrollbar
{
	width: 10px;
	background-color: #F5F5F5;
}

#style::-webkit-scrollbar-thumb
{
	border-radius: 10px;
	background-color: #136dc2e0;
}

.sidebar .logo .simple-text .logo-img img, body > .navbar-collapse .logo .simple-text .logo-img img {
    max-width: 500px;
}

.sidebar:before, body > .navbar-collapse:before {
    opacity: 0.1;
}
.sidebar[data-image]:after, .sidebar.has-image:after, body > .navbar-collapse[data-image]:after, body > .navbar-collapse.has-image:after {
    opacity: 0.1;
}

.sidebar, body > .navbar-collapse {
  background-size: cover;
  background-position: right
}
</style>
