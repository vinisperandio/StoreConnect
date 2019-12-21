<template>
  <v-app id="inspire">
    <v-content class="purple lighten-2">
      <v-container v-if="!dialog" fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md8>
            <v-card class="elevation-12">
              <v-toolbar dark color="blue darken-1">
                <v-toolbar-title>Bem vindo a nossa loja, aqui o seu dinheiro é bem vindo \o/</v-toolbar-title>
                <v-spacer></v-spacer>
              </v-toolbar>
              <v-card-text>
                <v-form v-model="valid" ref="form_login" id="form_login" @submit.prevent="submitLogin">
                  <v-text-field v-model="email" :rules="emailRules" prepend-icon="person" name="login" label="Login" type="text"></v-text-field>
                  <v-text-field v-model="senha" :rules="requiredRules" id="password" prepend-icon="lock" name="password" label="Password" type="password"></v-text-field>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn :disabled="loader" outline flat color="primary" @click="dialog=true">Cadastrar</v-btn>
                <v-btn :loading="loader" outline flat color="green" form="form_login" type="submit">Entrar</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
        <v-snackbar
          multi-line
          top
          v-model="snackbar"
          :timeout="3500"
          color=error>{{message}}
          <v-btn dark flat @click="snackbar = false">Fechar</v-btn>
        </v-snackbar>
      </v-container>
      <v-container else fluid fill-height>
        <v-layout align-center justify-center>
          <v-dialog v-model="dialog" width="600">
          <v-card>
            <v-card-title>
              <span class="headline">Novo Cadastro</span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-form v-model="valid" ref="form_cad" id="form_cad" @submit.prevent="salvar">
                  <v-layout wrap>
                    <v-flex xs12>
                      <v-text-field label="Nome*" v-model="cliente.nome" required></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                      <v-text-field label="Email*" v-model="cliente.email" required></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                      <v-text-field label="Senha*" v-model="cliente.senha" type="password" required></v-text-field>
                    </v-flex>
                  </v-layout>
                </v-form>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn outline color="red darken-1" flat @click="cancelar">Cancelar</v-btn>
              <v-btn outline :loading="salvando" color="blue darken-1" flat form="form_cad" type="submit">cadastrar</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        
        </v-layout>
      </v-container>
    </v-content>
    
  </v-app>
</template>
<script>
export default {
  data () {
    return {
      email: null, // 'consultorleitedinni@educampo.com.br',
      senha: null, // 12345678,
      emailRules: [ v => /.+@.+/.test(v) || '' ],
      requiredRules: [v => !!v || ''],
      user: null,
      dialog: false,
      snackbar: false,
      message: '',
      loader: false,
      salvando: false,
      valid: null,
      cliente: {
        nome: null,
        senha: null,
        email: null
      }
    }
  },
  props: {
    backgroundImage: {
      type: String,
      default: 'static/img/login-banner.jpg'
    }
  },
  created () {
    localStorage.clear()
    this.axios.defaults.headers.common['Authorization'] = ''
  },
  computed: {
    sidebarStyle () {
      return {
        backgroundImage: `url(${this.backgroundImage})`
      }
    },
    loading () {
      this.loader = !this.loader
    }
  },
  methods: {
    submitLogin () {
      if (!this.valid) {
        this.message = 'Email ou Senha incorretos'
        // this.snackbar = true
      } else {
        this.loading
        this.axios.post('/login', {'email': this.email, 'senha': this.senha}).then(response => {
          if (response.data.error) {
            this.responseError(response.data.message)
          } else {
            this.user = response.data.user
            this.setAuthorizationToken(this.user.access_token)
            localStorage.setItem('user', JSON.stringify(this.user))
            this.email = ''
            this.password = ''
            this.$router.push('/')
          }
          this.loader = false
        }).catch(error => {
          this.message = error.response.data.message
          this.loader = false
          this.snackbar = true
        })
      }
    },
    cancelar () {
      this.dialog = false
      this.resetVar()
    },
    resetVar () {
      this.cliente.nome = null
      this.cliente.email = null
      this.cliente.senha = null
    },
    salvar () {
      this.salvando = true
      this.axios.post('/cliente/save', this.cliente).then(response => {
        if (response.data.error) {
          this.responseError(response.data.message)
        } else {
          this.$swal({
            title: 'Cadastro realizado com sucesso',
            type: 'success',
            timer: 1000
          })
          this.dialog = false
          this.resetVar()
        }
        this.salvando = false
      }).catch(error => {
        this.salvando = false
        this.message = error.response.data.data
        this.loader = false
        this.snackbar = true
      })
    },
    responseError (erro) {
      console.log(erro)
      let erros = ''
      erro.forEach((el) => {
        erros += el + '<br/>'
      })
      this.$swal({
        title: 'Corrija os erros abaixo:',
        type: 'error',
        html: erros
      })
    },
    setAuthorizationToken ($token) {
      this.axios.defaults.headers.common['Authorization'] = $token
    }
  }
}
</script>
<style scope lang="scss">
html {
  overflow: hidden;
}
</style>