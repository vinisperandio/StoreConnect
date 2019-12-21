import moment from 'moment'

export default {
  install (Vue) {
    moment.locale('pt-BR')
    Vue.filter('formatDateTime', (value) => {
      if (value) return moment(String(value)).format('DD/MM/YYYY HH:mm:ss')
      else return '-'
    })
    Vue.filter('formatDate', (value) => {
      if (value) return moment(String(value)).format('DD/MM/YYYY')
      else return '-'
    })
    Vue.filter('formatDuration', (value) => {
      if (value) return String(parseInt(value / 60)) + ' min ' + String(value % 60) + ' s'
      else return '-'
    })
    Vue.filter('formatMesAno', (value) => {
      if (value) return moment(String(value)).format('MMMM [de] YYYY')
    })
    Vue.filter('formatSimples', (value) => {
      if (value) return moment(String(value)).format('MM/YYYY')
    })
    Vue.filter('Ano', (value) => {
      if (value) return moment(String(value)).format('YYYY')
    })
    Vue.prototype.moment = moment
  }
}
