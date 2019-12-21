<template>
  <div class="wrapper">
    <div class="main-panel" id="style-scroll">
      <nav class="navbar navbar-expand-sm teal lighten-2">
        <v-btn @click="meusPedidos">Meus Pedidos</v-btn>
        <div class="container-fluid">
          <a class="navbar-brand" href="#"></a>
          <button type="button"
                  class="navbar-toggler navbar-toggler-right"
                  aria-controls="navigation-index"
                  aria-expanded="false"
                  aria-label="Toggle navigation">
            <span class="navbar-toggler-bar burger-lines"></span>
            <span class="navbar-toggler-bar burger-lines"></span>
            <span class="navbar-toggler-bar burger-lines"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" @click="edit" style="font-family: 'Poppins', sans-serif; color: azure;">
                  Olá, {{cliente.nome}}
                </a>
              </li>
              <li class="nav-item">
                <v-btn flat @click="abreCarrinho">
                  <v-badge v-model="show" color="pink" left>
                    <template v-slot:badge>
                      <span>!</span>
                    </template>
                    <v-icon style="color: azure">local_grocery_store</v-icon>
                  </v-badge>
                </v-btn>
              </li>
              <li>
                <v-icon></v-icon>
              </li>
              <li class="nav-item">
                <a href="#/login" class="nav-link" style="font-family: 'Poppins', sans-serif; color: azure;">
                  Sair
                </a>
              </li>
            </ul>
          </div>
        </div>
        <div class="text-xs-center">
        <v-dialog v-model="dialog" width="600">
          <v-card>
            <v-card-title>
              <span class="headline">Editar Cadastro</span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
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
              </v-container>
              <small class="pl-3">*Você é nosso cliente desde {{cliente.dataCadastro | formatDate}} </small>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn outline flat :loading="salvando" color="red darken-1" @click="dialog = false">Cancelar</v-btn>
              <v-btn outline flat :loading="salvando" color="green darken-1" @click="salvar">Salvar</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        
        <v-dialog v-model="carrinho" width="600">
          <v-card>
            <v-card-title>
              <span class="headline">Carrinho de compra</span>
            </v-card-title>
            <v-card-text>
              <v-data-table
                :headers="headers"
                :items="pedido"
                item-key="id"
                class="elevation-1">
                <template v-slot:items="props">
                  <td class="text-xs-left">{{ props.item.nome }}</td>
                  <td class="text-xs-left">{{ props.item.qtd }}</td>
                  <td class="text-xs-left">R$ {{ props.item.preco * props.item.qtd }}</td>
                  <td class="justify-center layout px-0">
                    <v-icon small @click="deleteItem(props.item)">delete</v-icon>
                  </td>
                </template>
              </v-data-table>
            </v-card-text>
            <v-card-actions class="justify-center">
              <v-btn outline flat :loading="salvando" color="green darken-1" @click="fecharPedido">Finalizar Pedido</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>

        <v-dialog v-model="dialogPedido" width="700">
          <v-card>
            <v-card-title>
              <span class="headline">Meus Pedidos</span>
            </v-card-title>
            <v-card-text>
              <v-data-table
              :headers="headersPedidoGeral"
              :items="pedidosOLD"
              item-key="Id"
              class="elevation-1 mt-2">
              <v-progress-linear v-slot:progress  indeterminate></v-progress-linear>
              <template v-slot:items="props" >
                <tr :active="props.selected" @click="loadDetails(props)">
                  <td >{{ props.item.Id }}</td>
                  <td style="text-align: center">{{ props.item.Data_pedido | formatDateTime }}</td>
                  <td style="text-align: right">R$ {{ props.item.Valor_total }}</td>
                </tr>
              </template>
              <template v-slot:expand="props">
                <v-data-table
                    :headers="headersPedidoEspecifico"
                    :items="details"
                    item-key="Id"
                    class="tbl-details">
                    <v-progress-linear v-slot:progress indeterminate class="progress-details"></v-progress-linear>
                    <template v-slot:items="props" >
                      <tr>
                        <td >{{ props.item.Nome }}</td>
                        <td style="text-align: center">{{ props.item.Qtd }}</td>
                        <td style="text-align: right">R$ {{ props.item.Preco }}</td>
                      </tr>
                    </template>
                </v-data-table>
                </template>
            </v-data-table>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" outline flat @click="dialogPedido = false">Fechar</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>

      </div>
      </nav>
      <dashboard-content v-on:enviaDash='itensPedidos'></dashboard-content>
    </div>
  </div>
