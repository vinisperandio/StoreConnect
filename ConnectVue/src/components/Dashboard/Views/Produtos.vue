<template>
  <div class="content purple lighten-4">
      <div class="row justify-content-center">
        <div class="col-10">
          <template>

              <v-container fluid grid-list-md >
                <v-layout row wrap>
                  <v-flex v-for="(item, index) in produtos" :key="item.Id" xs6 sm4 px-3 py-2>
                    <v-card>
                      <v-img src="https://cdn.vuetifyjs.com/images/cards/desert.jpg" height="200px">
                        <v-container fill-height fluid pa-2 >
                          <v-layout fill-height>
                            <v-flex xs12 align-end flexbox>
                            </v-flex>
                          </v-layout>
                        </v-container>
                      </v-img>
                      
                      <v-card-title primary-title>
                        <div>
                          <h3 class="headline mb-0">{{ item.Nome }}</h3>
                          <div>Unidades: {{ item.Unidade }} </div>
                          <div>Preço: {{ item.Preco }} </div>
                        </div>
                      </v-card-title>

                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn outline flat color="green" @click="adicionar(item, index)">Comprar</v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-flex>
                </v-layout>
              </v-container>

          </template>
        </div>
      </div>
    </div>
</template>
<script>
  import Card from 'src/components/UIComponents/Cards/Card.vue'

  export default {
    components: {
      Card
    },
    data () {
      return {
        loading: true,
        storage: '',
        numItens: 0,
        produtos: [],
        pedido: [],
        btnDisponibilizar: false
      }
    },
    created () {
      this.storage = JSON.parse(localStorage.getItem('user'))
      this.setAuthorizationToken(this.storage.access_token)
      this.getProdutos()
    },
    methods: {
      getProdutos () {
        this.axios.get('/produto').then(response => {
          this.produtos = response.data.data
        })
      },
      adicionar (item, index) {
        if (item.Unidade > 0) {
          let pos = this.pedido.map(function (e) { return e.id }).indexOf(item.Id)
          if (pos !== -1) {
            this.pedido[pos] = {
              id: item.Id,
              nome: item.Nome,
              preco: parseFloat(item.Preco),
              qtd: this.pedido[pos].qtd + 1
            }
          } else {
            this.pedido.push({
              id: item.Id,
              nome: item.Nome,
              preco: item.Preco,
              qtd: 1
            })
            this.numItens += 1
          }
          this.produtos[index].Unidade -= 1
          this.$ls.set('pedido', this.produtos[index].Unidade)
          this.$emit('content', this.pedido)
        } else {
          this.$swal('Atenção', 'Item sem estoque', 'warning')
        }
      },
      responseError (erro) {
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
<style>
.data {
  text-align: right;
  margin-bottom: 0
}
</style>
