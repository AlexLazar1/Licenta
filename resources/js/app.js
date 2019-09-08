import { InertiaApp } from '@inertiajs/inertia-vue'
import PortalVue from 'portal-vue'
import VueQuagga from 'vue-quaggajs';
import VuePhoneNumberInput from 'vue-phone-number-input';
import 'vue-phone-number-input/dist/vue-phone-number-input.css';
import Vue from 'vue'

Vue.config.productionTip = false
Vue.mixin({ methods: { route: (...args) => window.route(...args).url() } })
Vue.use(InertiaApp)
Vue.use(PortalVue)
Vue.use(VueQuagga);
Vue.component('vue-phone-number-input', VuePhoneNumberInput);


let app = document.getElementById('app')

new Vue({
  render: h => h(InertiaApp, {
    props: {
      initialPage: JSON.parse(app.dataset.page),
      resolveComponent: name => import(`@/Pages/${name}`).then(module => module.default),
    },
  }),
}).$mount(app)