</template>

<script>
  import DashboardContent from './Content.vue'

  export default {
    components: {
      DashboardContent
    },
    data () {
      return {
        show: false,
        carrinho: false,
        userLogado: '',
        dialog: false,
        dialogPedido: false,
        pedido: [],
        pedidosOLD: [],
        details: null,
        storage: '',
        salvando: false,
        auxNotificacao: null,
        cliente: {
          id: null,
          nome: null,
          senha: null,
          email: null
        },
        headers: [
          { align: 'left', text: 'Nome', value: 'nome' },
          { align: 'left', text: 'Quantidade', value: 'qtd' },
          { align: 'left', text: 'Valor Total', value: 'preco' },
          { align: 'left', text: 'Remover' }
        ],
        headersPedidoGeral: [
          { align: 'left', text: 'Numero', value: 'Id' },
          { align: 'center', text: 'Data', value: 'Data_pedido' },
          { align: 'right', text: 'Valor Total', value: 'Valor_total' }
        ],
        headersPedidoEspecifico: [
          { align: 'left', text: 'Item', value: 'Nome' },
          { align: 'center', text: 'Quantidade', value: 'Qtd' },
          { align: 'right', text: 'Valor Total', value: 'Preco' }
        ]
      }
    },
    computed: {
      routeName () {
        const {name} = this.$route
        return this.capitalizeFirstLetter(name)
      }
    },
    watch: {
      $route: 'fectchData'
    },
    mounted () {
      let callback = (val, oldVal, uri) => {
        console.log(val)
        this.show = true
      }
      this.$ls.on('pedido', callback)
    },
    created () {
      this.storage = JSON.parse(localStorage.getItem('user'))
      this.cliente.nome = this.storage.Nome
      this.cliente.id = this.storage.CodPessoa
      this.cliente.email = this.storage.Email
      this.cliente.dataCadastro = this.storage.DataCadastro
      this.setAuthorizationToken(this.storage.access_token)
    },
    methods: {
      meusPedidos () {
        this.axios.get('/pedidos', {
          params: {
            'idCliente': this.cliente.id
          }
        }).then(response => {
          this.pedidosOLD = response.data.data
          this.dialogPedido = true
        }).catch(error => {
          this.message = error
          this.$swal('Atenção', 'Você ainda não pedidos antigos', 'info')
        })
      },
      loadDetails (props) {
        console.log(props)
        props.expanded = !props.expanded
        this.axios.get('/itens', {
          params: {
            'idPedido': props.item.Id
          }
        }).then(response => {
          this.details = response.data.data
        }).catch(error => {
          this.message = error
          this.$swal('Atenção', 'Você ainda não pedidos antigos', 'info')
        })
      },
      itensPedidos (itens) {
        this.show = true
        this.pedido = []
        itens.forEach(element => {
          this.pedido.push(element)
        })
      },
      abreCarrinho () {
        if (this.pedido.length === 0) {
          this.$swal('Atenção', 'Carrinho vazio', 'info')
        } else {
          this.carrinho = true
        }
      },
      deleteItem (item) {
        let pos = this.pedido.map(function (e) { return e.id }).indexOf(item.id)
        this.pedido.splice(pos, 1)
        if (this.pedido.length === 0) {
          this.carrinho = false
          this.show = false
          this.$swal({
            title: 'Oh não!',
            text: 'O seu carrinho ficou vazio',
            imageUrl: 'https://i.ytimg.com/vi/G4JnyQZ0eFI/hqdefault.jpg',
            imageWidth: 400,
            imageHeight: 300,
            imageAlt: 'Custom image'
          })
        }
      },
      edit () {
        this.dialog = true
      },
      salvar () {
        this.axios.put('/cliente/update', this.cliente)
          .then(response => {
            if (response.data.error) {
              this.responseError(response.data.message)
            } else {
              this.$swal({
                title: 'O seu cadastro foi atualizado',
                type: 'success',
                timer: 1000
              })
            }
            this.dialog = false
            this.salvando = false
          }).catch(error => {
            this.salvando = false
            this.$swal('Atenção', 'Problemas ao salvar, entre em contato com a CDSE', 'error')
            console.log(error)
          })
      },
      fecharPedido () {
        this.salvando = true
        this.axios.post('/carrinho/buy', {
          idCliente: this.cliente.id,
          produtos: this.pedido
        }).then(response => {
          if (response.data.error) {
            this.responseError(response.data.message)
          } else {
            this.$swal({
              title: 'Compra finalizada com sucesso',
              text: 'Em poucos dias sua encomenda estara em sua casa!',
              imageUrl: 'http://pm1.narvii.com/6606/6ad1116b7511d9e21a336cde2c53040500c19742_00.jpg',
              imageWidth: 400,
              imageHeight: 300,
              imageAlt: 'Custom image'
            })
          }
          this.salvando = false
          this.carrinho = false
          this.show = false
        }).catch(error => {
          this.salvando = false
          this.$swal('Atenção', 'Problemas ao atualizar, entre em contato com a CDSE', 'error')
          console.log(error)
        })
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
      capitalizeFirstLetter (string) {
        return string.charAt(0).toUpperCase() + string.slice(1)
      },
      hideSidebar () {
        this.$sidebar.displaySidebar(false)
      },
      setAuthorizationToken ($token) {
        this.axios.defaults.headers.common['Authorization'] = $token
      }
    }
  }
</script>
<style scope lang="scss">
.tbl-details {
  border: 1px solid #00919D;
  margin: 2%;
  .v-table__overflow .v-datatable {
    thead {
      background: #00919D;
      tr:nth-child(1) {
        height: 30px!important;
        th {
          color: white;
          font-size: 14px;
        }
      }
      .v-datatable__progress {
        background: white;
      }
    }
    tbody {
      tr td {
        height: 40px!important;
      }
    }
  }
}

#style-scroll::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
	// border-radius: 10px;
}

