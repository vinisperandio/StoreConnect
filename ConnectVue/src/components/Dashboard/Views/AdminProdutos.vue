<template>
  <div class="content">
      <div class="row justify-content-center">
        <div class="col-10">
          <template>

              <div>
                <v-toolbar flat color="white mt-4" >
                  <v-toolbar-title>Cadastrar</v-toolbar-title>
                  <v-divider
                    class="mx-2"
                    inset
                    vertical
                  ></v-divider>
                  <v-spacer></v-spacer>
                  <v-dialog v-model="dialog" max-width="500px">
                    <template v-slot:activator="{ on }">
                      <v-btn color="primary" dark class="mb-2" @click="dialog = true">Novo produto</v-btn>
                    </template>
                    <v-card>
                      <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                      </v-card-title>

                      <v-card-text>
                        <v-container grid-list-md>
                          <v-form v-model="valid" ref="form_cad" id="form_cad" @submit.prevent="salvar">
                            <v-layout wrap>
                              <v-flex xs12 sm6 md4>
                                <v-text-field v-model="editedItem.nome" label="Nome"></v-text-field>
                              </v-flex>
                              <v-flex xs12 sm6 md4>
                                <v-text-field v-model="editedItem.unidade" label="Unidade"></v-text-field>
                              </v-flex>
                              <v-flex xs12 sm6 md4>
                                <v-text-field v-model="editedItem.preco" label="valor Unid."></v-text-field>
                              </v-flex>
                            </v-layout>
                          </v-form>
                        </v-container>
                      </v-card-text>

                      <v-card-actions>
                        <v-spacer></v-spacer>
                          <v-btn color="red darken-1" :disabled="salvando" outline flat @click="cancelar">Cancelar</v-btn>
                          <v-btn :loading="salvando" color="blue darken-1" outline flat form="form_cad" type="submit">cadastrar</v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                </v-toolbar>
                <v-data-table
                  :headers="headers"
                  :items="produtos"
                  class="elevation-1">
                  <template v-slot:items="props">
                    <td class="text-xs-left">{{ props.item.Nome }}</td>
                    <td class="text-xs-left">{{ props.item.Unidade }}</td>
                    <td class="text-xs-left">R$ {{ props.item.Preco }}</td>
                    <td class="justify-right layout">
                      <v-icon small class="mr-2" @click="editItem(props.item)">edit</v-icon>
                      <v-icon small @click="deleteItem(props.item)">delete</v-icon>
                    </td>
                  </template>
                </v-data-table>
              </div>

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
        produtos: [],
        valid: false,
        editedIndex: -1,
        editedItem: {
          id: null,
          nome: null,
          unidade: null,
          preco: null
        },
        dialog: false,
        salvando: false,
        headers: [
          { align: 'left', text: 'Nome', value: 'Nome' },
          { align: 'left', text: 'Quantidade', value: 'Unidade' },
          { align: 'left', text: 'Preco Unid.', value: 'Preco' },
          { align: 'left', text: 'Ação' }
        ]
      }
    },
    computed: {
      formTitle () {
        return this.editedItem.id === null ? 'Novo Produto' : 'Editar Produto'
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
      cancelar () {
        this.dialog = false
        this.resetVar()
      },
      resetVar () {
        this.editedItem.id = null
        this.editedItem.nome = null
        this.editedItem.unidade = null
        this.editedItem.preco = null
      },
      editItem (item) {
        this.editedItem.id = item.Id
        this.editedItem.nome = item.Nome
        this.editedItem.unidade = item.Unidade
        this.editedItem.preco = item.Preco
        this.dialog = true
      },
      deleteItem (item) {
        this.$swal({
          title: 'Tem certeza que deseja excluir este Produto' + '?',
          text: 'O Produto será excluído do sistema!',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sim, excluir!',
          cancelButtonText: 'Não',
          showLoaderOnConfirm: true,
          allowOutsideClick: false,
          preConfirm: () => {
            return this.axios.delete('/produto/delete', {params: {id: item.Id}}).then(response => {
              return response.data
            })
          }
        }).then((result) => {
          if (result.value) {
            if (result.value.erro) {
              this.$swal({
                title: 'Não foi possível remover o Produto',
                type: 'error',
                text: result.value.message
              })
            } else {
              this.loading = true
              this.getProdutos()
              this.$swal(
                'Excluído!',
                'O Produto foi excluído',
                'success'
              )
            }
          }
        })
      },
      salvar () {
        this.salvando = true
        this.editedItem.preco = this.editedItem.preco ? this.editedItem.preco.replace(',', '.') : null
        if (this.editedItem.id) {
          this.axios.put('/produto/update', this.editedItem).then(response => {
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
              this.getProdutos()
            }
            this.salvando = false
          }).catch(error => {
            this.salvando = false
            this.message = error.response.data.data
            this.loader = false
            this.snackbar = true
          })
        } else {
          this.axios.post('/produto/save', this.editedItem).then(response => {
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
              this.getProdutos()
            }
            this.salvando = false
          }).catch(error => {
            this.salvando = false
            this.message = error.response.data.data
            this.loader = false
            this.snackbar = true
          })
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