#style-scroll::-webkit-scrollbar
{
	width: 8px;
	background-color: #F5F5F5;
}

#style-scroll::-webkit-scrollbar-thumb
{
	border-radius: 10px;
	background-color: rgb(179, 179, 184);
}

.v-list__tile__action.sidebar-icone{
  width: 20px;
  min-width: 10px;
}

.v-list__tile__action.sidebar-icone svg:active{
  color: aqua!important
}

.v-list__group__header a:hover{
  color:white!important;
}

.sidebar-append .v-list__group__header:hover{
  background: hsla(0,0%,100%,.3) !important
}

.v-list__group__items a:hover{
  color:white!important;
}

.sidebar-append .v-list__group__items a:hover{
  background: hsla(0,0%,100%,.3) !important
}

.primary--text.sidebar-click{
  color: #60ecff !important;
  caret-color: #ccc8ca !important;
}

.v-list--dense .v-list__tile:not(.v-list__tile--avatar) {
  height: 35px;
}

.sidebar-append .v-list__group__header .v-list__group__header__append-icon .v-icon{
  color: white;
  font-size: 14px
}

.v-list__group__items .theme--light .sidebar-icone .theme--light.v-icon {
  font-size: 10px;
}

.sidebar-icone .theme--light.v-icon {
  color: white;
  font-size: 18px
}

.v-list__group__items--no-action .v-list__tile {
    padding-left: 30px;
}

.v-list--dense .v-list__tile {
  font-size: 14px;
}

.sidebar-list {
  background: none !important;
  color: white !important
}

.side_itens {
  padding: 2px 0px 0px 14px;
  font-weight: 300;
}

</style>
